@extends('layouts.app1')


@section('content')
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">ATTENDANCE</h3>
                <button type="button" class="btn btn-danger" id="clock-in-btn">Clock
                    In</button>
                <button type="button" class="btn btn-danger clockOutButton" id="clock-out-btn" style="display: none;">Clock
                    Out</button>
                <div id="timer" style="font-size: 20px;"></div>

            </div>
        </div>
    </div>

    <form method="post" id="clock-in-form" action="{{ route('clockin') }}">
        @csrf
        <!-- Modal -->
        <div class="modal" id="clock-in-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Clock In</h5>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="clock-in-description">Description:</label>
                            <input type="text" class="form-control" id="clock-in-description" name="description"
                                placeholder="Enter description" required>
                            <div id="description-error" class="text-danger desc"></div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
                        <button type="button" class="btn btn-primary" id="clock-in-submit">Clock
                            In</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
                    $('#clock-in-form')[0].reset();
                    // Clear validation error messages
                   $('#clock-in-form #description-error').text('');
                }
                let timerInterval;
                let startTime;

                // Function to update the timer display
                function updateTimerDisplay() {
                    const currentTime = new Date().getTime();
                    const elapsedTime = new Date(currentTime - startTime);
                    const hours = String(elapsedTime.getUTCHours()).padStart(2, '0');
                    const minutes = String(elapsedTime.getUTCMinutes()).padStart(2, '0');
                    const seconds = String(elapsedTime.getUTCSeconds()).padStart(2, '0');
                    $('#timer').text(`Timer : ${hours}:${minutes}:${seconds}`);
                }

                $('#clock-in-modal').modal({
                    backdrop: 'static',
                    keyboard: false
                });

                // Clock In
                $('#clock-in-btn').click(function() {
                    $('#clock-in-modal').modal('show');
                });


                $("#cancel-btn").click(function() {
                    $("#clock-in-modal").modal("hide");
                    resetForm();
                });


                $("#clock-in-description").on("input", function() {
                    const description = $(this).val();

                    if (description) {
                        // If the description is not empty, clear the error message
                        $("#description-error").text("");
                    }
                });

                // Handle the "Clock In" button inside the modal
                $('#clock-in-submit').click(function() {
                    const description = $('#clock-in-description').val();

                    if (!description) {
                        $('#description-error').text(
                            'Description is required'); // Display the error message
                        return;
                    }

                    // If the description is not empty, clear any previous error message

                    $.ajax({
                        type: 'POST',
                        url: '/attendance/clockin',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            description: description
                        },
                        success: function(data) {
                            if (data.success) {
                                startTime = new Date().getTime();
                                timerInterval = setInterval(updateTimerDisplay, 1000);

                                $('#clock-in-modal').modal('hide');
                                $('#clock-in-btn').hide();

                                $('#clock-out-btn').show();
                                Swal.fire('Success', 'Clock-in successful.', 'success');
                                resetForm();
                            } else {
                                Swal.fire('Error', 'Clock-in failed: ' + data.message,
                                    'error');
                                    resetForm();
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Clock-in failed: ' + error, 'error');
                            resetForm();
                        }
                    });
                });


                // Clock Out
                $('#clock-out-btn').click(function() {
                    $.ajax({
                        type: 'POST',
                        url: '/attendance/clockout',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(data) {
                            if (data.success) {
                                clearInterval(timerInterval);
                                $('#clock-out-btn').hide();
                                $('#clock-in-btn').show();
                                Swal.fire('Success', 'Clock-out successful.',
                                    'success');
                            } else {
                                Swal.fire('Error', 'Clock-out failed: ' + data
                                    .message, 'error');
                            }
                        },
                    });
                });
            });
        });
    </script>
@endpush
