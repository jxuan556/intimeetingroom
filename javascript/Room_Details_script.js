function openBookingModal(roomName) {
    document.getElementById("roomName").innerText = roomName;
    $('#bookingModal').modal('show');
}

function reserveRoom(event) {
    event.preventDefault();

    const formData = {
        room_name: document.getElementById("roomName").innerText,
        booking_date: document.getElementById("date").value,
        booking_time: document.getElementById("time").value,
        duration: document.getElementById("duration").value,
        notes: document.getElementById("notes").value
    };

    const bookingDateTime = new Date(`${formData.booking_date}T${formData.booking_time}`);
    const currentDateTime = new Date();

    const dayOfWeek = bookingDateTime.getUTCDay();  
    if (dayOfWeek === 0 || dayOfWeek === 6) {
        alert("Booking is not allowed on weekends (Saturday and Sunday). Please choose a weekday.");
        return;
    }

    if (bookingDateTime <= currentDateTime) {
        alert("You cannot book a room in the past.");
        return;
    }

    fetch('store_booking.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            $('#bookingModal').modal('hide');
            document.getElementById("bookingForm").reset();
            window.location.href = "booking_history.php"; 
        }
    });
}





