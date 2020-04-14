<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Participant
 *
 * @author girou
 */
class Participant {
  
    private $equipe_participante;
    private $tournoi;
    private $Fiche;
    
    function __construct($equipe_participante, $tournoi) {
        $this->equipe_participante = $equipe_participante;
        $this->tournoi = $tournoi;
    }
    
    function getEquipe_participante() {
        return $this->equipe_participante;
    }

    function getTournoi() {
        return $this->tournoi;
    }

    
    function getFiche() {
        return $this->Fiche;
    }

    function setFiche($Fiche) {
        $this->Fiche = $Fiche;
    }


}
