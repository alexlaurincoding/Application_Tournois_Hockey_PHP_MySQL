<?php


class Database {
    
    private static $connexion = null;
    
    private function __construct() {}
    
    public static function get_connexion(){
        if (self::$connexion == null){
            self::$connexion = new PDO('mysql:host=localhost;dbname=hockeyfusion', "root", "");
        }
        return self::$connexion;
    }
    
    public static function close(){
        self::$connexion = null;
    }
}
