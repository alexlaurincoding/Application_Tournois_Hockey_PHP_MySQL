<?php

class ResultatController {

    public function Ajouter() {
        $butsLocaux = $_REQUEST['butsLocaux'];
        $butsAdverses = $_REQUEST['butsAdverses'];
        $idPartie = $_REQUEST['idPartie'];
        $Partie = CalendrierServices::obtenirPartie($idPartie);

        ResultatServices::creerResultat($Partie, $butsLocaux, $butsAdverses);

        $ParticipA = $Partie->getParticipant_local();
        $ParticipB = $Partie->getParticipant_adverse();

        $FicheA = ParticipantServices::obtenirFiche($ParticipA);
        $FicheB = ParticipantServices::obtenirFiche($ParticipB);

        //Si Locaux ont plus de buts
        if ($butsLocaux > $butsAdverses) {
            $FicheA->ajouter_victoires(1);

            $FicheB->ajouter_defaites(1);
        }

        //Si Locaux ont moins de buts
        else if ($butsLocaux < $butsAdverses) {
            $FicheB->ajouter_victoires(1);
            $FicheA->ajouter_defaites(1);
        }
        //Sinon, si nulle
        else {
            $FicheB->ajouter_nulles(1);
            $FicheA->ajouter_nulles(1);
        }

        ParticipantServices::modifierFiche($ParticipA, $FicheA->getNb_victoires(), $FicheA->getNb_defaites(), $FicheA->getNb_nulles());
        ParticipantServices::modifierFiche($ParticipB, $FicheB->getNb_victoires(), $FicheB->getNb_defaites(), $FicheB->getNb_nulles());

        echo '{"reponse":"OK"}';
        die();
    }
    
     public function Modifier() {
        $anciensButsLocaux = $_REQUEST['anciensLocaux'];
        $anciensButsAdverses = $_REQUEST['anciensAdverses'];
        $nouveauxButsLocaux = $_REQUEST['nouveauxLocaux'];
        $nouveauxButsAdverses = $_REQUEST['nouveauxAdverses'];
        $idPartie = $_REQUEST['idPartie'];
        $Partie = CalendrierServices::obtenirPartie($idPartie);
        
        //Determiner les anciens et nouveau gagnants et perdants (ou nulle), afin de modifier les fiches et classements
        $ancienGagnant = null;
        $nouveauGagnant = null;
        $changementLocal = null;
        $changementAdverse = null;
        
        
        //Ceci va changer a la fois dans la tables Partie et dans la table Resultat
        $rep = ResultatServices::modifierResultat($Partie, $nouveauxButsLocaux, $nouveauxButsAdverses);
        
                
        //Determiner les anciens et nouveaux gangants/perdants (ou nulle) pour modifier les fiches
        
        if ($anciensButsLocaux > $anciensButsAdverses) $ancienGagnant = "L";
        else if ($anciensButsLocaux < $anciensButsAdverses) $ancienGagnant = "A";
        else $ancienGagnant = "N";
        
        if ($nouveauxButsLocaux > $nouveauxButsAdverses) $nouveauGagnant = "L";
        else if ($nouveauxButsLocaux < $nouveauxButsAdverses) $nouveauGagnant = "A";
        else $nouveauGagnant = "N";
        
        
        //Determiner les changements entre l'ancien et le nouveau
        //D'abord, si les gagnants n'ont pas change, garder les fiches intact
        if ($ancienGagnant == $nouveauGagnant){
            $changementLocal = 0;
            $changementAdverse = 0;
        }
        //Sinon, si l'ancien gagnant est l'equipe locale
        else if ($ancienGagnant == "L"){
            
            //Si le nouveau gagnant est l'equipe adverse, changer en consequence
            if ($nouveauGagnant == "A"){
                $changementLocal = -2;
                $changementAdverse = 2;
                
            }
            //Sinon, la nouvelle partie est nulle, et changer en consequence
            else{
                $changementLocal = -1;
                $changementAdverse = 1;
            }
                        
        }
        //Sinon, si l'ancien gagnant est l'equipe adverse
        else if ($ancienGagnant == "A"){
            
            //Si le nouveau gagnant est l'equipe locale, changer en consequence
            if ($nouveauGagnant == "L"){
                $changementLocal = 2;
                $changementAdverse = -2;
                
            }
            //Sinon, la nouvelle partie est nulle, et changer en consequence
            else{
                $changementLocal = 1;
                $changementAdverse = -1;
            }
                        
        }
        
         //Sinon, l'ancienne partie est nulle
        else if ($ancienGagnant == "N"){
            
            //Si le nouveau gagnant est l'equipe locale, changer en consequence
            if ($nouveauGagnant == "L"){
                $changementLocal = 1;
                $changementAdverse = -1;
                
            }
            //Sinon, le nouveau gagnant est l'equipe adverse, et changer en consequence
            else{
                $changementLocal = -1;
                $changementAdverse = 1;
            }
                        
        }
        
        
        //Modifier les fiches des equipes
        $ParticipantLocal = $Partie->getParticipant_local();
        $ParticipantAdverse = $Partie->getParticipant_adverse();

        $FicheLocale = ParticipantServices::obtenirFiche($ParticipantLocal);
        $FicheAdverse = ParticipantServices::obtenirFiche($ParticipantAdverse);

        //Local
        if ($changementLocal == -2) {
            
            $FicheLocale->soustraire_victoires(1);
            $FicheLocale->ajouter_defaites(1);
        }
        
        else if ($changementLocal == -1) {
            
            $FicheLocale->soustraire_nulles(1);
            $FicheLocale->ajouter_defaites(1);
        }
        
        else if ($changementLocal == 1) {
            
            $FicheLocale->ajouter_victoires(1);
            $FicheLocale->soustraire_nulles(1);
        }
        
        else if ($changementLocal == 2) {
            
            $FicheLocale->ajouter_victoires(1);
            $FicheLocale->soustraire_defaites(1);
        }
        
        //Adverse
        if ($changementAdverse == -2) {
            
            $FicheAdverse->soustraire_victoires(1);
            $FicheAdverse->ajouter_defaites(1);
        }
        
        else if ($changementAdverse == -1) {
            
            $FicheAdverse->soustraire_nulles(1);
            $FicheAdverse->ajouter_defaites(1);
        }
        
        else if ($changementAdverse == 1) {
            
            $FicheAdverse->ajouter_victoires(1);
            $FicheAdverse->soustraire_nulles(1);
        }
        
        else if ($changementAdverse == 2) {
            
            $FicheAdverse->ajouter_victoires(1);
            $FicheAdverse->soustraire_defaites(1);
        }
        
        
        //Appliquer le changement dans la base de donnees
        ParticipantServices::modifierFiche($ParticipantLocal, $FicheLocale->getNb_victoires(), $FicheLocale->getNb_defaites(), $FicheLocale->getNb_nulles());
        ParticipantServices::modifierFiche($ParticipantAdverse, $FicheAdverse->getNb_victoires(), $FicheAdverse->getNb_defaites(), $FicheAdverse->getNb_nulles());

        echo '{"reponse":"OK"}';
        die();
    }

