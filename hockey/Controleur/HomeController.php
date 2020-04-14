<?php
class HomeController
{
    public function Index()
    {
//       
//        if (Session::userIsConnected()) {
//            Util::redirectToAction('Home', 'Admin');
//        }
//        Util::setMessage('global', "Vous devez vous connecter pour accéder aux services de l'application");
	return 'ligueAccueil';
    }
    public function Calendrier()
    {
  
	return 'calendrierTest';
    }
    public function Classement()
    {
	return 'classement';
    }
    public function Resultats()
    {
        return 'resultats';
    }
    
    public function MatchDuJour(){
        return 'matchDuJour';
    }

    
 
}
