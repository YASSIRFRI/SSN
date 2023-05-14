<?php
session_start();
require '../models/User.php';
require '../../dbconfig.php';
class LoginController
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function login()
    {
        if ($this->user->isAuthenticated()) {
            $_SESSION["user"]=$this->user->getemail();
            $_SESSION["role"]=$this->user->getRole();
            if($_SESSION["role"]=='user')
            header("location: ../views/UserDashboard.php");
            else
            header("location: ../views/ArtisanDashboard.php");
        } else {
            header("location: ../views/Login.php?error=1");
        }
    }
}
$user= new User($_REQUEST['email'], $_REQUEST['password']);
$loginController = new LoginController($user);
if(isset($_POST['email']))
{
    $loginController->login();
}
else
{
    if(isset($_GET['logout']))
    {
        session_destroy();
        header('Location: /src/views/Login.php');
    }
}









?>