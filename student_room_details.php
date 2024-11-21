<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTI University - Reserve Room</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="img/INTI_Logo.png" alt="INTI University Logo" style="width: 300px; height: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item active"><a href="student_dashboard.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="booking_history.php" class="nav-link">Booking History</a></li>
                <li class="nav-item"><a href="Need_Help.html" class="nav-link">Need Help</a></li>
                <li class="nav-item"><a href="Feedback.html" class="nav-link">Feedback</a></li>
                <li class="nav-item"><a href="view_feedback_reply.php" class="nav-link">Feedback Reply</a></li>
                <li class="nav-item"><a href="Frequently_Asked_Questions.html" class="nav-link">FAQ</a></li>
                <li class="nav-item"><a href="The_Librarians.html" class="nav-link">The Librarians</a></li>
                <li class="nav-item"><a href="user_profile.php" class="nav-link">User</a></li>
            </ul>
        </div>
    </nav>
    <section id="room-details" class="container my-5 pt-5">
        <h3 class="text-center mb-4">Discussion Room Details & Booking</h3>
        <div class="row">
            <?php include 'fetch_rooms_student.php'; ?>
        </div>
    </section>

    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Reserve a Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm" onsubmit="reserveRoom(event)">
                        <div class="form-group">
                            <label>Room:</label>
                            <p id="roomName" class="font-weight-bold"></p>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <select id="time" class="form-control" required>
                                <option value="" disabled selected>Select a time</option>
                                <option value="08:00">08:00 AM</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="13:00">01:00 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="16:00">04:00 PM</option>
                                <option value="17:00">05:00 PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (hours)</label>
                            <select id="duration" class="form-control" required>
                                <option value="1">1 hour</option>
                                <option value="2">2 hours</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Additional Notes</label>
                            <textarea id="notes" rows="3" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Reserve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Recommended Browser: Google Chrome</p>
        <p>Copyright © 2024 INTI International College Penang Library</p>
        <p>Tel: +604-6310138 | Fax: +604-6310193</p>
        <p>&copy; 2024 INTI University - All Rights Reserved</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/Room_Details_script.js"></script>

</body>
</html>

