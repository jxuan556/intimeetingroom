function cancelBooking(bookingId) {
    if (confirm("Are you sure you want to cancel this booking?")) {
        fetch('cancel_booking.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ booking_id: bookingId })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Failed to cancel booking.");
        });
    }
}






