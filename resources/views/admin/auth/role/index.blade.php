@extends('admin.layouts.master')

@section('content')
    <style>
        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Manage Role
                <button id="addRoleButton" class="btn btn-primary float-right">Add Role</button>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="data-table">
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Role Modal -->
    <div class="modal" id="addRoleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addRoleForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="RoleName">Role Name :</label>
                            <input type="text" class="form-control" id="roleName" name="name" style="width: 970px">
                            <div class="error-message text-danger"></div>
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label> <input class="form-check-input" type="checkbox" id="select-all-roles"
                                        name="module_permissions[]">Permission :</label>
                            </div></br>

                            @foreach ($dashboard_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}"> Dashboard
                                            :</label><br>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($dashboard_name as $name)
                                            <div class="form-check form-check-inline " style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($attendance_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}">Attendance
                                            :</label><br>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($attendance_name as $name)
                                            <div class="form-check form-check-inline" style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($leave_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}">Leave :</label>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($leave_name as $name)
                                            <div class="form-check form-check-inline" style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($department_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}">Department
                                            :</label><br>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($department_name as $name)
                                            <div class="form-check form-check-inline" style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($employee_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}">Employee
                                            :</label><br>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($employee_name as $name)
                                            <div class="form-check form-check-inline" style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($marksheet_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}">Marksheet
                                            :</label><br>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($marksheet_name as $name)
                                            <div class="form-check form-check-inline" style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($role_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}">Role
                                            :</label><br>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($role_name as $name)
                                            <div class="form-check form-check-inline" style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($adminuser_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permissions[]" value="{{ $module }}">AdminUser
                                            :</label><br>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        @foreach ($adminuser_name as $name)
                                            <div class="form-check form-check-inline" style="width: 200px">
                                                <input class="form-check-input mt-1" type="checkbox"
                                                    name="module_permissions[]" value="{{ $name }}"
                                                    id="{{ $module . '_' . $name }}">
                                                <label class="form-check-label"
                                                    for="{{ $module . '_' . $name }}">{{ $name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closed"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveRoleData">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Check/uncheck all checkboxes when "Select Module and Permission" is clicked
            $(document).ready(function() {
                $('#select-all-roles').change(function() {
                    $('input[name="module_permissions[]"]').prop('checked', $(this).prop(
                        'checked'));
                });
                $('input[name="module_permissions[]"]').change(function() {
                    if (!$(this).prop('checked')) {
                        $('#select-all-roles').prop('checked', false);
                    }
                });
            });

            // Check/uncheck associated permission checkboxes when a module checkbox is clicked
            $(document).ready(function() {
                $('input[name^="module_permissions"]').change(function() {
                    var moduleId = $(this).val();
                    $('input[id^="' + moduleId + '_"]').prop('checked', $(this).prop('checked'));
                });
            });

            function resetForm() {
                // Reset form fields
                $('#addRoleForm')[0].reset();
                // Clear validation error messages
                $('#addRoleForm .error-message').text('');
            }

            // Add in Role table
            $(document).ready(function() {
                $('#addRoleButton').click(function() {
                    $('#addRoleModal').modal('show');
                });
                $('#addRoleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('.close').click(function() {
                    $('#addRoleModal').modal('hide');
                    resetForm();
                });

                $('#closed').click(function() {
                    $('#addRoleModal').modal('hide');
                    resetForm();
                });

                $("#addRoleForm").validate({
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().find('.error-message'));
                    },
                    rules: {
                        name: {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "Please enter a role name.",
                        },
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('departments.store') }}",
                            data: $(form).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Department added successfully.',
                                    icon: 'success',
                                }).then(function() {
                                    $('#addDepartmentModal').modal('hide');
                                    var dataTable = $('#department-table')
                                        .DataTable();
                                    dataTable.ajax.reload();
                                    resetForm();
                                });
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'An error occurred. Please try again.',
                                    icon: 'error',
                                });
                                resetForm();
                            },
                        });
                    }
                });
            });




        });
    </script>
@endpush
