<?php
session_start();

include '../models/User.php';

class RegistrationController
{
    private $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
    public function register()
    {
        try{
            $user=$this->userModel->register();
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        if ($user) {
            header("Location: ../views/Dashboard.php");
        } else{
            header("Location: ../views/Login.php/?error=1");
        }
    }
}

if(isset($_POST['email']))
{

    $user= new User($_REQUEST['email'], $_REQUEST['password']);
    $regController = new RegistrationController($user);
    $regController->register();
}






?>