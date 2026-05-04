$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            data: { username: $('#user').val(), password: $('#pass').val() },
            success: function(response) {
                let res = JSON.parse(response);
                if(res.status === "success") {
                    localStorage.setItem('token', res.token);
                    window.location.href = 'profile.html';
                } else {
                    alert("Invalid Credentials");
                }
            }
        });
    });
});