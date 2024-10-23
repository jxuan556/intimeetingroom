function submitFeedback() {
    const message = document.getElementById("message").value;
    if (message) {
        const notificationModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
        document.getElementById("modal-body-text").textContent = "Your feedback has been submitted successfully!";
        notificationModal.show();

        document.getElementById("message").value = "";
    } else {
        alert("Please fill out the message field before submitting.");
    }
}