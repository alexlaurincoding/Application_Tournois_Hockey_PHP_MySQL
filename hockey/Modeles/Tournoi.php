<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tournoi
 *
 * @author girou
 */
class Tournoi {

    private $id_tournoi;
    private $nom_tournoi;
    private $nbr_max_equipes;
    private $nbr_min_equipes;
    private $date_debut_tournoi;
    private $date_fin_tournoi;
    private $date_limite_inscription;
    private $calendrier;
    private $participants;
    
    function __construct($nom_tournoi, $nbr_min_equipes, $nbr_max_equipes, $date_debut_tournoi, $date_fin_tournoi, $date_limite_inscription) {
        $this->nom_tournoi = $nom_tournoi;
        $this->nbr_max_equipes = $nbr_max_equipes;
        $this->nbr_min_equipes = $nbr_min_equipes;
        $this->date_debut_tournoi = $date_debut_tournoi;
        $this->date_fin_tournoi = $date_fin_tournoi;
        $this->date_limite_inscription = $date_limite_inscription;
    }
    
    function getId_tournoi() {
        return $this->id_tournoi;
    }

    function getNom_tournoi() {
        return $this->nom_tournoi;
    }

    function getNbr_max_equipes() {
        return $this->nbr_max_equipes;
    }

    function getNbr_min_equipes() {
        return $this->nbr_min_equipes;
    }

    function getDate_debut_tournoi() {
        return $this->date_debut_tournoi;
    }

    function getDate_fin_tournoi() {
        return $this->date_fin_tournoi;
    }

    function getDate_limite_inscription() {
        return $this->date_limite_inscription;
    }

    function getCalendrier_tournoi() {
        return $this->calendrier_tournoi;
    }

    function getParticipants() {
        return $this->participants;
    }
    
    function setId_tournoi($id_tournoi) {
        $this->id_tournoi = $id_tournoi;
    }

    
    function setNom_tournoi($nom_tournoi) {
        $this->nom_tournoi = $nom_tournoi;
    }

    function setNbr_max_equipes($nbr_max_equipes) {
        $this->nbr_max_equipes = $nbr_max_equipes;
    }

    function setNbr_min_equipes($nbr_min_equipes) {
        $this->nbr_min_equipes = $nbr_min_equipes;
    }

    function setDate_debut_tournoi($date_debut_tournoi) {
        $this->date_debut_tournoi = $date_debut_tournoi;
    }

    function setDate_fin_tournoi($date_fin_tournoi) {
        $this->date_fin_tournoi = $date_fin_tournoi;
    }

    function setDate_limite_inscription($date_limite_inscription) {
        $this->date_limite_inscription = $date_limite_inscription;
    }
    
//    function find($id){
//        
//    }
}
