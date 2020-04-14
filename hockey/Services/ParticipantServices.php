<?php

class ParticipantServices{
    
    public static function ajouterParticipant($Equipe, $Tournoi){
        $dao = new ParticipantDAO();
        return $dao->creerParticipant($Equipe, $Tournoi);
    }
    
    public static function supprimerParticipant($Equipe, $Tournoi){
        $dao = new ParticipantDAO();
        return $dao->supprimerParticipant($Equipe, $Tournoi);
    }
   
    
    public static function getParticipant($Equipe, $Tournoi){
        $dao = new ParticipantDAO();
        return $dao->obtenir($Equipe, $Tournoi);
    }
    
    public static function getParticipants($Tournoi){
        $dao = new ParticipantDAO();
        return $dao->obtenirParTournoi($Tournoi);
    }
    
    public static function getNonParticipants($Tournoi){
        $nonParticipants = array();
        $daoPart = new ParticipantDAO();
        $daoEquipes = new EquipeDAO();
        $listeEquipes = $daoEquipes->obtenirEquipes();
        
        foreach ($listeEquipes as $Equipe){
            //Si l'equipe n'est pas dans le tournoi, l'ajouter a la liste des non-participants
            if ($daoPart->obtenir($Equipe, $Tournoi) == null){
                array_push($nonParticipants, $Equipe);
            }
        }
        
        return $nonParticipants;
    }
    
    public static function creerFiche($Participant){
        $dao = new ParticipantDAO();
        return $dao->creerFiche($Participant);
    }
    
    public static function obtenirFiche($Participant){
        $dao = new ParticipantDAO();
        return $dao->obtenirFiche($Participant);
    }
    
    public static function modifierFiche($Participant, $v, $d, $n) {
        $dao = new ParticipantDAO();
        return $dao->modifierFiche($Participant, $v, $d, $n);
    }
}

