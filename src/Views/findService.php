<?php
session_start();
include '../../dbconfig.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        /* CSS styles for the service list */
        #serviceList {
            list-style-type: none;
            padding: 0;
        }

        .service-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
        }

        .service-info {
            flex: 1;
        }

        .service-name {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .description {
            font-size: 14px;
            color: #888;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .email {
            font-size: 14px;
            color: blue;
        }

        .username {
            font-size: 16px;
            color: green;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>Service Search</h1>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <?php
                try {
                    // Fetch all services
                    $query = "SELECT services.service_id, services.service_name, services.service_description, users.email, users.username, users.user_id
                              FROM services
                              INNER JOIN artisan_services ON services.service_id = artisan_services.service_id
                              INNER JOIN users ON artisan_services.artisan_id = users.user_id";
                    $stmt = $connexion->prepare($query);
                    $stmt->execute();
                    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    echo '<input type="text" id="searchInput" class="form-control" placeholder="Search by service name">';

                    echo '<ul id="serviceList" class="list-group">';
                    foreach ($services as $service) {
                        echo '<li class="list-group-item service-item">';
                        echo '<div class="service-info">';
                        echo '<h4 class="service-name">' . $service['service_name'] . '</h4>';
                        echo '<h6 class="service-name">' . $service['service_id'] . '</h6>';
                        echo '<p class="description">' . $service['service_description'] . '</p>';
                        echo '</div>';
                        echo '<div class="user-info">';
                        echo '<span class="email">' . $service['email'] . '</span>';
                        echo '<span class="username d-flex">' . $service['username'] . '</span>';
                        echo '</div>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="answerModalLabel">Answer Message</h5>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="messageForm" method="POST" action="../controllers/RequestsController.php">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="recipient" name="<?php ?>" value="<?php echo $service["user_id"]?>"required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="service_id" value="<?php echo $service["service_id"];?>">
                        </div>
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea class="form-control" id="content" name="description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#searchInput").on("input", function () {
                var searchTerm = $(this).val().toLowerCase();
                $("#serviceList li").each(function () {
                    var serviceText = $(this).text().toLowerCase();
                    if (serviceText.indexOf(searchTerm) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Handle the click event on service items
            $(".service-item").on("click", function () {
                var serviceId = $(this).data("service-id");
                $("#serviceIdInput").val(serviceId);
                $("#answerModal").modal("show");
            });
        });
    </script>
</body>
</html>
