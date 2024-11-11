<?php
include_once '../../models/event.php';
include_once '../../utils/Bdd.php';
include '../../init.php';


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
                'disponible' => 1,
            ]);
            $req2 = $bdd->prepare('INSERT INTO createur_event (ref_event, ref_prof) VALUES (:ref_event, :ref_prof)');
            $req2->execute([
                'ref_event' => $bdd->lastInsertId(),
                'ref_prof' => $_SESSION['id_prof'],
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


    public static function getAdmins() {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare("SELECT nom FROM prof union SELECT nom FROM users");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

}