<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fiche
 *
 * @author girou
 */
class Fiche {
    private $id_fiche;
    private $nb_victoires;
    private $nb_defaites;
    private $nb_nulles;
    private $points;
    private $Participant;
    
    function __construct($Participant, $victoires=0, $defaites=0, $nulles=0) {
        $this->nb_victoires = $victoires ;
        $this->nb_defaites = $defaites;
        $this->nb_nulles = $nulles;
        $this->Participant = $Participant;
        $this->points = $victoires*2 + $nulles;
    }
    
    function getId_fiche() {
        return $this->id_fiche;
    }

    function getNb_victoires() {
        return $this->nb_victoires;
    }

    function getNb_defaites() {
        return $this->nb_defaites;
    }

    function getNb_nulles() {
        return $this->nb_nulles;
    }
    
    function getParticipant() {
        return $this->Participant;
    }

    function setParticipant($Participant) {
        $this->Participant = $Participant;
    }

    
    function setId_fiche($id_fiche) {
        $this->id_fiche = $id_fiche;
    }
    
    function getPoints() {
        return $this->points;
    }

    function setPoints($points) {
        $this->points = $points;
    }

    
    function ajouter_victoires($nbr) {
        $this->nb_victoires += $nbr;
    }

    function ajouter_defaites($nbr) {
        $this->nb_defaites += $nbr;
    }

    function ajouter_nulles($nbr) {
        $this->nb_nulles += $nbr;
    }
    
    
    function soustraire_victoires($nbr) {
        $this->nb_victoires -= $nbr;
    }

    function soustraire_defaites($nbr) {
        $this->nb_defaites -= $nbr;
    }

    function soustraire_nulles($nbr) {
        $this->nb_nulles -= $nbr;
    }
    
    
    function obtenir_fiche(){
        $fiche = array($this->nb_victoires, $this->nb_defaites, $$this->nb_nulles);
        return $fiche;
    }
}