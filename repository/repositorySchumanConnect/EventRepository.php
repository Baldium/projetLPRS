<?php
include_once '../../models/event.php';
include_once '../../utils/Bdd.php';
include '../../init.php';


class EventRepository {

    public function createEvent($type, $titre, $description, $lieu, $nombre_place, $admins) {
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
            header('Location: ../../view/viewEvent/mes_evenement.php');
            exit();

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }



    }

}