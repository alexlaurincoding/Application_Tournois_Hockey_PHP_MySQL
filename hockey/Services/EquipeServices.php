<?php

class EquipeServices{
    
    public static function getEquipe ($id){
        $dao = new EquipeDAO();
        return $dao->obtenir($id);
    }
    
    public static function getListeEquipe(){
        $dao = new EquipeDAO();
        return $dao->obtenirEquipes();
}

    public static function ajouterEquipe($nom_equipe){
        $dao = new EquipeDAO();
        return $dao->creerEquipe($nom_equipe);
    }
    
    public static function supprimerEquipe($id){
        $dao = new EquipeDAO();
        return $dao->supprimerEquipe($id);
    }
    
    public static function modifierEquipe($id, $nom){
        $dao = new EquipeDAO();
        return $dao->modifierEquipe($id, $nom);
    }
    
}

