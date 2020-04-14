<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Partie
 *
 * @author girou
 */
class Partie {
    private $id_partie;
    private $jour_partie;
    private $heure_partie;
    private $participant_local;
    private $participant_adverse;
    private $patinoire;
    private $resultat;
    private $butsLocaux;
    private $butsAdverses;
             
    function __construct($jour_partie, $heure_partie, $participant_local, $participant_adverse, $patinoire) {
        $this->jour_partie = $jour_partie;
        $this->heure_partie = $heure_partie;
        $this->participant_local = $participant_local;
        $this->participant_adverse = $participant_adverse;
        $this->patinoire = $patinoire;
    }

    function getId_partie() {
        return $this->id_partie;
    }
    
    function getJour_partie() {
        return $this->jour_partie;
    }

    function getPatinoire() {
        return $this->patinoire;
    }

    function getResultat() {
        return $this->resultat;
    }

    function setJour_partie($jour_partie) {
        $this->jour_partie = $jour_partie;
    }

    function setPatinoire($patinoire) {
        $this->patinoire = $patinoire;
    }

    function setResultat($resultat) {
        $this->resultat = $resultat;
    }

    
    function getHeure_partie() {
        return $this->heure_partie;
    }

    function getParticipant_local() {
        return $this->participant_local;
    }

    function getParticipant_adverse() {
        return $this->participant_adverse;
    }

    function setId_partie($id_partie) {
        $this->id_partie = $id_partie;
    }

    function setHeure_partie($heure_partie) {
        $this->heure_partie = $heure_partie;
    }

    function setParticipant_local($equipe_locale) {
        $this->participant_local = $equipe_locale;
    }

    function setParticipant_adverse($equipe_adverse) {
        $this->participant_adverse = $equipe_adverse;
    }
    
    function ajouterResultat($buts_locaux, $buts_adverses) {
        $this->resultat = new Resultat(equipe_locale, equipe_adverse, $buts_locaux, $buts_adverses);
    }
    
    function getButsLocaux() {
        return $this->butsLocaux;
    }

    function getButsAdverses() {
        return $this->butsAdverses;
    }

    function setButsLocaux($butsLocaux) {
        $this->butsLocaux = $butsLocaux;
    }

    function setButsAdverses($butsAdverses) {
        $this->butsAdverses = $butsAdverses;
    }

}
