<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Administrateur
 *
 * @author girou
 */
class Administrateur {
    private $id_admin;
    private $mot_passe;
    private $courriel;
    
    function __construct($courriel, $mot_passe) {
        $this->mot_passe = $mot_passe;
        $this->courriel = $courriel;
    }
    
    function getId_admin() {
        return $this->id_admin;
    }

    function getMot_passe() {
        return $this->mot_passe;
    }

    function getCourriel() {
        return $this->courriel;
    }
    
    function setId_admin($id_admin) {
        $this->id_admin = $id_admin;
    }

    
    function setMot_passe($mot_passe) {
        $this->mot_passe = $mot_passe;
    }

    function setCourriel($courriel) {
        $this->courriel = $courriel;
    }
}
