<?php

session_start(
);

include '../models/Request.php';

class RequestController{

    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function createRequest(){
        $this->request->save();
        echo "Request created successfully";
        header("location: ../views/UserDashboard.php");
    }

}


if(isset($_POST["service_id"]))
{
    $id = mt_rand(1, 999999999);
    $request = new Request($id, $_SESSION["user_id"], $_POST['service_id'], $_POST['description'], 'pending', date("Y-m-d"), $_POST['location']);
    $requestController = new RequestController($request);
    $requestController->createRequest();
}
if(isset($_POST["request_id"]))
{
    $request = Request::findById($_POST["request_id"]);
    $request= new Request($request["request_id"], $request["user_id"], $request["service_id"], $request["description"], $request["status"], $request["date_requested"], $request["location"]);
    $request->updateStatus($_POST["status"]);
    header("location: ../views/ArtisanDashboard.php");
}
var_dump($_REQUEST);
?>