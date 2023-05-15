<?php
session_start();
class ServicesController
{
    private $service;
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function createService()
    {
        $service = new Service(null, $_REQUEST['name'], $_REQUEST['description']);
        $service->save();
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
        header("location: ../views/ArtisanDashboard.php");
    }
}

?>