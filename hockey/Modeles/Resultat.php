<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Resultat
 *
 * @author girou
 */
class Resultat {
    private $id_resultat;
    private $buts_locaux;
    private $buts_adverses;
    
    function __construct($buts_locaux, $buts_adverses) {
        $this->buts_locaux = $buts_locaux;
        $this->buts_adverses = $buts_adverses;
    }
    
    function getId_resultat() {
        return $this->id_resultat;
    }

    function getButs_locaux() {
        return $this->buts_locaux;
    }

    function getButs_adverses() {
        return $this->buts_adverses;
    }

    function setId_resultat($id_resultat) {
        $this->id_resultat = $id_resultat;
    }

    function setButs_locaux($buts_locaux) {
        $this->buts_locaux = $buts_locaux;
    }

    function setButs_adverses($buts_adverses) {
        $this->buts_adverses = $buts_adverses;
    }
    
    function obtenirResultat(){
       $res = array($this->buts_locaux, $this->buts_adverses);
       return $res;
    }

}

