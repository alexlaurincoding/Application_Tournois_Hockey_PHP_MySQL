<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calendrier
 *
 * @author girou
 */
class Calendrier {
    
    private $id_calendrier;
    private $date_debut_calendrier;
    private $date_fin_calendrier;
    private $nbr_equipes;
    private $nbr_parties;
    private $parties;
    private $Tournoi;
    
    
    function __construct($date_debut_calendrier, $date_fin_calendrier, $nbr_equipes, $Tournoi) {
        $this->date_debut_calendrier = $date_debut_calendrier;
        $this->date_fin_calendrier = $date_fin_calendrier;
        $this->parties = array();
        $this->nbr_equipes = $nbr_equipes;
        $this->nbr_parties = $nbr_equipes;
        $this->Tournoi = $Tournoi;
    }
    
    function getId_calendrier() {
        return $this->id_calendrier;
    }

    function getDate_debut_calendrier() {
        return $this->date_debut_calendrier;
    }

    function getDate_fin_calendrier() {
        return $this->date_fin_calendrier;
    }

    function setDate_debut_calendrier($date_debut_calendrier) {
        $this->date_debut_calendrier = $date_debut_calendrier;
    }

    function setDate_fin_calendrier($date_fin_calendrier) {
        $this->date_fin_calendrier = $date_fin_calendrier;
    }
    
    function getParties() {
        return $this->parties;
    }
    
    function getNbr_equipes() {
        return $this->nbr_equipes;
    }

    function getNbr_parties() {
        return $this->nbr_parties;
    }

    function getTournoi() {
        return $this->Tournoi;
    }

    function setNbr_equipes($nbr_equipes) {
        $this->nbr_equipes = $nbr_equipes;
    }

    function setNbr_parties($nbr_parties) {
        $this->nbr_parties = $nbr_parties;
    }

    function setTournoi($Tournoi) {
        $this->Tournoi = $Tournoi;
    }
    
    function setId_calendrier($id_calendrier) {
        $this->id_calendrier = $id_calendrier;
    }



}
