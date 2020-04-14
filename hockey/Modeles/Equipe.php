<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Equipe
 *
 * @author girou
 */
class Equipe {
    private $id_equipe;
    private $nom_equipe;
    private $participations;
            
    function __construct($nom_equipe) {
        $this->nom_equipe = $nom_equipe;
        $this->participations = array();
    }

    function getId_equipe() {
        return $this->id_equipe;
    }

    function getNom_equipe() {
        return $this->nom_equipe;
    }

    function setNom_equipe($nom_equipe) {
        $this->nom_equipe = $nom_equipe;
    }
    
    function getParticipations() {
        return $this->participations;
    }
    
    function setId_equipe($id_equipe) {
        $this->id_equipe = $id_equipe;
    }
}
