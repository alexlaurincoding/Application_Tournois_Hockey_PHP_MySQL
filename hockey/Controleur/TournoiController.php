<?php

class TournoiController {

    public function Index() {
        return 'ligueAdmin';
    }
    
    public function Afficher(){
       $lesTournois = TournoiServices::getListeTournoi();
       if (Count($lesTournois) == 0){
           echo '{"nombre":"aucun"}';
           die();
       }
       
       $tableauObjetsJSON = "[";
       foreach($lesTournois as $tournoi){
           $tableauObjetsJSON.= '{"id_tournoi": '.$tournoi->getId_tournoi() .', "nom_tournoi": "' .$tournoi->getNom_tournoi().'", "min": '.$tournoi->getNbr_min_equipes().', "max": '.$tournoi->getNbr_max_equipes().',"debut": "'.$tournoi->getDate_debut_tournoi().'", "fin": "'.$tournoi->getDate_fin_tournoi().'", "inscription": "'.$tournoi->getDate_limite_inscription().'"},';
       }
       
       //Enlever la derniere virgule et la remplacer par ] pour fermer le tableau
       $tableauFinal = substr($tableauObjetsJSON, 0, -1)."]";
       echo $tableauFinal;
       die();
       Util::redirectToAction('Tournoi');
       
    }
    
    public function ChercherTournoi(){
       $idTournoi = $nom_tournoi = $_REQUEST['idTournoi'];
       $tournoi = TournoiServices::getTournoi($idTournoi);
       
       echo '{"reponse" : "OK", "id_tournoi": '.$tournoi->getId_tournoi() .', "nom_tournoi": "' .$tournoi->getNom_tournoi().'", "min": '.$tournoi->getNbr_min_equipes().', "max": '.$tournoi->getNbr_max_equipes().', "debut": "'.$tournoi->getDate_debut_tournoi().'", "fin": "'.$tournoi->getDate_fin_tournoi().'", "inscription": "'.$tournoi->getDate_limite_inscription().'"}';
       die();
       
    }

    public function Ajouter() {
        $nom_tournoi = $_REQUEST['nom'];
        $nbr_min_equipes = $_REQUEST['min'];
        $nbr_max_equipes = $_REQUEST['max'];
        $date_debut_tournoi = $_REQUEST['debut'];
        $date_fin_tournoi = $_REQUEST['fin'];
        $date_limite_inscription = $_REQUEST['limite'];

        TournoiServices::ajouterTournoi($nom_tournoi, $nbr_min_equipes, $nbr_max_equipes, $date_debut_tournoi, $date_fin_tournoi, $date_limite_inscription);
        echo '{"reponse":"OK"}';
        die();
        Util::redirectToAction('Tournoi');
    }

    public function Modifier() {
        $idTournoi = $_REQUEST['idTournoi'];
        $nomTournoi = $_REQUEST['nom'];
        $min = $_REQUEST['min'];
        $max = $_REQUEST['max'];
        $debut = $_REQUEST['debut'];
        $fin = $_REQUEST['fin'];
        $limite = $_REQUEST['limite'];
        
        TournoiServices::modifierTournoi($idTournoi, $nomTournoi, $min, $max, $debut, $fin, $limite);
        echo '{"reponse":"OK"}';
        die();
                
        
    }
    
    public function Supprimer(){
        $idTournoi = $_REQUEST['idTournoi'];
        TournoiServices::supprimerTournoi($idTournoi);
        echo '{"reponse":"OK"}';
        die();
        Util::redirectToAction('Tournoi');
    }

}
