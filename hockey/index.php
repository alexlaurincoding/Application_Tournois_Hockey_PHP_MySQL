<?php
spl_autoload_register(function($classeACharger) {
        //Liste des dossiers à explorer dans la recherche de la classe:
        $dossiers = array(
            'Controleur/',
            'Modeles/',
            'services/',
            'DAOs/',
            'configs/',
            'Utils/',           
            'Vues/'
            
            
        );
        foreach( $dossiers as $dossier ) {
            if (file_exists($dossier . $classeACharger . '.php')) {
                require_once($dossier . $classeACharger . '.php');
                return TRUE;
            }
        }
		return FALSE;
    });

    

$DEFAULT_CONTROLLER = 'Home';
$DEFAULT_ACTION = 'Index';

$request = str_replace(Util::PATH(), '', Util::URL());

$t = explode('/',$request);

$controller = (ISSET($t[1]))?$t[1]:$DEFAULT_CONTROLLER;
$action = (ISSET($t[2])&&$t[2]!='')?$t[2]:$DEFAULT_ACTION;

if (!ISSET($_SESSION)) session_start();

$controllerClass = $controller.'Controller';
$controller = new $controllerClass();//on instancie le controleur
$vue = $controller->{$action}();	//on execute la methode correspondant a l'action
include './Vues/'.$vue.'.php';