<?php

class ParticipantController {

    public function Index() {
        return "ligueAdmin";
    }

    public function Ajouter() {
        $idEquipe = $_REQUEST['idEquipe'];
        $idTournoi = $_REQUEST['idTournoi'];

        //Aller chercher les objets a partir des ID
        $uneEquipe = EquipeServices::getEquipe($idEquipe);
        $unTournoi = TournoiServices::getTournoi($idTournoi);

        //Creer le nouveau Participant (objet) puis le mettre dans la BD
        ParticipantServices::ajouterParticipant($uneEquipe, $unTournoi);

        $leParticipant = ParticipantServices::getParticipant($uneEquipe, $unTournoi);

        //Creer la Fiche du Participant (s'il n'a pas de fiche)
        if (ParticipantServices::obtenirFiche($leParticipant) == null) {
            ParticipantServices::creerFiche($leParticipant);
        }
        echo '{"reponse":"OK"}';
        die();
    }

    public function Supprimer() {
        $idEquipe = $_REQUEST['idEquipe'];
        $idTournoi = $_REQUEST['idTournoi'];

        //Aller chercher les objets a partir des ID
        $uneEquipe = EquipeServices::getEquipe($idEquipe);
        $unTournoi = TournoiServices::getTournoi($idTournoi);

        //Effacer le Participant
        ParticipantServices::supprimerParticipant($uneEquipe, $unTournoi);
        echo '{"reponse":"OK"}';
        die();
    }
    
    public function Afficher(){
        $idTournoi = $_REQUEST['idTournoi'];
        
        //Aller chercher les participants pour ce tournoi
        $Tournoi = TournoiServices::getTournoi($idTournoi);
        $lesParticipants = ParticipantServices::getParticipants($Tournoi);
        
        //Si aucun participant, renvoyer message aucun
        if (count($lesParticipants)==0){
            echo '{"nombre":"aucun"}';
            die();
        }
        
        $tableauObjetsJSON = "[";
        foreach($lesParticipants as $Participant){
           $Equipe = $Participant->getEquipe_participante();
           $idEquipe = $Equipe->getId_equipe();
           $nomEquipe = $Equipe->getNom_equipe();
           $tableauObjetsJSON.= '{"id_tournoi": '.$idTournoi .', "id_equipe": '.$idEquipe .', "nom_equipe": "'.$nomEquipe.'"},';
       }
       
       //Enlever la derniere virgule et la remplacer par ] pour fermer le tableau
       $tableauFinal = substr($tableauObjetsJSON, 0, -1)."]";
       echo $tableauFinal;
       die();
        
    }
    
    public function AfficherAutres(){
        $idTournoi = $_REQUEST['idTournoi'];
        
        //Aller chercher les participants pour ce tournoi
        $Tournoi = TournoiServices::getTournoi($idTournoi);
        $nonParticipants = ParticipantServices::getNonParticipants($Tournoi);
        
        //Si aucun participant, renvoyer message aucun
        if (count($nonParticipants)==0){
            echo '{"nombre":"aucun"}';
            die();
        }
        
        $tableauObjetsJSON = "[";
        foreach($nonParticipants as $Equipe){
           $idEquipe = $Equipe->getId_equipe();
           $nomEquipe = $Equipe->getNom_equipe();
           $tableauObjetsJSON.= '{"id_tournoi": '.$idTournoi .', "id_equipe": '.$idEquipe .', "nom_equipe": "'.$nomEquipe.'"},';
       }
       
       //Enlever la derniere virgule et la remplacer par ] pour fermer le tableau
       $tableauFinal = substr($tableauObjetsJSON, 0, -1)."]";
       echo $tableauFinal;
       die();
    }
}
