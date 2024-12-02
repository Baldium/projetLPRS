<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';

class MessagesRepository {
    public static function getMessages() {
        $bdd = Bdd::my_bdd();
        $selection = $bdd->prepare("SELECT * FROM message;");
        $selection->execute();
        return $selection->fetchAll();
    }

    public static function deleteMessage($senderId, $receiverId) {
        $bdd = Bdd::my_bdd();
        $delete = $bdd->prepare("DELETE FROM message WHERE sender_id = :senderId AND receiver_id = :receiverId;");
        $delete->execute(array(
            "senderId" => $senderId,
            "receiverId" => $receiverId
        ));
    }
}
