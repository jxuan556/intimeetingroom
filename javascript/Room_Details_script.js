        // Function to open the booking modal with the selected room name
        function openBookingModal(roomName) {
            // Set the room name in the modal
            document.getElementById('roomName').textContent = roomName;
            
            // Show the booking modal
            $('#bookingModal').modal('show');
        }

        // Function to handle room reservation
        function reserveRoom(event) {
            event.preventDefault();

            // Collect input values
            const roomName = document.getElementById('roomName').textContent; // Get room name from text content
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;
            const duration = document.getElementById('duration').value;
            const notes = document.getElementById('notes').value;

            // Check if all fields are filled
            if (!date || !time || !duration) {
                alert('Please fill in all required fields.');
                return;
            }

            // Create booking object
            const booking = { room: roomName, date, time, duration, notes };
            let bookings = JSON.parse(localStorage.getItem("bookings")) || [];

            // Check if the room is available before saving
            if (checkRoomAvailability(bookings, booking)) {
                bookings.push(booking);
                localStorage.setItem("bookings", JSON.stringify(bookings));

                // Show success notification
                const notification = document.getElementById('notification');
                notification.style.display = 'block';

                // Hide notification and redirect after 2 seconds
                setTimeout(() => {
                    notification.style.display = 'none';
                    window.location.href = 'Booking_History.html';
                }, 2000);

                // Clear the form fields
                document.getElementById('bookingForm').reset();
            } else {
                alert('The selected room is already booked for this time slot. Please choose a different time.');
            }
        }

        // Function to check room availability, including overlapping time slots
        function checkRoomAvailability(bookings, newBooking) {
            return !bookings.some(booking => 
                booking.room === newBooking.room &&
                booking.date === newBooking.date &&
                booking.time === newBooking.time
            );
        }

        // Set the minimum date to today's date for the booking date input
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').setAttribute('min', today);