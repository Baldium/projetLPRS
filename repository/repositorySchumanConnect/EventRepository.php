<?php
include_once '../../models/event.php';
include_once '../../utils/Bdd.php';
include '../../init.php';


class EventRepository {

    public function createEvent($type, $titre, $description, $lieu, $nombre_place, $date, $admins) {
        $bdd = Bdd::my_bdd();

        try {

            $req = $bdd->prepare('INSERT INTO event (type_event, title, description, adress, nb_place, date_created, date_event, disponible) VALUES (:type, :titre, :description, :lieu, :nombre_place, current_date, :date_event, :disponible)');
            $req->execute([
                'type' => $type,
                'titre' => $titre,
                'description' => $description,
                'lieu' => $lieu,
                'nombre_place' => $nombre_place,
                'date_event' => $date,
                'disponible' => 1
            ]);
            $id_event =$bdd->lastInsertId();

            $req2 = $bdd->prepare('INSERT INTO createur_event (ref_event, ref_user) VALUES (:ref_event, :ref_user)');
            $req2->execute([
                'ref_event' => $id_event,
                'ref_user' => $_SESSION['id_users']
            ]);

            foreach ($admins as $admin) {
                $req3 = $bdd->prepare('INSERT INTO createur_event (ref_event, ref_user) VALUES (:ref_event, :ref_user)');
                $req3->execute([
                    'ref_event' => $id_event,
                    'ref_user' => $admin
                ]);
            }

            header('Location: ../../view/viewEvent/mes_evenement.php');
            exit();

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }
    }


 public static function inscriptionEventLibre($userId, $eventId) {
     $bdd = Bdd::my_bdd();
     $req = $bdd->prepare('INSERT INTO inscription_event (ref_id_users, ref_id_event, date_created, accepted) VALUES (:ref_user, :ref_event, :date_created, :accepted)');
     $req->execute([
         'ref_user' => $userId,
         'ref_event' => $eventId,
         'date_created' => date('Y-m-d H:i:s'),
         'accepted' => 1
     ]);
    }


    public static function inscriptionEventStrict($userId, $eventId)
    {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare('INSERT INTO inscription_event (ref_id_users, ref_id_event, date_created) VALUES (:ref_user, :ref_event, :date_created)');
        $req->execute([
            'ref_user' => $userId,
            'ref_event' => $eventId,
            'date_created' => date('Y-m-d H:i:s')
        ]);
    }

    public static function getPlaceRestante($eventId) {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare('SELECT nb_place FROM event WHERE id_event = :id');
        $req->execute([':id' => $eventId]);
        $place = $req->fetch(PDO::FETCH_ASSOC);

        $req2 = $bdd->prepare('SELECT COUNT(*) as inscrit FROM inscription_event WHERE ref_id_event = :id');
        $req2->execute([':id' => $eventId]);
        $inscrits = $req2->fetch(PDO::FETCH_ASSOC);
        $placeRestante = $place['nb_place'] - $inscrits['inscrit'];
        return $placeRestante;
    }

    public static function getAllEventSortedByDate(){

        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare("SELECT * FROM event ORDER BY date_event ASC");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllEventSortedBy($sort) {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare("SELECT * FROM event ORDER BY $sort ASC");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getEventsByUserRegistration($userId) {
    $bdd = Bdd::my_bdd();
    $req = $bdd->prepare("SELECT e.* FROM event AS e
                          INNER JOIN inscription_event AS ie ON e.id_event = ie.ref_id_event
                          WHERE ie.ref_id_users = :user_id");
    $req->execute([':user_id' => $userId]);
    return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function deleteEvent($eventId) {
    $bdd = Bdd::my_bdd();
    $req = $bdd->prepare("DELETE FROM event WHERE id_event = :id");
    $req->execute([':id' => $eventId]);
    }

public static function updateEvent($eventId, $type, $title, $description, $address, $nb_place, $date_event) {
    $bdd = Bdd::my_bdd();
    $req = $bdd->prepare("UPDATE event SET type_event = :type, title = :title, description = :description, adress = :address, nb_place = :nb_place, date_event = :date_event WHERE id_event = :id");
    $req->execute([
        ':type' => $type,
        ':title' => $title,
        ':description' => $description,
        ':address' => $address,
        ':nb_place' => $nb_place,
        ':date_event' => $date_event,
        ':id' => $eventId
    ]);
    }




    public static function getEventsByUser($idUsers)
    {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare("SELECT * FROM event as e inner join createur_event as c on e.id_event = c.ref_event WHERE c.ref_user = :id_users");
        $req->execute([':id_users' => $idUsers]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getAdmins() {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare("SELECT * FROM users");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEventById($id) {
        $bdd = Bdd::my_bdd();
        $req = $bdd->prepare("SELECT * FROM event WHERE id_event = :id");
        $req->execute([':id' => $id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function modifierEvenement($id, $type, $titre, $description, $lieu, $nombre_place) {
        $bdd = Bdd::my_bdd();
        try {
            $req = $bdd->prepare('UPDATE event SET type_event = :type, title = :titre, description = :description, adress = :lieu, nb_place = :nombre_place WHERE id_event = :id');
            $req->execute([
                'type' => $type,
                'titre' => $titre,
                'description' => $description,
                'lieu' => $lieu,
                'nombre_place' => $nombre_place,
                'id' => $id
            ]);

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }



    }

}