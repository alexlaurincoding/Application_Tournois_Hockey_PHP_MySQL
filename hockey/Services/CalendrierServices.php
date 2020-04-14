<?php

class CalendrierServices{
    
    public static function creerCalendrier($Tournoi, $debutCal, $finCal, $nbrEquipes){
        $daoCal = new CalendrierDAO();
        
        return $daoCal->creerCalendrier($Tournoi, $debutCal, $finCal, $nbrEquipes);
    }
    
    public static function modifierCalendrier($idCalendrier, $debutCal, $finCal, $nbrEquipes){
        $daoCal = new CalendrierDAO();
        return $daoCal->modifierCalendrier($idCalendrier, $debutCal, $finCal, $nbrEquipes);
    }
    
    public static function creerPartie($jour, $heure, $Tournoi, $EquipeA, $EquipeB, $Patinoire){
         $daoCal = new CalendrierDAO();
         return $daoCal->creerPartie($jour, $heure, $Tournoi, $EquipeA, $EquipeB, $Patinoire);
    }
    
    public static function supprimerPartie($idPartie){
         $daoCal = new CalendrierDAO();
         return $daoCal->supprimerPartie($idPartie);
    }
    
    public static function modifierPartie($idPartie, $jour, $heure, $EquipeA, $EquipeB, $Patinoire){
         $daoCal = new CalendrierDAO();
         return $daoCal->modifierPartie($idPartie, $jour, $heure, $EquipeA, $EquipeB, $Patinoire);
    }
    
    public static function obtenirParties($Tournoi){
        $daoCal = new CalendrierDAO();
        return $daoCal->obtenirParties($Tournoi);
    }
    
    public function obtenirPartie($idPartie){
        $daoCal = new CalendrierDAO();
        return $daoCal->obtenirPartie($idPartie);
    }
    
    public function obtenirToutesPartiesDesc(){
        $daoCal = new CalendrierDAO();
        return $daoCal->obtenirToutesPartiesDesc();
    }
            
    public function obtenirPatinoires(){
        $daoCal = new CalendrierDAO();
        return $daoCal->obtenirPatinoires();
    }
    
    public function obtenirPatinoire($id){
        $daoCal = new CalendrierDAO();
        return $daoCal->obtenirPatinoire($id);
    }
    
    public function obtenirCalendrierParTournoi($Tournoi){
        $daoCal = new CalendrierDAO();
        return $daoCal->obtenirCalendrierParTournoi($Tournoi);
    }
    
    public function obtenirPartieParDate($date){
        
        $daoCal = new CalendrierDAO();
        return $daoCal->obtenirPartieParDate($date);
    }
}

