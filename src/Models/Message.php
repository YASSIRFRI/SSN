<?php
include '../../dbconfig.php';

class Message {
    protected $sender;
    protected $recipient;
    protected $content;

    public function __construct($sender, $recipient, $content) {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->content = $content;
    }

    public function getSender() {
        return $this->sender;
    }


    public function getRecipient() {
        return $this->recipient;
    }

    public function getContent() {
        return $this->content;
    }

    public function sendMessage() {
        try {
            $connexion = $GLOBALS['connexion'];
            $receiver_id_query = $connexion->prepare('SELECT user_id FROM users WHERE email = ?');
            $receiver_id_query->execute([$this->recipient]);
            $this->recipient = $receiver_id_query->fetch()['user_id'];
            $stmt = $connexion->prepare('INSERT INTO messages (sender_id, receiver_id, message_text, date_sent) VALUES (?, ?, ?, NOW())');
            $stmt->execute([$this->sender, $this->recipient, $this->content]);
            return true; // Return true if the message was sent successfully
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Return false if there was an error sending the message
        }
    }
    public static function getMessages($user_id, $recipient=null) {
        try {
            $connexion = $GLOBALS['connexion'];
            if ($recipient == null) {
                $stmt = $connexion->prepare('SELECT * FROM messages WHERE sender = ? OR recipient = ? ORDER BY date_sent DESC');
                $stmt->execute([$user_id, $user_id]);
            } else {
                $stmt = $connexion->prepare('SELECT * FROM messages WHERE (sender = ? AND recipient = ?) OR (sender = ? AND recipient = ?) ORDER BY date_sent DESC');
                $stmt->execute([$user_id, $recipient, $recipient, $user_id]);
            }
            $messages = $stmt->fetchAll();
            return $messages;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}

?>