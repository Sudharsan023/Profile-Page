$(document).ready(function() {
    // Signup AJAX request
    $('#signupForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        
        // Function to validate email pattern
        function validateEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        // Validate email pattern before submitting
        var email = $('#email').val();
        if (!validateEmail(email)) {
            alert("Please enter a valid email address.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'http://localhost/ankusam/php/register.php',
            data: formData,
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status === 'success') {
                    window.location.href = 'login.html';
                } else if (jsonResponse.status === 'error') {
                    alert(jsonResponse.message);
                }
            }
        });
    });
});
