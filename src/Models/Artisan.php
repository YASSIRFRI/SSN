<?php

include '../../dbconfig.php';



class Artisan extends User{

    public function __construct($email, $password,)
    {
        parent::__construct($email, $password);
        $this->role = 'artisan';
    }

    public function completeArtisanInfo($uname,$phone,$role,$compName, $compAdress, $description, $profilPic)
    {
        parent::completeUserInfo($uname,$phone,$role);
        //try {
            $connexion = $GLOBALS['connexion'];
            $artisan_id = mt_rand(1, 999999999);
            $stmt = $connexion->prepare('INSERT INTO artisans (artisan_id,user_id, company_name, company_address, description, profile_picture) VALUES (?, ?, ?, ?, ?,? )');
            $stmt->execute([$artisan_id,$_SESSION["tmpUser"]["user_id"],$compName, $compAdress, $description, $profilPic]);
            return true;
        //} catch (PDOException $e) {
            //echo "Connection failed: " . $e->getMessage();
            //return false;
        //}
        
    } 

}



?>