<?php
class Util {
    public static function PATH() {
       
        return (ISSET($_SERVER['REDIRECT_BASE'])) ? $_SERVER['REDIRECT_BASE'] : '.';
    }
    public static function URL() {
        
        return (ISSET($_SERVER['REDIRECT_URL'])) ? $_SERVER['REDIRECT_URL'] : '.';
    }
    public static function redirectToAction($controlleur='Home',$action='Index',$queryString=NULL){
        $url = Util::PATH()."/$controlleur/$action";
        if ($queryString!=NULL) {
            $url .= "?$queryString";
        }
        header('Location: '.$url);
        die();
    }
    public static function requestMethod() {
        if (ISSET($_SERVER['REQUEST_METHOD'])) {
            return $_SERVER['REQUEST_METHOD'];
        }
        return '';
    }
    public static function param($parametre) {
 
        if (ISSET($_REQUEST[$parametre])) {
            return $_REQUEST[$parametre];
        }
        return '';
    }    
    public static function message($parametre) {

        if (ISSET($_REQUEST['messages'][$parametre])) {
            
            return $_REQUEST['messages'][$parametre];
        }
        return '';
    }
    public static function setMessage($parametre, $valeur) {
        if (!ISSET($_REQUEST['messages'])) {
            $_REQUEST['messages'] = array();
        }
        $_REQUEST['messages'][$parametre] = $valeur;
    }
    public static function setAttribute($attribut,$valeur) {
        $_REQUEST[$attribut] = $valeur;
    }
    public static function getAttribute($attribut) {
        if(ISSET($_REQUEST[$attribut])) {
            return $_REQUEST[$attribut];
        }
        return NULL;
    }
}
