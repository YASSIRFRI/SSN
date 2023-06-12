<?php
session_start();
if ($_SESSION["role"] != 'artisan') {
    header("location: Login.php");
}
include '../../dbconfig.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisan Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .sender-email {
            font-size: smaller;
        }
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
                    <a class="btn btn-warning mr-3" href="./Services.php">My Services</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger" href="../controllers/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Sidebar -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <h3>Messages</h3>
                <?php
                $connexion = $GLOBALS['connexion'];
                $query = "SELECT m.message_text, u1.email AS sender_email, u2.email AS receiver_email, m.message_id
            FROM messages m
            JOIN users u1 ON m.sender_id = u1.user_id
            JOIN users u2 ON m.receiver_id = u2.user_id
            WHERE u2.user_id = :user
            ORDER BY m.date_sent DESC
            LIMIT 5";
                $stmt = $connexion->prepare($query);
                $stmt->execute(['user' => $_SESSION["user_id"]]); // Replace $email with the actual email address

                $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo '<ul class="list-group">';
                foreach ($messages as $message) {
                    echo '<li class="list-group-item">';
                    echo '<span class="sender-email">' . $message['sender_email'] . '</span><br>';
                    echo '<span class="message-text">' . $message['message_text'] . '</span>';
                    echo '<button type="button" class="btn btn-primary btn-answer mx-3" data-toggle="modal" data-target="#answerModal" data-message-id="' . $message['message_id'] . '">Answer</button>';
                    echo '</li>';
                }
                echo '</ul>';
                echo '
            <div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="answerModalLabel">Answer Message</h5>
                            <button type="button" class="close"  aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="../controllers/MessagesController.php" method="POST" id="answerForm">
                                <div class="form-group">
                                    <label for="senderEmail">Receiver Email:</label>
                                    <input type="hidden" id="senderEmail" name="recipient" value="">
                                    <span id="senderEmailDisplay"></span>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="send_message" value="1">
                                </div>
                                <div class="form-group">
                                    <label for="messageContent">Message:</label>
                                    <textarea class="form-control" id="messageContent" name="content" rows="5"></textarea>
                                </div>
                                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id="sendButton" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            ';
                echo '
            <script>
                $(document).ready(function() {
                    $(".btn-answer").click(function() {
                        var messageId = $(this).data("message-id");
                        $("#senderEmail").val("' . $message['sender_email'] . '");
                        $("#senderEmailDisplay").text("' . $message['sender_email'] . '");
                        $("#answerForm").attr("action", "../controllers/MessagesController.php?message_id=" + messageId);
                        $(senderEmail).val("' . $message['sender_email'] . '");
                    });
                });
                $("#close").click(function(){
                    $("#answerModal").modal("hide");
                });
            </script>
            ';
                ?>
            </div>
            <div class="col-md-9">
                <h3>Create Service</h3>
                <form method="post" action="../controllers/ServicesController.php">
                    <div class="form-group">
                        <label for="service_name">Service Name</label>
                        <input type="text" class="form-control" name="service_name" placeholder="Enter service name">
                    </div>
                    <div class="form-group">
                        <label for="service_description">Service Description</label>
                        <textarea class="form-control" id="service_description" name="service_description" rows="3" placeholder="Enter service description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
                <h3>Requests</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Service Name</th>
                            <th>Client Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT requests.request_id, artisan_services.service_id, users.username, requests.status, services.service_name
                  FROM requests
                  JOIN users ON requests.user_id = users.user_id
                  JOIN artisan_services ON requests.service_id = artisan_services.service_id
                  JOIN services ON artisan_services.service_id = services.service_id
                  WHERE artisan_services.artisan_id = :connectedUserID and requests.status = 'pending'
                  ORDER BY requests.request_id DESC";

                        $stmt = $connexion->prepare($query);
                        $stmt->bindParam(':connectedUserID', $_SESSION['user_id']);
                        $stmt->execute();
                        $requests = $stmt->fetchAll();
                        foreach ($requests as $request) {
                            $requestID = $request['request_id'];
                            $serviceName = $request['service_name'];
                            $clientName = $request['username'];
                            $status = $request['status'];
                        ?>
                            <tr>
                                <td><?php echo $requestID; ?></td>
                                <td><?php echo $serviceName; ?></td>
                                <td><?php echo $clientName; ?></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <form action="../controllers/RequestsController.php" method="post">
                                        <input type="hidden" value="approve" name="status">
                                        <input type="hidden" value="<?php echo $requestID; ?>" name="request_id">
                                        <button type="submit">Approve</button>
                                    </form>
                                    <form action="../controllers/RequestsController.php" method="post">
                                        <input type="hidden" value="decline" name="status">
                                        <input type="hidden" value="<?php echo $requestID; ?>" name="request_id">
                                    <button type="submit">Decline</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <script>
                </script>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

