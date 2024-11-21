let bookingIdToCancel = null;

        function openCancelModal(bookingId) {
            bookingIdToCancel = bookingId;
            $('#cancelModal').modal('show');
        }

        function confirmCancel() {
            const cancellationReason = document.getElementById('cancellationReason').value;

            if (bookingIdToCancel && cancellationReason) {
                fetch('cancel_booking_admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ booking_id: bookingIdToCancel, cancellation_reason: cancellationReason })
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
                $('#cancelModal').modal('hide');
            } else {
                alert("Please enter a cancellation reason.");
            }
        }