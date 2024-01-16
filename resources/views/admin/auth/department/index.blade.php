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
                Manage Department
                @can('department_create')
                    <button id="addDepartmentButton" class="btn btn-primary float-right">Add Department</button>
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
    <div class="modal" id="addDepartmentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="addDepartmentForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="departmentName">Department Name</label>
                            <input type="text" class="form-control" id="departmentName" name="name">
                            <div class="error-message text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closed" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_edit">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editDepartmentForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editDepartmentName">Department Name</label>
                            <input type="text" class="form-control" id="editDepartmentName" name="name">
                            <div class="error-message text-danger"></div>
                        </div>
                    </div>
                    <input type="hidden" id="editrecord" name="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="close_eedit">Close</button>
                        <button type="submit" class="btn btn-primary" id="departmentedit">Save Changes</button>
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

            function resetForm() {
                // Reset form fields
                $('#addDepartmentForm')[0].reset();
                // Clear validation error messages
                $('#addDepartmentForm .error-message').text('');
            }

            $(document).ready(function() {
                $('#addDepartmentButton').click(function() {
                    $('#addDepartmentModal').modal('show');
                });
                $('#addDepartmentModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('.close').click(function() {
                    $('#addDepartmentModal').modal('hide');
                    resetForm();
                });

                $('#closed').click(function() {
                    $('#addDepartmentModal').modal('hide');
                    resetForm();
                });

                $("#addDepartmentForm").validate({
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().find('.error-message'));
                    },
                    rules: {
                        name: {
                            required: true,
                            remote: '/admin/validate-name'
                        },
                    },
                    messages: {
                        name: {
                            required: "Please enter a department name.",
                            remote: "Department name already exist"
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


                $(document).on('click', '.delete-btn', function() {
                    //$('.delete-btn').on('click', function () {
                    console.log('Button clicked');
                    var departmentId = $(this).data('id');

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
                                url: '/admin/department/' + departmentId,
                                dataType: 'json',
                                success: function(data) {
                                    Swal.fire('Deleted!',
                                        'The department has been deleted.',
                                        'success');
                                    var dataTable = $('#department-table')
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
                    $('#editDepartmentForm')[0].reset();
                    // Clear validation error messages
                    $('#editDepartmentForm .error-message').text('');
                }

                $('#editDepartmentForm').click(function() {
                    $('#editDepartmentModal').modal('show');
                });
                $('#close_edit').click(function() {
                    $('#editDepartmentModal').modal('hide');
                    resetEditForm();
                });
                $('#close_eedit').click(function() {
                    $('#editDepartmentModal').modal('hide');
                    resetEditForm();
                });

                $('#editDepartmentForm').validate({
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
                            required: "Please enter a department name!!!.",
                        },
                    },
                });
                // Edit Button Click user side
                $('#department-table').on('click', '.edit_btn', function() {

                    $('#editDepartmentModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    var deptId = $(this).data('id');

                    $.ajax({
                        type: 'GET',
                        url: "{{ route('department.edit', ':id') }}".replace(
                            ':id', deptId),
                        dataType: 'json',
                        success: function(response) {
                            $('#editDepartmentName').val(response.name);
                            $('#editrecord').val(response.id);
                            $('#editDepartmentModal').modal('show');
                        },
                        error: function(error) {
                            Swal.fire('Error',
                                'Failed to retrieve leave record.',
                                'error');
                        }
                    });
                });
                // Update Button Click
                $('#departmentedit').click(function(event) {
                    event.preventDefault();
                    if ($(this).valid()) {

                        var deptId = $('#editrecord').val();
                        var name = $('#editDepartmentName').val();

                        $.ajax({
                            type: 'PUT',
                            url: "{{ route('department.update', ':id') }}".replace(
                                ':id',
                                deptId),
                            data: {
                                name: name
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#editDepartmentModal').modal('hide');
                                    Swal.fire('Success',
                                        'Department record updated successfully',
                                        'success');
                                    var dataTable = $('#department-table')
                                        .DataTable();
                                    dataTable.ajax.reload();
                                    resetEditForm();
                                } else {
                                    Swal.fire('Error',
                                        'Failed to update department record.',
                                        'error');
                                    resetEditForm();
                                }
                            },
                            error: function(error) {
                                Swal.fire('Error',
                                    'Failed to update department record.',
                                    'error');
                                resetEditForm();
                            }
                        });
                    }
                });

                $('#department-table').on('click', '.status-btn', function() {
                    var departmentId = $(this).data('id');
                    var newStatus = $(this).data('status');

                    $.ajax({
                        type: 'PUT',
                        url: "{{ route('department.status', ':id') }}".replace(
                            ':id',
                            departmentId),
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
                                var dataTable = $('#department-table')
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
                                var dataTable = $('#department-table')
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

            });
        });
    </script>
@endpush
