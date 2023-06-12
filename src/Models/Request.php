<?php


include '../../dbconfig.php';

class Request{

    protected $request_id;
    protected $user_id;
    protected $service_id;
    protected $description;
    protected $status;
    protected $date_requested;
    protected $location;


    function __construct($request_id, $user_id, $service_id, $description, $status, $date_requested, $location){
        $this->request_id = $request_id;
        $this->user_id = $user_id;
        $this->service_id = $service_id;
        $this->description = $description;
        $this->status = $status;
        $this->date_requested = $date_requested;
        $this->location = $location;
    }

    function save(){
        $connexion = $GLOBALS['connexion'];
        $sql = "INSERT INTO requests (request_id, user_id, service_id, description, status, date_requested, location) VALUES ('$this->request_id', '$this->user_id', '$this->service_id', '$this->description', '$this->status', '$this->date_requested', '$this->location')";
        $connexion->query($sql);
    }
    function delete(){
        $connexion = $GLOBALS['connexion'];
        $sql = "DELETE FROM requests WHERE request_id = '$this->request_id'";
        $connexion->query($sql);
    }
    static function findById($request_id){
        $connexion = $GLOBALS['connexion'];
        $sql = "SELECT * FROM requests WHERE request_id = '$request_id'";
        $result = $connexion->query($sql);
        $row = $result->fetch();
        return $row;
    }
    function update($request_id, $user_id, $service_id, $description, $status, $date_requested, $location){
        $connexion = $GLOBALS['connexion'];
        $sql = "UPDATE requests SET request_id = '$request_id', user_id = '$user_id', service_id = '$service_id', description = '$description', status = '$status', date_requested = '$date_requested', location = '$location' WHERE request_id = '$request_id'";
        $connexion->query($sql);
    }
    function updateStatus($status){
        $connexion = $GLOBALS['connexion'];
        $sql = "UPDATE requests SET status = '$status' WHERE request_id = '$this->request_id'";
        $connexion->query($sql);
    }


}



?>