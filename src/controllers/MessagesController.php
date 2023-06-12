<?php

include '../../dbconfig.php';
include '../models/Message.php';
session_start();

class MessagesController {
    protected $message;

    public function __construct(Message $message) {
        $this->message = $message;
    }



    public function sendMessage() {
        return $this->message->sendMessage();
    }


}


if(isset($_POST['recipient']) || isset($_POST['content'])) {
    $sender = $_SESSION['user_id'];
    $recipient = $_POST['recipient'];
    $content = $_POST['content'];
    $message = new Message($sender, $recipient, $content);
    $messagesController = new MessagesController($message);
    $messagesController->sendMessage();
    header('Location: ' . $_SERVER['HTTP_REFERER']);

}



?>