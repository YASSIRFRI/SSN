<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Add your custom styles here */
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">User Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text mr-3">Welcome, User!</span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar and Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <h3>Messages</h3>
                <!-- Display messages here -->
                <ul class="list-group">
                    <li class="list-group-item">Message 1</li>
                    <li class="list-group-item">Message 2</li>
                    <li class="list-group-item">Message 3</li>
                </ul>
            </div>
            <div class="col-md-9">
                <h3>Place an Order</h3>
                <!-- Order form -->
                <form>
                    <div class="form-group">
                        <label for="service_name">Service Name</label>
                        <input type="text" class="form-control" id="service_name" placeholder="Enter service name">
                    </div>
                    <div class="form-group">
                        <label for="service_description">Service Description</label>
                        <textarea class="form-control" id="service_description" rows="3"
                            placeholder="Enter service description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </form>
                <h3>Message Artisans</h3>
                <!-- Message artisans form -->
                <form>
                    <div class="form-group">
                        <label for="message_subject">Subject</label>
                        <input type="text" class="form-control" id="message_subject" placeholder="Enter subject">
                    </div>
                    <div class="form-group">
                        <label for="message_content">Message</label>
                        <textarea class="form-control" id="message_content" rows="3"
                            placeholder="Enter your message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
                <h3>View Artisan Offers</h3>
                <!-- Display artisan offers here -->
                <ul class="list-group">
                    <li class="list-group-item">Offer 1</li>
                    <li class="list-group-item">Offer 2</li>
                    <li class="list-group-item">Offer 3</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
