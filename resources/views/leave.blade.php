@extends('layouts.app1')

@section('content')
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">LEAVE</h3>
                <button type="button" class="btn btn-primary" id="requestLeaveButton">Request
                    Leave</button>
            </div>
        </div>
    </div></br></br>

    {{-- UserLeaveDatatable --}}
    <div class="container">

        <div class="card">
            <div class="card-header">Users Leaves</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        {{-- <label><strong>Attendance Status :</strong></label> --}}
                        <select id="paid-unpaid" class="form-control filter-status" style="width: 150px">
                            <option value="">--Leave Type--</option>
                            <option value="1">Unpaid</option>
                            <option value="0">Paid</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        {{-- <label><strong>Attendance Status :</strong></label> --}}
                        <select id="approve_reject" class="form-control filter-status col-sm-4" style="width: 150px">
                            <option value="">--Status--</option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Rejected</option>
                        </select>
                    </div>
                </div></br>

                <div class="table-container">
                    <table class="data-table">
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for user leave view -->
    <div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Show Leave Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <p><strong>ID:</strong> <span id="user-id"></span></p> --}}
                    <p><strong>User Name:</strong> <span id="user_name"></span></p>
                    <p><strong>Start Date Time:</strong> <span id="startdatetime"></span></p>
                    <p><strong>End Date Time:</strong> <span id="enddatetime"></span></p>
                    <p><strong>Leave Reason:</strong> <span id="leave_reason"></span></p>
                    {{-- <p><strong>Reject Reason:</strong> <span id="reject_reason"></span></p> --}}
                    <p><strong>Leave Status:</strong> <span id="leave_status"></span></p>
                    <p><strong>Status:</strong> <span id="status"></span></p>
                    <input type="hidden" id="edit-record-id" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- submit leave request for user side --}}
    <form id="leaveRequestForm" action="{{ route('leave.submit') }}" class="leave-req" method="POST">
        @csrf
        <div class="modal fade" id="leaveRequestModal" tabindex="-1" role="dialog"
            aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="leaveRequestModalLabel">Request Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" id="close_form" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="startdatetime">Start Date and Time:</label>
                            <input type="datetime-local" class="form-control datetimepicker" name="startdatetime"
                                id="startdatetime" min="{{ now()->format('Y-m-d\TH:i') }}">
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="enddatetime">End Date and Time:</label>
                            <input type="datetime-local" class="form-control datetimepicker" name="enddatetime"
                                id="enddatetime" min="{{ now()->format('Y-m-d\TH:i') }}">
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="leave_reason">Leave Reason:</label>
                            <textarea class="form-control" name="leave_reason" id="leave_reason" rows="3"></textarea>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="leave_status">Leave Status:</label>
                            <select class="form-control" name="leave_status" id="leave_status">
                                <option value="0">Paid</option>
                                <option value="1">Unpaid</option>
                            </select>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="cancel_form">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitLeaveRequest">Submit Request</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- modal popup for edit user side  --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="edit_leavereq">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Leave</h5>
                        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <!-- Date Picker Inputs for starttime and endtime -->
                            <label for="edit-starttime">Start Date Time:</label>
                            <input type="datetime-local" id="edit-startdatetime" class="form-control"
                                name="startdatetime" min="{{ now()->format('Y-m-d\TH:i') }}">
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="edit-endtime">End Date Time:</label>
                            <input type="datetime-local" id="edit-enddatetime" class="form-control" name="enddatetime"
                                min="{{ now()->format('Y-m-d\TH:i') }}">
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="leave_reason">Leave Reason:</label>
                            <textarea class="form-control leave" name="leave_reason" id="leave_reason" rows="3" required></textarea>
                            <span class="error-msg-input text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="leave_status">Leave Status:</label>
                            <select class="form-control status_leave" name="leave_status" id="leave_status" required>
                                <option value="0">Paid</option>
                                <option value="1">Unpaid</option>
                            </select>
                            <span class="error-msg-input text-danger"></span>
                        </div>
                        <input type="hidden" id="edit-record-id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="close_btn">Close</button>
                        <button type="button" class="btn btn-primary" id="save-edit">Save</button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
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
                    $('#leaveRequestForm')[0].reset();
                    // Clear validation error messages
                    $('#leaveRequestForm .error-msg-input').text('');
                }
                $('#submitLeaveRequest').on('click', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{ route('leave.submit') }}",
                        type: 'POST',
                        data: $("#leaveRequestForm").serialize(),
                        success: function(response) {
                            Swal.fire('Success',
                                'Leave request submitted successfully...',
                                'success');
                            $('#leaveRequestModal').modal('hide');
                            var dataTable = $('#userleave-table').DataTable();
                            dataTable.ajax.reload();
                            resetForm();
                        },

                        error: function(data) {
                            if (data.status === 422) {
                                var errors = $.parseJSON(data.responseText);
                                console.log(errors)
                                $.each(errors.errors, function(key, value) {
                                    $('#leaveRequestForm').find(
                                            'input[name=' +
                                            key + ']')
                                        .parents('.form-group')
                                        .find('.error-msg-input').html(
                                            value);
                                    $('#leaveRequestForm').find(
                                            'textarea[name=' + key +
                                            ']')
                                        .parents('.form-group')
                                        .find('.error-msg-input').html(
                                            value);

                                });
                            }
                            resetForm();
                        }
                    });
                });
                $('#leaveRequestModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#requestLeaveButton').click(function() {
                    $('#leaveRequestModal').modal('show');
                });

                $("#close_form").click(function() {
                    $("#leaveRequestModal").modal("hide");
                    resetForm();
                });

                $("#cancel_form").click(function() {
                    $("#leaveRequestModal").modal("hide");
                    resetForm();
                });

                $('#startdatetime').on('input', function() {
                    var startdatetime = new Date($(this).val()).getTime();
                    var minDate = new Date($('#minDate').val()).getTime();

                    if (startdatetime < minDate) {
                        alert('Please select a date and time that is not in the past.');
                        $(this).val('');
                    }
                });
                $('#enddatetime').on('input', function() {
                    var enddatetime = new Date($(this).val()).getTime();
                    var minDate = new Date($('#minDate').val()).getTime();

                    if (enddatetime < minDate) {
                        alert('Please select a date and time that is not in the past.');
                        $(this).val('');
                    }
                });




            });

        });
    </script>


    <script type="text/javascript">
        $('#paid-unpaid').on('change', function(e) {
            var status = $(this).val();
            window.LaravelDataTables["userleave-table"].column(2).search(status).draw();
            e.preventDefault();
        });

        $('#approve_reject').on('change', function(e) {
            var status = $(this).val();
            window.LaravelDataTables["userleave-table"].column(3).search(status).draw();
            e.preventDefault();
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //view record code
            $('#userleave-table').on('click', '.view_btn', function() {
                function getStatusText(statusCode) {
                    switch (statusCode) {
                        case '0':
                            return 'Pending';
                        case '1':
                            return 'Approved';
                        case '2':
                            return 'Rejected';
                        default:
                            return 'Unknown';
                    }
                }

                function getLeaveStatusText(leaveStatus) {
                    switch (leaveStatus) {
                        case '0':
                            return 'Paid';
                        case '1':
                            return 'Unpaid';
                        default:
                            return 'Unknown';
                    }
                }
                $('#userShowModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                var viewBtn = $(this);
                var leaveId = viewBtn.data('leave-id');

                $.ajax({
                    type: 'GET',
                    url: "{{ route('leave.show', ':id') }}".replace(':id', leaveId),
                    dataType: 'json',
                    success: function(response) {
                        var leaveStatusText = getLeaveStatusText(response.leave_status);
                        var statusText = getStatusText(response.status);
                        // console.log(response.user.name);
                        $('#user-id').text(response.id);
                        $('#user_name').text(response.user.name);
                        $('#startdatetime').text(response.startdatetime);
                        $('#enddatetime').text(response.enddatetime);
                        $('#leave_reason').text(response.leave_reason);
                        $('#reject_reason').text(response.reject_reason);
                        $('#leave_status').text(leaveStatusText);
                        $('#status').text(statusText);
                        $('#edit-record-id').val(response.id);

                        // Show the modal
                        $('#userShowModal').modal('show');
                    },
                });
            });

            $('#edit-startdatetime').on('input', function() {
                var startdatetime = new Date($(this).val()).getTime();
                var minDate = new Date($('#minDate').val()).getTime();

                if (startdatetime < minDate) {
                    alert('Please select a date and time that is not in the past.');
                    $(this).val('');
                }
            });
            $('#edit-enddatetime').on('input', function() {
                var enddatetime = new Date($(this).val()).getTime();
                var minDate = new Date($('#minDate').val()).getTime();

                if (enddatetime < minDate) {
                    alert('Please select a date and time that is not in the past.');
                    $(this).val('');
                }
            });

            // Edit Button Click user side
            $('#userleave-table').on('click', '.edit_btn', function() {

                $('#editModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                var leaveId = $(this).data('leave-id');

                $.ajax({
                    type: 'GET',
                    url: "{{ route('leave.edit', ':id') }}".replace(':id', leaveId),
                    dataType: 'json',
                    success: function(response) {

                        // Populate the form fields with the leave record data
                        $('#edit-startdatetime').val(response.startdatetime);
                        $('#edit-enddatetime').val(response.enddatetime);
                        $('.leave').val(response.leave_reason);
                        $('.status_leave').val(response.leave_status);
                        $('#edit-record-id').val(response.id);

                        // Show the edit modal
                        $('#editModal').modal('show');
                    },
                    error: function(error) {
                        Swal.fire('Error', 'Failed to retrieve leave record.',
                            'error');
                    }
                });
            });

            // Update Button Click
            $('#save-edit').click(function() {
                var leaveId = $('#edit-record-id').val();
                var startdatetime = $('#edit-startdatetime').val();
                var enddatetime = $('#edit-enddatetime').val();
                var leave_reason = $('.leave').val();
                var leave_status = $('.status_leave').val();

                $.ajax({
                    type: 'PUT',
                    url: "{{ route('leave.update', ':id') }}".replace(':id',
                        leaveId),
                    data: {
                        _token: '{{ csrf_token() }}',
                        startdatetime: startdatetime,
                        enddatetime: enddatetime,
                        leave_reason: leave_reason,
                        leave_status: leave_status
                    },
                    success: function(response) {
                        if (response.success) {
                            // Close the edit modal
                            $('#editModal').modal('hide');

                            Swal.fire('Success',
                                'Leave record updated successfully',
                                'success');
                            var dataTable = $('#userleave-table').DataTable();
                            dataTable.ajax.reload();
                        } else {
                            Swal.fire('Error',
                                'Failed to update leave record.',
                                'error');
                        }
                    },
                    // error: function(error) {
                    //     Swal.fire('Error',
                    //         'Failed to update leave record.',
                    //         'error');
                    // }
                    error: function(data) {
                        if (data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            console.log(errors)
                            $.each(errors.errors, function(key, value) {
                                $('#edit_leavereq').find('input[name=' +
                                        key + ']')
                                    .parents('.form-group')
                                    .find('.error-msg-input').html(value);
                                $('#edit_leavereq').find(
                                        'textarea[name=' + key +
                                        ']')
                                    .parents('.form-group')
                                    .find('.error-msg-input').html(value);

                            });
                        }
                    }
                });
            });
        });

        $('#close').click(function() {
            $('#editModal').modal('hide');
        });

        $('#close_btn').click(function() {
            $('#editModal').modal('hide');
        });
    </script>
@endpush
