<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author moumene
 */
class Session {
    public static function userIsConnected() {
        if (ISSET($_SESSION) && ISSET($_SESSION['connected'])) {
            return true;
        }
        return false;
    }
    public static function connectUser() {
        self::setAttribute('connected', TRUE);
    }
    public static function disconnectUser() {
        self::removeAttribute('connected');
    }
    public static function setAttribute($attr,$val) {
        /* Déjà fait dans le routeur :
         if (!ISSET($_SESSION)) {
            session_start();
        }*/
        $_SESSION[$attr] = $val;
    }
    public static function getAttribute($attr) {
        if (ISSET($_SESSION[$attr])) {
            return $_SESSION[$attr];
        }
        return '';
    }
    public static function removeAttribute($attr) {
        if (ISSET($_SESSION)) {
            UNSET($_SESSION[$attr]);
        }
    }
}
