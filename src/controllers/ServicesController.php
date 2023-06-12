<?php
session_start();
include '../models/Services.php';
include '../../dbconfig.php';

class ServicesController
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function createService()
    {
        $this->service->save();
        echo "Service created successfully";
        header("location: ../views/ArtisanDashboard.php");
    }

    public function updateService()
    {
        $this->service->update($_POST['name'], $_POST['description']);
        header("location: ../views/ArtisanDashboard.php");
    }

    public function deleteService()
    {
        $service = Service::findById($_REQUEST['id']);
        $service->delete();

        $connection = $GLOBALS['connexion'];
        $stmt = $connection->prepare('DELETE FROM services WHERE service_id = ?');
        $stmt->execute([$_POST["service_id"]]);
        $stmt = $connection->prepare('DELETE FROM artisan_services WHERE service_id = ?');
        $stmt->execute([$_POST["service_id"]]);

        header("location: ../views/ArtisanDashboard.php");
    }
}

if(isset($_POST["service_name"]))
{
    $id = mt_rand(1, 999999999);
    $service = new Service($id, $_POST['service_name'], $_POST['service_description']);
    $servicesController = new ServicesController($service);
    $servicesController->createService();
}

if(isset($_POST["service_id"]))
{
    if($_POST["delete"]==1)
    {
        $connection = $GLOBALS['connexion'];
        $stmt = $connection->prepare('DELETE FROM artisan_services WHERE service_id = ?');
        $stmt->execute([$_POST["service_id"]]);
        $stmt = $connection->prepare('DELETE FROM services WHERE service_id = ?');
        $stmt->execute([$_POST["service_id"]]);
        header("location: ../views/Services.php");
    }
}
