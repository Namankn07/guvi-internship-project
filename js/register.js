$(document).ready(function() {
    $('#regForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'php/register.php',
            type: 'POST',
            data: { username: $('#user').val(), password: $('#pass').val() },
            success: function(res) {
                alert("Registration Done!");
                window.location.href = 'login.html';
            }
        });
    });
});