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
            <div class="card-header">Manage Users Attendance</div>
            <div class="card-body">
                <div class="form-group">
                    <label><strong>Attendance Status :</strong></label>
                    <select id="clockin-clockout" class="form-control filter-status" style="width: 150px">
                        <option value="">---Select Status---</option>
                        <option value="1">Clock In</option>
                        <option value="0">Clock Out</option>
                    </select>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container">
        <div class="card">
            <div class="card-header">Manage Users Attendance</div>
            <div class="card-body">
                <div class="table-container">
                    <table class="data-table">
                        <label><strong>Attendance Status :</strong></label>
                        <select id="status-filter" class="form-control filter-status" style="width: 150px">
                            <option value="">---Select type---</option>
                            <option value="1">Clock-in</option>
                            <option value="2">Clock-out</option>
                        </select>
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>

            </div>
        </div>
    </div> --}}

    {{-- modal popup for edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Time</h5>
                        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <!-- Date Picker Inputs for starttime and endtime -->
                        <label for="edit-starttime">Start Time:</label>
                        <input type="datetime-local" id="edit-starttime" class="form-control" name="starttime">


                        <label for="edit-endtime">End Time:</label>
                        <input type="datetime-local" id="edit-endtime" class="form-control" name="endtime">


                        <input type="hidden" id="edit-record-id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_btn">Close</button>
                        <button type="button" class="btn btn-primary" id="save-edit">Save</button>
                    </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        // $("#attendance-table").on('preXhr.dt', function(e, settings, data) {
        //     data.status = $("#clockin-clockout").val();
        // });
        // $('.filter-status').on('change', function(e) {
        //     window.LaravelDataTables["attendance-table"].draw()
        //     e.preventDefault();
        // });
        $('#clockin-clockout').on('change', function(e) {
            var status = $(this).val();
            window.LaravelDataTables["attendance-table"].column(4).search(status).draw();
            e.preventDefault();

        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // $(document).ready(function() {
            //     $('.data-table').DataTable({
            //         scrollX: true, // Enable horizontal scrolling

            //     });
            // });


            // When Edit button is clicked, populate the modal with data
            $(document).on('click', '.edit-btn', function() {
                $('#editModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                var starttime = $(this).data('starttime');
                var endtime = $(this).data('endtime');
                var id = $(this).data('id');
                $('#edit-starttime').val(starttime);
                $('#edit-endtime').val(endtime);
                $('#edit-record-id').val(id);
                $('#editModal').modal('show');
            });

            // Save edited record to attendances table
            $('#save-edit').click(function() {
                var editedStarttime = $('#edit-starttime').val();
                var editedEndtime = $('#edit-endtime').val();
                var recordId = $('#edit-record-id').val();
                $.ajax({
                    type: 'PUT',
                    url: '/admin/attendance/update' + '/' + recordId,
                    data: {
                        starttime: editedStarttime,
                        endtime: editedEndtime,
                        id: recordId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            Swal.fire('Success', 'Update successful', 'success');
                            $('#editModal').modal('hide');
                            var dataTable = $('#attendance-table').DataTable();
                            dataTable.ajax.reload();
                        } else {
                            Swal.fire('Error', 'Update failed: ' + response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'AJAX request failed: ' + error, 'error');
                    }
                });
            });

            $('#close').click(function() {
                $('#editModal').modal('hide');
            });

            $('#close_btn').click(function() {
                $('#editModal').modal('hide');
            });
        });
    </script>
@endpush

{{-- @extends('admin.layouts.master')
@section('title', 'Post List')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <!-- <button class="btn btn-info text-white float-right mx-2" title="Add " id="add" data-toggle="modal" data-target="#myModal">
            Add Report Subject
        </button> -->
    </div>

    <div class="card-body table-responsive">
        {!! $dataTable->table(['class' => 'table table-striped', 'style' => 'width: 100%']) !!}
    </div>
</div>

@endsection
@push('script')
{!! $dataTable->scripts() !!} --}}
