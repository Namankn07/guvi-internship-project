$(document).ready(function() {
    let token = localStorage.getItem('token');
    if (!token) window.location.href = 'login.html';

    // Data Fetch
    $.ajax({
        url: 'php/profile.php',
        type: 'GET',
        data: { token: token },
        success: function(res) {
            let data = JSON.parse(res);
            $('#dispAge').text(data.age || "Not Set");
            $('#dispDob').text(data.dob || "Not Set");
            $('#dispContact').text(data.contact || "Not Set");
        }
    });

    // Data Update
    $('#updateForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'php/profile.php',
            type: 'POST',
            data: {
                token: token,
                age: $('#age').val(),
                dob: $('#dob').val(),
                contact: $('#contact').val()
            },
            success: function() { alert("Updated!"); location.reload(); }
        });
    });

    $('#logout').click(function() {
        localStorage.removeItem('token');
        window.location.href = 'login.html';
    });
});