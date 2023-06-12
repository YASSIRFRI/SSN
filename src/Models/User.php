<?php
include '../../dbconfig.php';
 class User {
    protected $email;
    protected $password;
    protected $user_id;
    protected $role;
    protected  $isAuthenticated = false;
  
    public function __construct($email, $password) {
      $this->email = $email;
      $this->password = $password;
      //try {
        $connexion=$GLOBALS['connexion'];
        $stmt = $connexion->prepare('SELECT * FROM users WHERE email = ? ');
        $stmt->execute([$this->email]);
        $row = $stmt->fetch();
        if ($row && password_verify($this->password, $row['password'])) {
          $this->isAuthenticated = true;
          $this->user_id = $row['user_id'];
          $this->role = $row['role'];

       // }

      //} catch (PDOException $e) {
        //echo "Connection failed: " . $e->getMessage();
      }
    }
    
    // Getter for email
    public function getemail() {
      return $this->email;
    }

    public function getId() {
      return $this->user_id;
    }

    // Getter for password
    public function getPassword() {
      return $this->password;
    }
    //isAuthenticated
    public function isAuthenticated() {
      return $this->isAuthenticated;
    }

    
    // Getter for role
    public function getRole() {
      return $this->role;
    }

    public function createAccount()
    {
      if($this->isAuthenticated){
        return false;}
      else{
          //try {
            $connexion=$GLOBALS['connexion'];
            $user_id=mt_rand(1,999999999);
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt = $connexion->prepare('INSERT INTO users (user_id,email, password) VALUES (?, ?,?)');
            $stmt->execute([$user_id,$this->email, $this->password]);
            $_SESSION["tmpUser"]["email"]=$this->email;
            $_SESSION["tmpUser"]["password"]=$this->password;
            $_SESSION["tmpUser"]["user_id"]=$user_id;
            return true;
          //} catch (PDOException $e) {
            //echo "Connection failed: " . $e->getMessage();
            //return false;
          //}
      }
    }
    public function completeUserInfo($uname, $phone, $role)
    {
        //try {
            $connexion = $GLOBALS['connexion'];
            $stmt = $connexion->prepare('UPDATE users SET username=?, phone_number=?, role=? WHERE email=?');
            $stmt->execute([$uname, $phone, $role, $_SESSION["tmpUser"]["email"]]);
            return true;
        //} catch (PDOException $e) {
            //echo "Connection failed: " . $e->getMessage();
            //return false;
        //}
    }

}





?>