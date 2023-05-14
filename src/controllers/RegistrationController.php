<?php
session_start();
include '../Models/User.php';
include '../Models/Artisan.php';

class RegistrationController
{
    private $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
    public function register()
    {
        //try{
            if($this->userModel instanceof Artisan)
            {
                $user=$this->userModel->completeArtisanInfo($_POST['uname'],$_POST['phoneNumber'],$_POST['role'],$_POST['companyName'],$_POST['companyAddress'],$_POST['description'],$_SESSION['tmpUser']["user_id"]);
            }
            else
            {
                $user=$this->userModel->completeUserInfo($_POST['uname'],$_POST['phoneNumber'],$_POST['role']);
            }
        //catch(Exception $e)
        //{
            //echo $e->getMessage();
        if($user) {
            //put the uploaded image in the assessts folder
        $uploadDir=dirname(dirname(dirname(__FILE__))).'/assets/images/';
        $originalFilename = $_FILES['profilePicture']['name'];
        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $newFilename = $_SESSION['tmpUser']["user_id"]. '.' . $extension;
        $test= move_uploaded_file($_FILES['profilePicture']['tmp_name'], $uploadDir . $newFilename);
        //var_dump($uploadDir . $newFilename);
        //var_dump($extension);
        if($test)
        {
            header("Location: ../views/Dashboard.php");

        } else{
            header("Location: ../views/Login.php/?error=1");
        }
    }
    }
    public function createAccount()
    {
        try{
            $user=$this->userModel->createAccount();
            header("Location: ../views/CompleteProfile.php");
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        if ($user) {
            header("Location: ../views/CompleteProfile.php");
        } else{
            session_destroy();
            header("Location: ../views/Login.php/?error=1");
        }
    }
}

if(isset($_POST['uname']))
{
    if($_POST["role"]=='user')
    {
        $user= new User($_SESSION["tmpUser"]["email"], $_SESSION["tmpUser"]["password"]);
        $regController = new RegistrationController($user);
        $regController->register();
    }
    else
    {
        $user= new Artisan($_SESSION["tmpUser"]["email"], $_SESSION["tmpUser"]["password"]);
        $regController = new RegistrationController($user);
        $regController->register();
    }
}
if(isset($_POST['email']))
{
    $user= new User($_REQUEST['email'], $_REQUEST['password']);
    $regController = new RegistrationController($user);
    $regController->createAccount();
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