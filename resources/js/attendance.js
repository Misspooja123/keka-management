// public/resources/js/attendance.js

$(document).ready(function () {
    // Clock In
    $('#clock-in-btn').click(function () {
        $.ajax({
            type: 'POST',
            url: '/clock-in',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.success) {
                    alert('Clock-in successful.');
                } else {
                    alert('Clock-in failed: ' + data.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Clock-in failed: ' + error);
            }
        });
    });

    // Clock Out
    $('#clock-out-btn').click(function () {
        $.ajax({
            type: 'POST',
            url: '/clock-out',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.success) {
                    alert('Clock-out successful.');
                } else {
                    alert('Clock-out failed: ' + data.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Clock-out failed: ' + error);
            }
        });
    });
});
