<?php
include_once '../../models/event.php';
include_once '../../utils/Bdd.php';

class EventRepository {

    public function createEvent($type, $titre, $description, $lieu, $nombre_place) {
        $my_bdd = Bdd::my_bdd();
        $disponible = 1;

        try {
            $query = 'INSERT INTO event (type_event, title, description, adress, nb_place, disponible)
                      VALUES (:type, :titre, :description, :lieu, :nombre_place, :disponible)';
            $stmt = $my_bdd->prepare($query);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':lieu', $lieu);
            $stmt->bindParam(':nombre_place', $nombre_place);
            $stmt->bindParam(':disponible', $disponible);

            $stmt->execute();

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }
    }
}