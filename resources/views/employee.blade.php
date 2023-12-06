@extends('layouts.app1')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="width: 4cm;">
                        @if (!in_array($userDepartment, $selectedDepartments))
                            {{ $userDepartment }}
                        @else
                            {{ count($selectedDepartments) > 1 ? count($selectedDepartments) . ' Selected' : $userDepartment }}
                        @endif

                    </a>
                    <ul class="dropdown-menu" style="">
                        <li class="p-2">
                            <input type="checkbox" id="select-all-departments" class="me-2"> Select All
                        </li>
                        @foreach ($departments as $department)
                            <li class="p-2">
                                <input type="checkbox" name="selected_departments[]" autocomplete="off" class="me-2"
                                    value="{{ $department->id }}"
                                    {{ in_array($department->id, $selectedDepartments) || $department->name === $userDepartment ? 'checked' : '' }}>
                                {{ $department->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col">
                <!-- Search Bar -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="departmentName" id="employee-search"
                        placeholder="Search Employees">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="search-button" type="button">Search</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="row row-cols-md-4" id="employee-container">
            <!-- Employee records will be dynamically added here -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Function to load and display employees
            function loadEmployees(selectedDepartments) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get-employees') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        selected_departments: selectedDepartments
                    },
                    success: function(data) {
                        var employees = data.employees;
                        var employeeContainer = $('#employee-container');
                        employeeContainer.empty();

                        $.each(employees, function(index, employee) {
                            var col = $('<div class="col p-2"></div>');
                            var card = $('<div class="card mb-3"></div>');
                            var cardBody = $('<div class="card-body"></div>');
                            var name = $('<h2 class="card-title">' + employee.name + '</h2>');
                            var department = employee.department ?
                                '<p class="card-text">Department: ' + employee.department.name +
                                '</p>' : '<p class="card-text">Department: Unknown</p>';
                            var address = employee.address ? '<p class="card-text">Address: ' +
                                employee.address + '</p>' :
                                '<p class="card-text">Address: Unknown</p>';
                            var email = employee.email ? '<p class="card-text">Email: ' +
                                employee.email + '</p>' :
                                '<p class="card-text">Email: Unknown</p>';
                            var mobileNo = employee.mobile_no ?
                                '<p class="card-text">Mobile No: ' + employee.mobile_no +
                                '</p>' : '<p class="card-text">Mobile No: Unknown</p>';
                            cardBody.append(name, department, address, email, mobileNo);
                            card.append(cardBody);
                            col.append(card);
                            employeeContainer.append(col);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            }

            // Initialize selected departments based on checked checkboxes
            var selectedDepartments = $('input[name="selected_departments[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            // Check login user's department checkbox by default
            var loginDepartmentCheckbox = $(
                'input[name="selected_departments[]"][value="{{ $userDepartmentId }}"]');
            if (loginDepartmentCheckbox.length > 0) {
                loginDepartmentCheckbox.prop('checked', true);
                selectedDepartments.push("{{ $userDepartmentId }}");
            }

            // Load and display employees on page load
            loadEmployees(selectedDepartments);

            // Handle department checkbox changes
            $('input[name="selected_departments[]"]').change(function() {
                var selectedDepartments = $('input[name="selected_departments[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                loadEmployees(selectedDepartments);
            });

            // Handle "Select All" checkbox
            $('#select-all-departments').change(function() {
                var isChecked = $(this).prop('checked');
                $('input[name="selected_departments[]"]').prop('checked', isChecked);
                var selectedDepartments = $('input[name="selected_departments[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                loadEmployees(selectedDepartments);
                updateSelectedCount();
            });

            function updateSelectedCount() {
                var selectedCount = $('.dropdown-menu input[type="checkbox"]:checked').not(
                    '#select-all-departments').length;
                $('#select-all-departments').prop('checked', selectedCount === $(
                    '.dropdown-menu input[type="checkbox"]').not('#select-all-departments').length);
                var text;
                if (selectedCount === 1) {
                    text = '{{ $userDepartment }}';
                } else {
                    text = selectedCount + ' Selected';
                }
                $('.btn.btn-primary.dropdown-toggle').text(text);
            }

            $('.dropdown-menu input[type="checkbox"]').change(function() {
                updateSelectedCount();

            });

            // Add this code inside your existing JavaScript code
            $('#search-button').click(function() {
                var departmentName = $('#employee-search').val();
                var selectedDepartments = [];

                // Get the IDs of selected departments
                $('input[name="selected_departments[]"]:checked').each(function() {
                    selectedDepartments.push($(this).val());
                });
                if (selectedDepartments.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('search-employees') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            departmentName: departmentName,
                            selected_departments: selectedDepartments
                        },
                        success: function(data) {
                            var employees = data.employees;
                            var employeeContainer = $('#employee-container');
                            employeeContainer.empty();

                            $.each(employees, function(index, employee) {
                                var col = $('<div class="col p-2"></div>');
                                var card = $('<div class="card mb-3"></div>');
                                var cardBody = $('<div class="card-body"></div>');
                                var name = $('<h2 class="card-title">' + employee.name +
                                    '</h2>');
                                var department = employee.department ?
                                    '<p class="card-text">Department: ' + employee
                                    .department.name +
                                    '</p>' :
                                    '<p class="card-text">Department: Unknown</p>';
                                var address = employee.address ?
                                    '<p class="card-text">Address: ' +
                                    employee.address + '</p>' :
                                    '<p class="card-text">Address: Unknown</p>';
                                var email = employee.email ?
                                    '<p class="card-text">Email: ' +
                                    employee.email + '</p>' :
                                    '<p class="card-text">Email: Unknown</p>';
                                var mobileNo = employee.mobile_no ?
                                    '<p class="card-text">Mobile No: ' + employee
                                    .mobile_no +
                                    '</p>' :
                                    '<p class="card-text">Mobile No: Unknown</p>';
                                cardBody.append(name, department, address, email,
                                    mobileNo);
                                card.append(cardBody);
                                col.append(card);
                                employeeContainer.append(col);
                            });
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });


                }
                else
                {
                    Swal.fire('Error', 'Please select at least one department to search.',
                            'error');
                }
            });


        });

    </script>
@endpush
