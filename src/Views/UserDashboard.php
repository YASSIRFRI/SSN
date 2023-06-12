<?php

session_start();
include '../../dbconfig.php';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <a class="btn btn-warning mr-3" href="./findService">Discover Services</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger" href="../controllers/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar and Content -->
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
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id="sendButton" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            ';
            
            // JavaScript code to handle modal form submission and closing
            echo '
            <script>
                $(document).ready(function() {
                    $(".btn-answer").click(function() {
                        var messageId = $(this).data("message-id");
                        $("#senderEmail").val("' . $message['sender_email'] . '");
                        $("#senderEmailDisplay").text("' . $message['sender_email'] . '");
                        $("#answerForm").attr("action", "../controllers/MessagesController.php?message_id=" + messageId);
                        $("#answerModal").modal("show");
                    });
            
                    // Close modal on close button click
                    $(".modal .close").click(function() {
                        $("#answerModal").modal("hide");
                    });
                });
            </script>
            ';
            
            ?>
               
            </div>
            <div class="col-md-9">
            <h3>Place an Order</h3>
<form id="orderForm">
    <div class="form-group">
        <label for="service_name">Order Subject</label>
        <input type="text" class="form-control" id="order_name" placeholder="Enter service name">
    </div>
    <div class="form-group">
        <label for="service_description">Order Description</label>
        <textarea class="form-control" id="service_description" rows="3" placeholder="Enter service description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Place Order</button>
</form>
                <h3>Message Artisans</h3>
<form id="messageForm" action="../controllers/MessagesController.php" method="POST">
    .<div class="form-group">
      <label for="">Artisan Email</label>
      <input type="email" name="recipient" id="" class="form-control" placeholder="" aria-describedby="helpId">
      <small id="helpId" class="text-muted">Help text</small>
    </div>
    <div class="form-group">
        <label for="message_subject">Subject</label>
        <input type="text" class="form-control" id="message_subject" placeholder="Enter subject">
    </div>
    <div class="form-group">
        <label for="message_content">Message</label>
        <textarea class="form-control" id="message_content" rows="3" name="content" placeholder="Enter your message"></textarea>
    </div>
    <input type="hidden" name="send_message" value="1">
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>
                <h3>View Artisan Offers</h3>
                <ul class="list-group">
                    <li class="list-group-item">Offer 1</li>
                    <li class="list-group-item">Offer 2</li>
                    <li class="list-group-item">Offer 3</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Reply to Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Message reply form -->
                    <form>
                        <div class="form-group">
                            <label for="reply_content">Your Reply</label>
                            <textarea class="form-control" id="reply_content" rows="3"
                                placeholder="Enter your reply"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript code to handle modal -->
</body>

</html>
