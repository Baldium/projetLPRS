<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';

class UsersRespository
{
    public static function getAllUsersNotAccepted()
    {
        $my_bdd = Bdd::my_bdd();
        $reqGetUsers = $my_bdd->query("SELECT * FROM `users` WHERE accepted IS NULL LIMIT 5");
        $data = $reqGetUsers->fetchAll();
        if($data){
            return $data;
        }
        else {
            return "Aucun nouveaux utilisateurs";
        }
    }

    public static function rejectOrAcceptedCandidat($id, $response)
    {
        $my_bdd = Bdd::my_bdd();
        $update = $my_bdd->prepare("UPDATE `users` SET `accepted`= :response WHERE id_users = :id");
        $update->execute(array( 
            'response' => $response,
            'id' => $id
        ));
    }



}

?>