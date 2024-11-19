<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';

class OffersRepository
{
    public static function getAllOffers() 
    {
        $my_bdd = Bdd::my_bdd();
        $reqGetOffers = $my_bdd->query("SELECT * FROM `offers` ORDER by id_offers DESC LIMIT 8");
        $data = $reqGetOffers->fetchAll();
        if($data){
            return $data;
        }
        else {
            return "Aucune nouvelles offres";
        }
    }

    public static function getCountOffers()
    {
        $my_bdd = Bdd::my_bdd();
        $reqCountOffers = $my_bdd->query("SELECT COUNT(*) as nb_offers FROM `offers`");
        $data = $reqCountOffers->fetch(PDO::FETCH_ASSOC);
        if($data){
            return $data['nb_offers'];
        }
        else {
            return 0;
        }

    }

}

?>