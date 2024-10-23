function validateForm() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // Email patterns
    var studentEmailPattern = /^[a-zA-Z0-9._%+-]+@student\.newinti\.edu\.my$/;
    var lecturerEmailPattern = /^[a-zA-Z0-9._%+-]+@newinti\.edu\.my$/;
    var adminEmailPattern = /^[a-zA-Z0-9._%+-]+@inti\.edu\.my$/;
    var errorMessage = "";

    // Validate email format
    if (!studentEmailPattern.test(email) && !lecturerEmailPattern.test(email) && !adminEmailPattern.test(email)) {
        errorMessage += "Email must be a valid Inti University domain.\n";
    }

    // Validate password length
    if (password.length < 4) {
        errorMessage += "Password must be at least 4 characters long.\n";
    }

    if (errorMessage) {
        alert(errorMessage);
        return false;
    } else {
        // Save email to local storage
        localStorage.setItem('userEmail', email);

        // Check if email belongs to admin
        if (adminEmailPattern.test(email)) {
            window.location.href = "dashboard_admin.html";  // Redirect to admin dashboard
        } else {
            window.location.href = "dashboard.html";  // Redirect to regular user dashboard
        }
    }
    return false;  // Prevent default form submission
}

function sendResetLink() {
    var resetEmail = document.getElementById('resetEmail').value;

    // Simple validation
    if (resetEmail) {
        alert('A password reset link has been sent to ' + resetEmail);
        // Here, you would send the reset request to your server
    } else {
        alert('Please enter a valid email address.');
    }
}