    public function Supprimer() {

        $idPartie = $_REQUEST['idPartie'];
        $Partie = CalendrierServices::obtenirPartie($idPartie);
        $Resultat = ResultatServices::obtenirResultat($Partie);
        $butsLocaux = $Resultat->getButs_locaux();
        $butsAdverses = $Resultat->getButs_adverses();

        $ParticipA = $Partie->getParticipant_local();
        $ParticipB = $Partie->getParticipant_adverse();

        $FicheA = ParticipantServices::obtenirFiche($ParticipA);
        $FicheB = ParticipantServices::obtenirFiche($ParticipB);

        //Si Locaux ont plus de buts (i.e. ont remporte la partie), alors leur enlever une victoire et enlever une defaite aux Adverses
        if ($butsLocaux > $butsAdverses) {
            $FicheA->soustraire_victoires(1);

            $FicheB->soustraire_defaites(1);
        }

        //Si Locaux ont moins de buts (i.e. ont perdu la partie), alors leur enlever une defaite et enlever une victoire aux Adverses
        else if ($butsLocaux < $butsAdverses) {
            $FicheB->soustraire_victoires(1);
            $FicheA->soustraire_defaites(1);
        }
        //Sinon, si nulle, enlever une nulle aux deux equipes
        else {
            $FicheB->soustraire_nulles(1);
            $FicheA->soustraire_nulles(1);
        }
        
        //Supprimer resultat
        ResultatServices::supprimerResultat($Resultat);

        //Mettre a jour les fiches
        ParticipantServices::modifierFiche($ParticipA, $FicheA->getNb_victoires(), $FicheA->getNb_defaites(), $FicheA->getNb_nulles());
        ParticipantServices::modifierFiche($ParticipB, $FicheB->getNb_victoires(), $FicheB->getNb_defaites(), $FicheB->getNb_nulles());

        echo '{"reponse":"OK"}';
        die();
    }

    
    public function Chercher(){
        
        $idPartie = $_REQUEST['idPartie'];
        $Partie = CalendrierServices::obtenirPartie($idPartie);        
        $Resultat = ResultatServices::obtenirResultat($Partie);
        
        if ($Resultat == null){
            echo '{"reponse":"aucun"}';
            die();
        }
        
        $tableauObjetsJSON = "[";
        $idPartie = $Resultat->getId_resultat();
        $butsLocaux = $Resultat->getButs_locaux();
        $butsAverses = $Resultat->getButs_adverses();
 
        echo '{"id_partie": '.$idPartie .', "buts_locaux": '.$butsLocaux .', "buts_adverses": '.$butsAverses .'}';
        die();
        
    }

}
