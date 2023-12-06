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
            <div class="card-header">Leave Status</div>
            <div class="card-body">
                <div class="table-container">
                    <table class="data-table">
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Show Leave Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

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
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            //approve button code
            $(document).on('click', '.approve_btn', function() {
                var approveBtn = $(this);
                var leaveId = $(this).data('leave-id');

                Swal.fire({
                    title: 'Confirm Approval',
                    text: 'Are you sure you want to approve this leave?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, approve it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send an AJAX request to update the status
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('leave.approve', ':id') }}".replace(':id',
                                leaveId),
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: 'approved'
                            },
                            success: function(response) {
                                Swal.fire('Approved!', response.message, 'success');
                                approveBtn.hide();
                                var dataTable = $('#leave-table').DataTable();
                                dataTable.ajax.reload();
                            },
                            error: function(error) {
                                Swal.fire('Error',
                                    'An error occurred while processing your request.',
                                    'error');
                            }
                        });
                    }
                });
            });

            //reject button code
            $(document).on('click', '.reject_btn', function() {
                // $('.reject_btn').on('click', function() {
                var rejectBtn = $(this);
                var leaveId = rejectBtn.data('leave-id');

                Swal.fire({
                    title: 'Reject Leave',
                    input: 'text',
                    inputLabel: 'Reason for Rejection',
                    inputPlaceholder: 'Enter the reason for rejection...',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Please enter a reason for rejection');
                        }
                        return reason;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var rejectReason = result.value;

                        // Send an AJAX request to update the status and reject reason
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('leave.reject', ':id') }}".replace(':id',
                                leaveId),
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: 'rejected',
                                reject_reason: rejectReason
                            },
                            success: function(response) {
                                Swal.fire('Leave Rejected!', response.message,
                                    'success');
                                $('.reject_btn').hide();
                                var dataTable = $('#leave-table').DataTable();
                                dataTable.ajax.reload();

                            },
                            error: function(error) {
                                Swal.fire('Error',
                                    'An error occurred while processing your request.',
                                    'error');
                            }
                        });
                    }
                });
            });

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
            //view record code
            $('#leave-table').on('click', '.view_btn', function() {
                $('#userShowModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                // var leaveId = $(this).data('id');
                var viewBtn = $(this);
                var leaveId = viewBtn.data('leave-id');

                $.ajax({
                    type: 'GET',
                    url: "{{ route('leave.view', ':id') }}".replace(':id', leaveId),
                    dataType: 'json',
                    success: function(response) {
                        var leaveStatusText = getLeaveStatusText(response.leave_status);
                        var statusText = getStatusText(response.status);

                        $('#user-id').text(response.id);
                        $('#user_name').text(response.user.name);
                        $('#startdatetime').text(response.startdatetime);
                        $('#enddatetime').text(response.enddatetime);
                        $('#leave_reason').text(response.leave_reason);
                        $('#leave_status').text(leaveStatusText);
                        $('#status').text(statusText);

                        // $('#reject_reason').text(response.reject_reason);

                        $('#edit-record-id').val(response.id);

                        $('#userShowModal').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });

        });
    </script>
@endpush
