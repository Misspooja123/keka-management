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
                @can('role_create')
                    <button id="addRoleButton" class="btn btn-primary float-right">Add Role</button>
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
                                <label> <input class="form-check-input mt-1" type="checkbox" id="select-all-roles"
                                        name="module_permission[]">Permission :</label>
                            </div></br>

                            @foreach ($dashboard_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permission[]" value="{{ $module }}"> Dashboard
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
                                                name="module_permission[]" value="{{ $module }}">Attendance
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
                                                name="module_permission[]" value="{{ $module }}">Leave :</label>
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
                                                name="module_permission[]" value="{{ $module }}">Department
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
                                                name="module_permission[]" value="{{ $module }}">Employee
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
                                                name="module_permission[]" value="{{ $module }}">Marksheet
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
                                                name="module_permission[]" value="{{ $module }}">Role
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
                                                name="module_permission[]" value="{{ $module }}">AdminUser
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

    <!-- Edit modal -->

    <div class="modal" id="editRoleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeedit">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editRoleForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-roleId">
                        <div class="form-group">
                            <label for="RoleName">Role Name :</label>
                            <input type="text" class="form-control" id="editroleName" name="name"
                                style="width: 970px">
                            <div class="error-message text-danger"></div>
                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label> <input class="form-check-input mt-1" type="checkbox" id="edit-select-all-roles"
                                        name="module_permission[]">Permission :</label>
                            </div></br>

                            @foreach ($dashboard_module as $module)
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-check-inline" style="width: 140px">
                                        <label> <input class="form-check-input mt-1" type="checkbox"
                                                name="module_permission[]" value="{{ $module }}"
                                                id="dashboardCheckbox"> Dashboard
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
                                                name="module_permission[]" value="{{ $module }}">Attendance
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
                                                name="module_permission[]" value="{{ $module }}">Leave :</label>
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
                                                name="module_permission[]" value="{{ $module }}">Department
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
                                                name="module_permission[]" value="{{ $module }}">Employee
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
                                                name="module_permission[]" value="{{ $module }}">Marksheet
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
                                                name="module_permission[]" value="{{ $module }}">Role
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
                                                name="module_permission[]" value="{{ $module }}">AdminUser
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
                        <button type="button" class="btn btn-secondary" id="editclosed"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="editbtn">Update</button>
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

            // Check/uncheck all checkboxes when "Select Module and Permission" is clicked
            $(document).ready(function() {
                $('#select-all-roles').change(function() {
                    $('input[name="module_permissions[]"]').prop('checked', $(this).prop(
                        'checked'));
                    $('input[name="module_permission[]"]').prop('checked', $(this).prop(
                        'checked'));
                });
                $('input[name="module_permissions[]"]').change(function() {
                    if (!$(this).prop('checked')) {
                        $('#select-all-roles').prop('checked', false);
                    }
                });
                $('input[name="module_permissions[]"]').change(function() {
                    if (!$(this).prop('checked')) {
                        $('#edit-select-all-roles').prop('checked', false);
                    }
                });
            });

            // Check/uncheck associated permission checkboxes when a module checkbox is clicked
            $(document).ready(function() {
                $('input[name^="module_permission"]').change(function() {
                    var moduleId = $(this).val();
                    $('input[id^="' + moduleId + '_"]').prop('checked', $(this).prop('checked'));
                });
            });

            // Select all for edit popup modal
            $(document).ready(function() {
                $('#edit-select-all-roles').change(function() {
                    $('input[name="module_permissions[]"]').prop('checked', $(this).prop(
                        'checked'));
                    $('input[name="module_permission[]"]').prop('checked', $(this).prop(
                        'checked'));
                });
                $('input[name="module_permissions[]"]').change(function() {
                    if (!$(this).prop('checked')) {
                        $('#select-all-roles').prop('checked', false);
                    }
                });
            });

            function resetForm() {
                $('#addRoleForm')[0].reset();
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

            });

            $(document).ready(function() {
                $('#addRoleForm').submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('roles.store') }}',
                        data: $(this).serialize(),
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Role added successfully.',
                                icon: 'success',
                            });
                            resetForm();
                            $('#addRoleModal').modal('hide');
                            var dataTable = $('#role-table')
                                .DataTable();
                            dataTable.ajax.reload();
                            resetForm();
                            console.log(response);
                        },
                        error: function(error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred. Please try again.',
                                icon: 'error',
                            });
                            resetForm();
                            console.log(error);
                        }
                    });
                });
            });

            //Edit Roles
            $(document).ready(function() {
                $('#editclose').click(function() {
                    $('#editRoleModal').modal('hide');
                    resetForm();
                });
                $('#editclosed').click(function() {
                    $('#editRoleModal').modal('hide');
                    resetForm();
                });
                $('#closeedit').click(function() {
                    $('#editRoleModal').modal('hide');
                    resetForm();
                });

            });

            function reset_Form() {
                $('#editRoleForm')[0].reset();
                $('#editRoleForm .error-message').text('');
            }

            $('#role-table').on('click', '.edit_btn', function() {

                $('#editRoleModal').modal('show');
                $('#editRoleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                reset_Form();
                var editRoleId = $(this).data('id');
                console.log(editRoleId);
                $.ajax({
                    type: 'GET',
                    url: "{{ route('roles.edit', ':id') }}".replace(
                        ':id', editRoleId),
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        console.log(response);
                        $('#edit-roleId').val(response.id);
                        $('#editroleName').val(response.name);

                        $.each(response.permission, function(index, permission) {
                            $('[name="module_permissions[]"][value="' + permission
                                .name + '"]').prop('checked', true);
                        });
                        $('#editRoleModal').modal('show');
                    },
                    error: function(error) {
                        Swal.fire('Error',
                            'Failed to retrieve leave record.',
                            'error');
                    }
                });
            });

            $('#editRoleForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'PUT',
                    url: "{{ route('roles.update', ':id') }}".replace(':id', $('#edit-roleId')
                        .val()),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Role updated successfully.',
                            icon: 'success',
                        });

                        $('#editRoleModal').modal('hide');
                        var dataTable = $('#role-table')
                            .DataTable();
                        dataTable.ajax.reload();
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                        });
                        console.log(error);
                    }
                });
            });


            // Delete role
            $(document).on('click', '.delete-btn', function() {
                var roleId = $(this).data('id');

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
                            url: '/admin/roles/' + roleId,
                            dataType: 'json',
                            success: function(data) {
                                Swal.fire('Deleted!',
                                    'The roles has been deleted.',
                                    'success');
                                var dataTable = $('#role-table')
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

        });
    </script>
@endpush
