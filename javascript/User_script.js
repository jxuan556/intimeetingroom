// Simulate user data for dynamic profile updates (in reality, this data would come from a server or localStorage)
const userData = {
    name: 'John Doe',
    email: 'john.doe@example.com',
    profileIcon: 'default-profile-icon.png',  // Placeholder for the profile icon
};

// Function to display user details dynamically
function loadUserProfile() {
    document.getElementById('name').textContent = userData.name;
    document.getElementById('email').textContent = userData.email;
    document.getElementById('profileIcon').src = userData.profileIcon || 'default-profile-icon.png';
}

// Load user profile on page load
document.addEventListener('DOMContentLoaded', loadUserProfile);

// Function to display the logout modal
function logOut() {
    $('#logoutModal').modal('show');
}

// Function to confirm logout and redirect to login page
function confirmLogOut() {
    // Perform any logout logic if needed (e.g., clearing session data)
    sessionStorage.clear();  // Clear session storage
    alert('Logged out successfully');
    window.location.href = "login.html"; // Redirect to login page
}

// Function to preview the profile icon before updating
function previewProfileIcon(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profileIcon').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Function to update the profile (mock implementation)
function updateAccount() {
    const fileInput = document.getElementById('newIcon');
    const file = fileInput.files[0];

    if (!file) {
        showNotification('Please select a profile icon to update.', 'alert-danger');
        return;
    }

    // Simulate profile update logic (e.g., sending data to the server)
    setTimeout(() => {
        showNotification('Profile updated successfully!', 'alert-success');
        userData.profileIcon = document.getElementById('profileIcon').src; // Update user data
    }, 1000);
}

// Function to show notifications
function showNotification(message, type) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.className = `alert ${type}`;
    notification.style.display = 'block';

    // Hide the notification after 3 seconds
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}


