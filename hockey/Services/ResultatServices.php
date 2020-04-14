<?php

class ResultatServices{
    
    public static function creerResultat($Partie, $butsA, $butsB){
        $dao = new ResultatDAO();
        return $dao->creerResultat($Partie, $butsA, $butsB);
    }
    
    public static function supprimerResultat($Resultat){
        $dao = new ResultatDAO();
        return $dao->supprimerResultat($Resultat);
    }
    
    public static function obtenirResultat($Partie){
        $dao = new ResultatDAO();
        return $dao->obtenirResultat($Partie);
    }
    
    public static function modifierResultat($Partie, $nouveauxButsLocaux, $nouveauxButsAdverses){
        $dao = new ResultatDAO();
        return $dao->modifierResultat($Partie, $nouveauxButsLocaux, $nouveauxButsAdverses);
    }
    
    public static function obtenirPartie($Resultat){
        $dao = new ResultatDAO();
        return $dao->obtenirPartie($Resultat);
    }
    
    public static function obtenirResultatParId($idResultat){
        $dao = new ResultatDAO();
        return $dao->obtenirResultatParId($idResultat);
    }
   
}

