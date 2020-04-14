<?php

class AdminController {

    public function Index() {
        return $this->Login();
    }

    public function Login() {
        if(Session::userIsConnected()){
            return 'ligueAdmin';
        }
        if (Util::requestMethod() == 'GET') {
            return 'ligueIdentifier';
        
            
        } else {

            $formOK = TRUE;
            $courriel = Util::param('courriel');
            $password = Util::param('motDePasse');

            if ($courriel == '') {
                Util::setMessage('courriel', 'Courriel obligatoire');
                $formOK = FALSE;
            }
            if ($password == '') {
                Util::setMessage('motDePasse', 'Mot de passe obligatoire');
                $formOK = FALSE;
            }
            if (!$formOK) {
                return 'ligueIdentifier';
            }
            if ($courriel != "theboss@gmail.com") {
                Util::setMessage('courriel', 'Utilisateur inexistant***');
                return 'ligueIdentifier';
            }
            if ($password != "theboss") {
                Util::setMessage('motDePasse', 'Mot de passe incorrect***');
                return 'ligueIdentifier';
            }
            Session::connectUser();
            Session::setAttribute('username', 'theboss@gmail.com');
            return 'ligueAdmin';
        }
    }

    public function Deconnection(){
        Session::disconnectUser();
        return 'ligueAccueil';
    }

}
