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

@include('admin.auth.role.create')

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



        });
    </script>
@endpush
