$(document).ready(function () {
    $("#loginForm").submit(function (event) {
      event.preventDefault(); // Prevent the form from submitting normally
  
      var formData = {
        email: $("#email").val(),
        password: $("#password").val(),
      };
      $.ajax({
        type: "POST", // Ensure that the request method is POST
        url: "http://localhost/ankusam/php/login.php",
        data: formData,
        success: function (response) {
            // Directly access the properties of the response object
            if (response.status === "success") {
                window.location.href = "profile.html?name=" + response.name; // Pass the name to profile.html
            } else {
                alert(response.message);
            }
        },
      });
    });
  });
  