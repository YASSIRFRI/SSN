<?php

include '../dbconfig.php';
class Artisan extends User{

    function __construct($email, $password, $role)
    {
        parent::__construct($email, $password, $role);
    }

}



?>