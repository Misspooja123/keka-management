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
                Manage AdminUser
                @can('adminuser_create')
                    <button id="addadminuserButton" class="btn btn-primary float-right">Add AdminUser</button>
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

    <!-- Add User Modal -->
    <div class="modal" id="addroleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Admin User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closed">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addAdminUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Roles</label>
                            <select class="form-control" id="role_id" name="role_id" required>
                                <option value="">Select Role</option>

                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
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

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="close">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
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
                    <h5 class="modal-title" id="editUserModalLabel">Edit Admin User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="editclosed">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group">
                            <label for="department_id">Role</label>
                            <select class="form-control" id="editdepartment_id" name="role_id" required>
                                <option value="">Select Role</option>

                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
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
                    $('#addAdminUserForm')[0].reset();
                    // Clear validation error messages
                    $('#addAdminUserForm .error-message').text('');
                }
                $('#addadminuserButton').click(function() {
                    $('#addroleModal').modal('show');
                });
                $('#addroleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#close').click(function() {
                    $('#addroleModal').modal('hide');
                    resetForm();
                });

                $('#closed').click(function() {
                    $('#addroleModal').modal('hide');
                    resetForm();
                });

                $("#addAdminUserForm").validate({
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().find('.error-message'));
                    },
                    rules: {
                        name: {
                            required: true,
                        },
                        role_id: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true,
                            remote: '/admin/validate-admin-email'
                        },
                        password: {
                            required: true,
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter a user name.",
                        },
                        role_id: {
                            required: "Please select role name",
                        },
                        email: {
                            required: "Please enter email",
                            remote: "Email already exist"
                        },
                        password: {
                            required: "Please enter password",
                        }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: "{{ route('adminusers.store') }}",
                            method: "POST",
                            data: $(form).serialize(),
                            success: function(response) {
                                $("#addroleModal").modal('hide');
                                Swal.fire('Success',
                                    'admin user submitted successfully...',
                                    'success');
                                //   $('#addEmployeeForm').reload();
                                var dataTable = $('#adminuser-table')
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
                                        $('#addAdminUserForm').find(
                                                'input[name=' +
                                                key + ']')
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
                    role_id: {
                        required: true,
                    }
                },
                messages: {
                    role_id: {
                        required: "Please select role name",
                    }
                },
            });
            // Edit Button Click admin side
            $('#adminuser-table').on('click', '.edit_btn', function() {
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
                    url: "{{ route('adminuser.edit', ':id') }}".replace(
                        ':id', empId),
                    dataType: 'json',
                    success: function(response) {
                        $('#editUserId').val(response.id);

                        $('#editdepartment_id').val(response.role_id);
                        $('#editName').val(response.name);
                        $('#editEmail').val(response.email);
                        $('#editpassword').val(response.password);

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

                    var role_id = $('#editdepartment_id').val();

                    $.ajax({
                        type: 'PUT',
                        url: "{{ route('adminuser.update', ':id') }}".replace(
                            ':id',
                            empId),
                        data: {
                            role_id: role_id
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#editUserModal').modal('hide');
                                Swal.fire('Success',
                                    'Admin user updated successfully',
                                    'success');
                                var dataTable = $('#adminuser-table')
                                    .DataTable();
                                dataTable.ajax.reload();
                                resetEditForm();
                            } else {
                                Swal.fire('Error',
                                    'Failed to update Admin user record.',
                                    'error');
                                resetEditForm();
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error',
                                'Failed to update Admin user record.',
                                'error');
                            resetEditForm();
                        }
                    });
                }
            });


        });
    </script>
@endpush
