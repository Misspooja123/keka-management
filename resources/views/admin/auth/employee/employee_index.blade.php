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
                Manage Employee
                @can('employee_create')
                    <button id="addEmployeeButton" class="btn btn-primary float-right">Add Employee</button>
                @endcan
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

    <!-- Add Department Modal -->
    <div class="modal" id="addEmployeeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closed">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="addEmployeeForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select class="form-control" id="department_id" name="department_id" required>
                                <option value="">Select Department</option>

                                @foreach ($departments as $department)
                                    @if ($department->status == 1)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="mobile_no">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no">
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        {{-- <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="editclosed">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select class="form-control" id="editdepartment_id" name="department_id" required>
                                <option value="">Select Department</option>

                                @foreach ($departments as $department)
                                    @if ($department->status == 1)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required disabled>
                        </div>
                        {{-- <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="editpassword" name="password" required disabled>
                        </div> --}}
                        <div class="form-group">
                            <label for="mobile_no">Mobile Number</label>
                            <input type="text" class="form-control" id="editMobileNo" name="mobile_no">
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="editAddress" name="address"></textarea>
                            <div class="error-message text-danger"></div>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        {{-- <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="editStatus" name="status" disabled>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="editclose">Close</button>
                        <button type="submit" class="btn btn-primary" id="update_user">Update</button>
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
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                function resetForm() {
                    // Reset form fields
                    $('#addEmployeeForm')[0].reset();
                    // Clear validation error messages
                    $('#addEmployeeForm .error-message').text('');
                }
                $('#addEmployeeButton').click(function() {
                    $('#addEmployeeModal').modal('show');
                });
                $('#addEmployeeModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#close').click(function() {
                    $('#addEmployeeModal').modal('hide');
                    resetForm();
                });

                $('#closed').click(function() {
                    $('#addEmployeeModal').modal('hide');
                    resetForm();
                });

                $("#addEmployeeForm").validate({
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().find('.error-message'));
                    },
                    rules: {
                        name: {
                            required: true,
                        },
                        department_id: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true,
                            remote: '/admin/validate-email'
                        },
                        password: {
                            required: true,
                        },
                        mobile_no: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            number: true,
                            remote: '/admin/validate-mobile'
                        },
                        address: {
                            required: true,
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter a Employee name.",
                        },
                        department_id: {
                            required: "Please select department name",
                        },
                        email: {
                            required: "Please enter email",
                            remote: "Email already exist"
                        },
                        password: {
                            required: "Please enter password",
                        },
                        mobile_no: {
                            required: "Please enter mobile number",
                            minlength: "please enter 10 digits",
                            maxlength: "Please enter 10 digits",
                            number: "Enter number only",
                            remote: "Mobile number already exist"
                        },
                        address: {
                            required: "Please enter address",
                        },
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: "{{ route('employees.store') }}",
                            method: "POST",
                            data: $(form).serialize(),
                            success: function(response) {
                                $("#addEmployeeModal").modal('hide');
                                Swal.fire('Success',
                                    'employee submitted successfully...',
                                    'success');
                                //   $('#addEmployeeForm').reload();

                                var dataTable = $('#employee-table')
                                    .DataTable();
                                dataTable.ajax.reload();
                                resetForm();

                            },
                            // error: function(error) {
                            //     Swal.fire('Error',
                            //         'An error occurred while processing your request.',
                            //         'error');
                            // }
                            error: function(data) {
                                if (data.status === 422) {
                                    var errors = $.parseJSON(data.responseText);
                                    console.log(errors)
                                    $.each(errors.errors, function(key, value) {
                                        $('#addEmployeeForm').find(
                                                'input[name=' +
                                                key + ']')
                                            .parents('.form-group')
                                            .find('.error-msg-input').html(
                                                value);
                                        $('#addEmployeeForm').find(
                                                'textarea[name=' + key +
                                                ']')
                                            .parents('.form-group')
                                            .find('.error-msg-input').html(
                                                value);

                                    });
                                }
                                //  resetForm();
                            }
                        });
                    }
                });

                $(document).on('click', '.delete-btn', function() {
                    var empId = $(this).data('id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: '/admin/employee/' + empId,
                                dataType: 'json',
                                success: function(data) {
                                    Swal.fire('Deleted!',
                                        'The employee has been deleted.',
                                        'success');
                                    var dataTable = $('#employee-table')
                                        .DataTable();
                                    dataTable.ajax.reload();
                                    $(this).closest('tr').remove();
                                },
                                error: function(data) {

                                    Swal.fire('Error', 'Something went wrong.',
                                        'error');
                                    console.log(data);
                                }
                            });
                        }
                    });
                });

                function resetEditForm() {
                    // Reset form fields
                    $('#editUserForm')[0].reset();
                    // Clear validation error messages
                    $('#editUserForm .error-message').text('');
                }

                $('#employee-table').on('click', '.status-btn', function() {
                    var empId = $(this).data('id');
                    var newStatus = $(this).data('status');
                    $.ajax({
                        type: 'PUT',
                        url: "{{ route('employees.status', ':id') }}".replace(
                            ':id',
                            empId),
                        data: {
                            status: newStatus,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (newStatus == 0) {
                                Swal.fire('Success',
                                    'Department is Active',
                                    'success');
                                var dataTable = $('#employee-table')
                                    .DataTable();
                                dataTable.ajax.reload();
                                $(this).html(
                                        '<i class="fas fa-toggle-off"></i> Inactive')
                                    .removeClass('btn-success').addClass(
                                        'btn-secondary').data(
                                        'status', 0);
                            } else {
                                Swal.fire('Success',
                                    'Department is Inactive',
                                    'success');
                                var dataTable = $('#employee-table')
                                    .DataTable();
                                dataTable.ajax.reload();
                                $(this).html('<i class="fas fa-toggle-on"></i> Active')
                                    .removeClass(
                                        'btn-secondary').addClass('btn-success').data(
                                        'status', 1);
                            }
                        },
                        error: function(data) {
                            Swal.fire('Error', 'Something went wrong.', 'error');
                            console.log(data);
                        }
                    });
                });

                $('#editclose').click(function() {
                    $('#editUserModal').modal('hide');
                    resetEditForm();
                });

                $('#editclosed').click(function() {
                    $('#editUserModal').modal('hide');
                    resetEditForm();
                });

                $('#editUserForm').validate({
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().find('.error-message'));
                    },
                    rules: {
                        department_id: {
                            required: true,
                        },
                        mobile_no: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            number: true,
                            remote: '/admin/validate-mobile'
                        },
                        address: {
                            required: true,
                        }
                    },
                    messages: {
                        department_id: {
                            required: "Please select department name",
                        },
                        mobile_no: {
                            required: "Please enter mobile number",
                            minlength: "please enter 10 digits",
                            maxlength: "Please enter 10 digits",
                            number: "Enter number only",
                            remote: "Mobile number already exist"
                        },
                        address: {
                            required: "Please enter address",
                        }
                    },
                });
                // Edit Button Click admin side
                $('#employee-table').on('click', '.edit_btn', function() {
                    $('.edit_btn').click(function() {
                        $('#editUserModal').modal('show');
                    });
                    $('#editUserModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    var empId = $(this).data('id');

                    $.ajax({
                        type: 'GET',
                        url: "{{ route('employees.edit', ':id') }}".replace(
                            ':id', empId),
                        dataType: 'json',
                        success: function(response) {
                            $('#editUserId').val(response.id);

                            $('#editdepartment_id').val(response.department_id);
                            $('#editName').val(response.name);
                            $('#editEmail').val(response.email);
                            $('#editpassword').val(response.password);
                            $('#editMobileNo').val(response.mobile_no);
                            $('#editAddress').val(response.address);
                            $('#editStatus').val(response.status);

                            $('#editUserModal').modal('show');
                        },
                        error: function(error) {
                            Swal.fire('Error',
                                'Failed to retrieve leave record.',
                                'error');
                        }
                    });
                });

                // Update Button Click
                $('#update_user').click(function(event) {
                    event.preventDefault();
                    if ($(this).valid()) {
                        var empId = $('#editUserId').val();

                        var department_id = $('#editdepartment_id').val();
                        var mobile_no = $('#editMobileNo').val();
                        var address = $('#editAddress').val();
                        var status = $('#editStatus').val();

                        $.ajax({
                            type: 'PUT',
                            url: "{{ route('employees.update', ':id') }}".replace(
                                ':id',
                                empId),
                            data: {
                                department_id: department_id,
                                mobile_no: mobile_no,
                                address: address,
                                status: status
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#editUserModal').modal('hide');
                                    Swal.fire('Success',
                                        'Employee record updated successfully',
                                        'success');
                                    var dataTable = $('#employee-table')
                                        .DataTable();
                                    dataTable.ajax.reload();
                                    resetEditForm();
                                } else {
                                    Swal.fire('Error',
                                        'Failed to update employee record.',
                                        'error');
                                    resetEditForm();
                                }
                            },
                            error: function(error) {
                                Swal.fire('Error',
                                    'Failed to update employee record.',
                                    'error');
                                resetEditForm();
                            }
                        });
                    }
                });


            });
        });
    </script>
@endpush
