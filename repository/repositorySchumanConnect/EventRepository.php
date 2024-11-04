<?php
include_once '../../models/event.php';
include_once '../../utils/Bdd.php';

class EventRepository {

    public function createEvent($type, $titre, $description, $lieu, $nombre_place) {
        $bdd = Bdd::my_bdd();

        try {

            $req = $bdd->prepare('INSERT INTO event (type_event, title, description, adress, nb_place, disponible) VALUES (:type, :titre, :description, :lieu, :nombre_place, :disponible)');
            $req->execute([
                'type' => $type,
                'titre' => $titre,
                'description' => $description,
                'lieu' => $lieu,
                'nombre_place' => $nombre_place,
                'disponible' => 1
            ]);



        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }
    }


    public static function getEventsByUser($idProf)
    {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare("SELECT * FROM events WHERE id_prof = :id_prof");
        $req->execute([':id_prof' => $idProf]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}