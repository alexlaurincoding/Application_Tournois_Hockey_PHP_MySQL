<?php

class calendrierController {

    public function Index() {
        return 'calendrier';
    }
    
    public function ObtenirCalendrier(){
        $idTournoi = $_REQUEST['idTournoi'];
        $Tournoi = TournoiServices::getTournoi($idTournoi);
        $Calendrier = CalendrierServices::obtenirCalendrierParTournoi($Tournoi);
        
        if ($Calendrier == null){
            echo '{"reponse":"erreur"}';
            die();
        }
        echo '{"reponse": "OK", "id_calendrier": '.$Calendrier->getId_calendrier().', "debut": "'.$Calendrier->getDate_debut_calendrier().'", "fin": "'.$Calendrier->getDate_fin_calendrier().'", "nombre_equipes": '.$Calendrier->getNbr_equipes().'}';

        die();
    }

    public function CreerCalendrier() {
        $nbrEquipes = $_REQUEST['nombre'];
        $debutCal = $_REQUEST['debut'];
        $finCal = $_REQUEST['fin'];
        $idTournoi = $_REQUEST['idTournoi'];
        $Tournoi = TournoiServices::getTournoi($idTournoi);
        $min = $Tournoi->getNbr_min_equipes();
        $max = $Tournoi->getNbr_max_equipes();
        
        
        if ((int)$nbrEquipes < (int)$min || (int)$nbrEquipes > (int)$max){
            echo '{"reponse": "non", "erreur" : "nombre", "min": '.$min.', "max": '.$max.'}';
            die;
        }
        

        CalendrierServices::creerCalendrier($Tournoi, $debutCal, $finCal, $nbrEquipes);
        
        echo '{"reponse":"OK"}';
        die();
    }

    public function ModifierCalendrier() {
        $nbrEquipes = $_REQUEST['nombre'];
        $debutCal = $_REQUEST['debut'];
        $finCal = $_REQUEST['fin'];
        $idCalendrier = $_REQUEST['idCalendrier'];
        
        CalendrierServices::modifierCalendrier($idCalendrier, $debutCal, $finCal, $nbrEquipes);
        
        echo '{"reponse":"OK"}';
        die();
    }
    
    
    public function CreerPartie() {
        $idEquipeA = $_REQUEST['idEquipeA'];
        $EquipeA = EquipeServices::getEquipe($idEquipeA);
        $idEquipeB = $_REQUEST['idEquipeB'];
        $EquipeB = EquipeServices::getEquipe($idEquipeB);
        $idTournoi = $_REQUEST['idTournoi'];
        $Tournoi = TournoiServices::getTournoi($idTournoi);
        $jour = $_REQUEST['jour'];
        $heure = $_REQUEST['heure'];
        $idPatinoire = $_REQUEST['idPatinoire'];
        $Patinoire = CalendrierServices::obtenirPatinoire($idPatinoire);

        $Partie = CalendrierServices::creerPartie($jour, $heure, $Tournoi, $EquipeA, $EquipeB, $Patinoire);
         if ($Partie== null){
            echo '{"reponse":"aucun"}';
            die();
        }
        echo '{"reponse":"OK"}';
        die();
    }
    
    public function AfficherParties(){
        $idTournoi = $_REQUEST['idTournoi'];
        $Tournoi = TournoiServices::getTournoi($idTournoi);
        $lesParties = CalendrierServices::obtenirParties($Tournoi);
        
         //Si aucune partie, renvoyer message aucun
        if (count($lesParties)==0){
            echo '{"nombre":"aucun"}';
            die();
        }
        
        $tableauObjetsJSON = "[";
        foreach($lesParties as $partie){
            $idPartie = $partie->getId_partie();
            $participA = $partie->getParticipant_local();
            $eqA = $participA->getEquipe_participante();
            $idEqA = $eqA->getId_equipe();
            $participB = $partie->getParticipant_adverse();
            $eqB = $participB->getEquipe_participante();
            $idEqB = $eqB->getId_equipe();
            $nomEqA = $eqA->getNom_equipe();
            $nomEqB = $eqB->getNom_equipe();
            $patin = $partie->getPatinoire();
            $idPatin = $patin->getId_patinoire();
            $nomPatin = $patin->getNom_arena();
            $ville = $patin->getVille_arena();
            $jour = $partie->getJour_partie();
            $heure = $partie->getHeure_partie();
            $butsLocaux = $partie->getButsLocaux();
            $butsAdverses = $partie->getButsAdverses();
                        
            if ($butsLocaux == null){
                $tableauObjetsJSON.= '{"id_partie": '.$idPartie .', "id_tournoi": '.$idTournoi .', "id_equipeA": '.$idEqA .', "id_equipeB": '.$idEqB. ', "nom_equipeA": "'.$nomEqA .'", "nom_equipeB": "'.$nomEqB.'", "buts_locaux": "null", "buts_adverses": "null", "id_patinoire": '.$idPatin. ', "nom_patinoire": "'.$nomPatin.'", "ville": "'.$ville.'", "jour": "'.$jour.'", "heure": "'.$heure.'"},';
            }
            else{
                $tableauObjetsJSON.= '{"id_partie": '.$idPartie .', "id_tournoi": '.$idTournoi .', "id_equipeA": '.$idEqA .', "id_equipeB": '.$idEqB.', "nom_equipeA": "'.$nomEqA .'", "nom_equipeB": "'.$nomEqB.'", "buts_locaux": '.$butsLocaux.', "buts_adverses": '.$butsAdverses.', "id_patinoire": '.$idPatin.', "nom_patinoire": "'.$nomPatin.'", "ville": "'.$ville.'", "jour": "'.$jour.'", "heure": "'.$heure.'"},';
            }
            
       }
       
       //Enlever la derniere virgule et la remplacer par ] pour fermer le tableau
       $tableauFinal = substr($tableauObjetsJSON, 0, -1)."]";
       echo $tableauFinal;
       die();
    }
    
     public function SupprimerPartie(){
        $idPartie = $_REQUEST['idPartie'];        
        CalendrierServices::supprimerPartie($idPartie);
        echo '{"reponse":"OK"}';
        die();
    }
    
     public function ModifierPartie(){
        $idPartie = $_REQUEST['idPartie']; 
        $idEquipeA = $_REQUEST['idEquipeA'];
        $EquipeA = EquipeServices::getEquipe($idEquipeA);
        $idEquipeB = $_REQUEST['idEquipeB'];
        $EquipeB = EquipeServices::getEquipe($idEquipeB);
        $jour = $_REQUEST['jour'];
        $heure = $_REQUEST['heure'];
        $idPatinoire = $_REQUEST['idPatinoire'];
        $Patinoire = CalendrierServices::obtenirPatinoire($idPatinoire);

        $Partie = CalendrierServices::modifierPartie($idPartie, $jour, $heure, $EquipeA, $EquipeB, $Patinoire);
         if ($Partie== null){
            echo '{"reponse":"aucun"}';
            die();
        }
        echo '{"reponse":"OK"}';
        die();
    }
    
    public function MatchDuJour(){
        $date = $_REQUEST['date'];
        $listePartie = CalendrierServices::obtenirPartieParDate($date);

        $_REQUEST['parties'] = $listePartie;
        
        echo Count($listePartie);
        
        return 'matchDuJour';
    
    }
}
