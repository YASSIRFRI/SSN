<?php
session_start();
if(($_SESSION["role"]!='artisan'))
{
    header("location: Login.php");
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisan Dashboard</title>
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
        <a class="navbar-brand" href="#">Artisan Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text mr-3">Welcome, Artisan!</span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Sidebar -->
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
                <h3>Create Service</h3>
                <!-- Create service form -->
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
                <h3>Orders</h3>
                <!-- Display orders here -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Service Name</th>
                            <th>Client Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Service 1</td>
                            <td>Client A</td>
                            <td>Pending</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Service 2</td>
                            <td>Client B</td>
                            <td>In Progress</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Service 3</td>
                            <td>Client C</td>
                            <td>Completed</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
