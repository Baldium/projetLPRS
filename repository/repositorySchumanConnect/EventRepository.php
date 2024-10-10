<?php
include_once '../../models/event.php';
include_once '../../utils/Bdd.php';

class EventRepository {

    public function createEvent($type, $titre, $description, $lieu, $elements_requis, $nombre_place) {
        $my_bdd = Bdd::my_bdd();

        try {
            $query = 'INSERT INTO events (type, titre, description, lieu, elements_requis, nombre_place)
                      VALUES (:type, :titre, :description, :lieu, :elements_requis, :nombre_place)';
            $stmt = $my_bdd->prepare($query);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':lieu', $lieu);
            $stmt->bindParam(':elements_requis', $elements_requis);
            $stmt->bindParam(':nombre_place', $nombre_place);

            $stmt->execute();

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }
    }
}