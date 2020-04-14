<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Patinoire
 *
 * @author girou
 */
class Patinoire {

    private $id_patinoire;
    private $nom_arena;
    private $ville_arena;
    
    function __construct($nom_arena, $ville_arena) {
        $this->nom_arena = $nom_arena;
        $this->ville_arena = $ville_arena;
    }

    function getId_patinoire() {
        return $this->id_patinoire;
    }

    function getNom_arena() {
        return $this->nom_arena;
    }

    function getVille_arena() {
        return $this->ville_arena;
    }

    function setNom_arena($nom_arena) {
        $this->nom_arena = $nom_arena;
    }
    
    function setId_patinoire($id_patinoire) {
        $this->id_patinoire = $id_patinoire;
    }

    function setVille_arena($ville_arena) {
        $this->ville_arena = $ville_arena;
    }

}
