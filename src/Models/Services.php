<?php

class Service {
    protected $id;
    protected $name;
    protected $description;
  
    public function __construct($id, $name, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
  
    public function save() {
        try {
            $connection = $GLOBALS['connexion'];
            $stmt = $connection->prepare('INSERT INTO services (service_id,service_name, service_description) VALUES (?, ?,?)');
            $stmt->execute([$this->id,$this->name, $this->description]);
            $stmt= $connection->prepare('INSERT INTO artisan_services (artisan_id,service_id) VALUES (?, ?)');
            $stmt->execute([$_SESSION['user_id'],$this->id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
  
    public static function findById($id) {
        try {
            $connection = $GLOBALS['connexion'];
            $stmt = $connection->prepare('SELECT * FROM services WHERE service_id = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                return new Service($row['service_id'], $row['service_name'], $row['service_description']);
            }
            return null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
  
    public function update($name, $description) {
        try {
            $connection = $GLOBALS['connexion'];
            $stmt = $connection->prepare('UPDATE services SET name = ?, description = ? WHERE id = ?');
            $stmt->execute([$this->name, $this->description, $this->id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
  
    public function delete() {
        try {
            $connection = $GLOBALS['connexion'];
            $stmt = $connection->prepare('DELETE FROM services WHERE service_id = ?');
            $stmt->execute([$this->id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
