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
            $stmt = $connection->prepare('INSERT INTO services (name, description) VALUES (?, ?)');
            $stmt->execute([$this->name, $this->description]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
  
    public static function findById($id) {
        try {
            $connection = $GLOBALS['connexion'];
            $stmt = $connection->prepare('SELECT * FROM services WHERE id = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                return new Service($row['id'], $row['name'], $row['description']);
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
            $stmt = $connection->prepare('DELETE FROM services WHERE id = ?');
            $stmt->execute([$this->id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
