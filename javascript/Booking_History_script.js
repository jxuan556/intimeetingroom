window.onload = loadBookings;

var currentBookingIndex = null;

function loadBookings() {
    const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
    const tableBody = document.getElementById("bookingTableBody");
    tableBody.innerHTML = ""; // Clear the table body before loading

    bookings.forEach((booking, index) => {
        const row = tableBody.insertRow();
        row.setAttribute("data-index", index);
        row.innerHTML = `
            <td>${booking.date}</td>
            <td>${booking.time}</td>
            <td>${booking.room}</td>
            <td>${booking.duration} hours</td>
            <td>${booking.notes}</td>
            <td><button class="btn btn-danger" onclick="confirmCancelBooking(${index})">Cancel</button></td>
        `;
    });
}

function confirmCancelBooking(index) {
    currentBookingIndex = index;
    $('#cancelModal').modal('show');
}

function cancelBooking() {
    const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
    bookings.splice(currentBookingIndex, 1);
    localStorage.setItem("bookings", JSON.stringify(bookings));
    loadBookings();
    $('#cancelModal').modal('hide');

    $('#cancelToast').toast({ delay: 3000 }); // Show for 3 seconds
    $('#cancelToast').toast('show');
}
function loadBookings() {
    const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
    const tableBody = document.getElementById("bookingTableBody");
    tableBody.innerHTML = ""; // Clear the table body before loading

    const today = new Date().setHours(0, 0, 0, 0); // Set current date to midnight for comparison

    bookings.forEach((booking, index) => {
        const bookingDate = new Date(booking.date).setHours(0, 0, 0, 0); // Also set the booking date to midnight

        const row = tableBody.insertRow();
        row.setAttribute("data-index", index);
        row.innerHTML = `
            <td>${booking.date}</td>
            <td>${booking.time}</td>
            <td>${booking.room}</td>
            <td>${booking.duration} hours</td>
            <td>${booking.notes}</td>
            <td>
                <button class="btn ${bookingDate < today ? 'btn-secondary' : 'btn-danger'}" 
                    ${bookingDate < today ? 'disabled' : `onclick="confirmCancelBooking(${index})"`}>
                    ${bookingDate < today ? 'Cannot Cancel' : 'Cancel'}
                </button>
            </td>
        `;
    });
}


