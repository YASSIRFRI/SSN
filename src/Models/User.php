<?php
include '../dbconfig.php';
class User {
    private $email;
    private $password;
    private $role;
    private $isAuthenticated = false;
  
    public function __construct($email, $password) {
      $this->email = $email;
      $this->password = $password;
      try {
        $connexion=$GLOBALS['connexion'];
        $stmt = $connexion->prepare('SELECT * FROM users WHERE email = ? AND password = ?');
        $stmt->execute([$this->email, $this->password]);
        $row = $stmt->fetch();
        if ($row) {
          $this->isAuthenticated = true;
          $this->role = $row['role'];
        }

      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }
    
    // Getter for email
    public function getemail() {
      return $this->email;
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

    public function register()
    {
      if($this->isAuthenticated){
        return false;}
      else{
          try {
            $connexion=$GLOBALS['connexion'];
            $stmt = $connexion->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
            $stmt->execute([$this->email, $this->password]);
            return true;
          } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
          }
      }
    }
    
    // Checks if user is an admin
    public function isAdmin() {
      return ($this->role === 'admin');
    }
  }



?>