<?php
// Assuming you have a PDO object stored in a global variable called $PDO

// Check if the user is logged in and get the user ID
// (Replace this with your own authentication logic)
include '../../dbconfig.php';
$PDO = $GLOBALS['connexion'];
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userID = $_SESSION['user_id'];

// Function to delete a service by its ID
function deleteService($serviceID, $PDO)
{
    $query = "DELETE FROM services WHERE service_id = :serviceID";
    $stmt = $PDO->prepare($query);
    $stmt->bindParam(':serviceID', $serviceID);
    $stmt->execute();
}

// Get the user's services
$query = "SELECT s.service_id, s.service_name, s.service_description
          FROM services s
          JOIN artisan_services a ON s.service_id = a.service_id
          JOIN users u ON a.artisan_id = u.user_id
          WHERE u.user_id = :userID";
$stmt = $PDO->prepare($query);
$stmt->bindParam(':userID', $userID);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Services</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h3>My Services</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Service ID</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service) : ?>
                    <tr>
                        <td><?php echo $service['service_id']; ?></td>
                        <td><?php echo $service['service_name']; ?></td>
                        <td><?php echo $service['service_description']; ?></td>
                        <td>
                            <form action="../controllers/ServicesController.php" method="POST" class="d-inline">
                                <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                            </form>
                            <form action="../controllers/ServicesController.php" method="POST" class="d-inline">
                                <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                                <input type="hidden" name="delete" value="1">
                                <button type="submit"  class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
