<?php

class TournoiServices{
    
    public static function ajouterTournoi($nom_tournoi, $nbr_min_equipes, $nbr_max_equipes, $date_debut_tournoi, $date_fin_tournoi, $date_limite_inscription){
        $dao = new TournoiDao();
        return $dao->creerTournoi($nom_tournoi, $nbr_min_equipes, $nbr_max_equipes, $date_debut_tournoi, $date_fin_tournoi, $date_limite_inscription);
    }
    
   public static function getListeTournoi(){
       $dao = new TournoiDao();
       return $dao->obtenirTournois();
   }
   
   public static function getTournoi($id){
       $dao = new TournoiDao();
       return $dao->obtenir($id);
   }
   
   public static function supprimerTournoi($id){
       $dao = new TournoiDao();
       return $dao->supprimerTournoi($id);
   }
   
   public static function modifierTournoi($idTournoi, $nomTournoi, $min, $max, $debut, $fin, $limite){
       $dao = new TournoiDao();
       return $dao->modifierTournoi($idTournoi, $nomTournoi, $min, $max, $debut, $fin, $limite);
   }
}

