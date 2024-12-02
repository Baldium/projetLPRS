<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';

class EventsRepository {
    public static function getEventsNumber() {
        $bdd = Bdd::my_bdd();
        $count = $bdd->prepare("SELECT COUNT(*) as nbEvents FROM event;");
        $count->execute();
        $nbEvents = $count->fetch();
        return $nbEvents["nbEvents"];
    }

    public static function getEvents() {
        $bdd = Bdd::my_bdd();
        $selection = $bdd->prepare("SELECT * FROM event;");
        $selection->execute();
        return $selection->fetchAll();
    }

    public static function getEventById($id) {
        $bdd = Bdd::my_bdd();
        $event = $bdd->prepare("SELECT * FROM event WHERE id_event = :id;");
        $event->execute(array(
            "id" => $id
        ));
        return $event->fetch();
    }

    public static function updateEvent($id, $type_event, $title, $description, $adress, $nb_place, $date_event) {
        $bdd = Bdd::my_bdd();
        $update = $bdd->prepare("UPDATE event SET type_event = :type_event, title = :title, description = :description, adress = :adress, nb_place = :nb_place, date_event = :date_event WHERE id_event = :id;");
        $update->execute(array(
            "id" => $id,
            "type_event" => $type_event,
            "title" => $title,
            "description" => $description,
            "adress" => $adress,
            "nb_place" => $nb_place,
            "date_event" => $date_event
        ));
    }

    public static function disableEvent($id) {
        $bdd = Bdd::my_bdd();
        $disable = $bdd->prepare("UPDATE event SET disponible = 0 WHERE id_event = :id;");
        $disable->execute(array( 
            "id" => $id
        ));
    }

    public static function enabledEvent($id) {
        $bdd = Bdd::my_bdd();
        $enabled = $bdd->prepare("UPDATE event SET disponible = 1 WHERE id_event = :id;");
        $enabled->execute(array( 
            "id" => $id
        ));
    }

    public static function deleteEvent($id) {
        $bdd = Bdd::my_bdd();
        $delete = $bdd->prepare("DELETE FROM event WHERE id_event = :id;");
        $delete->execute(array(
            "id" => $id
        ));
    }
}
