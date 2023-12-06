// Make an AJAX call
$.ajax({
    type: 'GET', // or 'POST', depending on your needs
    url: 'your-api-endpoint',
    data: {
        // Your AJAX data here
    },
    success: function(response) {
        // Update the content of the div with the new data
        $('#refreshDiv').html(response);
    },
    error: function(error) {
        console.log('Error:', error);
    }
});
