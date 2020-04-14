<?php

class CalendrierDAO {

    public function creerCalendrier($Tournoi, $dateDebut, $dateFin, $nbrEquipes) {
        try {
            $db = Database::get_connexion();
            

            //D'abord aller chercher l'id du tournoi
            $id_tournoi = $Tournoi->getId_tournoi();
            $nbr_parties = $nbrEquipes * ($nbrEquipes - 1);
            $intEquipes = (int) $nbrEquipes;
            $intParties = (int) $nbr_parties;
            $intId = (int) $id_tournoi;
            //Ensuite, on est pret a creer le tournoi            
            $pstm = $db->prepare("INSERT INTO calendrier (DATE_DEBUT_CALENDRIER, DATE_FIN_CALENDRIER, NBR_EQUIPES, NBR_PARTIES, ID_TOURNOI)"
                    . " VALUES (:d, :f, :e, :p, :t)");

            return $pstm->execute(array(':d' => $dateDebut, ':f' => $dateFin, ':e' => $intEquipes, ':p' => $intParties, ':t' => $intId));
        } catch (PDOException $e) {
            throw $e;
            return null;
        }
    }
    
    public function modifierCalendrier($idCalendrier, $dateDebut, $dateFin, $nbrEquipes) {
        try {
            $db = Database::get_connexion();
            
            $nbr_parties = $nbrEquipes * ($nbrEquipes - 1);

            
            $pstm = $db->prepare("UPDATE calendrier SET DATE_DEBUT_CALENDRIER=:debut, DATE_FIN_CALENDRIER=:fin, NBR_EQUIPES=:eq, NBR_PARTIES=:pa WHERE ID_CALENDRIER = :id");

            return $pstm->execute(array(':debut' => $dateDebut, ':fin' => $dateFin, ':eq' => $nbrEquipes, ':pa' => $nbr_parties, ':id' => $idCalendrier));

            
        } catch (PDOException $e) {
            throw $e;
            return null;
        }
    }

    public function creerPartie($jour, $heure, $Tournoi, $EquipeA, $EquipeB, $Patinoire) {
        try {

            $db = Database::get_connexion();

            //D'abord aller chercher les id dont j'ai besoin
            $id_tournoi = $Tournoi->getId_tournoi();
            $id_equipeA = $EquipeA->getId_equipe();
            $id_equipeB = $EquipeB->getId_equipe();
            $Calendrier = CalendrierDAO::obtenirCalendrierParTournoi($Tournoi);
            $id_calendrier = $Calendrier->getId_calendrier();
            $id_patinoire = $Patinoire->getId_patinoire();

            //Ensuite, on est pret a creer la partie          
            $pstm = $db->prepare("INSERT INTO partie (JOUR_PARTIE, DEBUT_PARTIE, ID_TOURNOI, ID_EQUIPE_LOCALE, ID_EQUIPE_ADVERSE, ID_CALENDRIER, ID_PATINOIRE)"
                    . " VALUES (:j, :d, :t, :el, :ea, :c, :p)");

            return $pstm->execute(array(':j' => $jour, ':d' => $heure, ':t' => $id_tournoi, ':el' => $id_equipeA, ':ea' => $id_equipeB, ':c' => $id_calendrier, ':p' => $id_patinoire));
        } catch (PDOException $e) {
            throw $e;
            return null;
        }
    }
    
     public function supprimerPartie($id) {
       try
            {
                $db = Database::get_connexion();
                $pstm = $db->prepare("DELETE FROM partie WHERE ID_PARTIE = :num");
                $pstm->bindParam(':num', $id);
                return $pstm->execute();
            }
            catch(PDOException $e)
            {
                    throw $e;
            }
    }
    
    public function modifierPartie($idPartie, $jour, $heure, $EquipeA, $EquipeB, $Patinoire){
        try {
        
                $db = Database::get_connexion();
                
                $id_equipeA = $EquipeA->getId_equipe();
                $id_equipeB = $EquipeB->getId_equipe();
                $id_patinoire = $Patinoire->getId_patinoire();
                $pstm = $db->prepare("UPDATE partie SET JOUR_PARTIE=:jour, DEBUT_PARTIE=:heure, ID_EQUIPE_LOCALE=:idA, ID_EQUIPE_ADVERSE=:idB, ID_PATINOIRE=:pat WHERE ID_PARTIE = :num");
                
                return $pstm->execute(array(':jour' => $jour, ':heure' => $heure, ':idA' => $id_equipeA, ':idB' => $id_equipeB, ':pat' => $id_patinoire, ':num' => $idPartie));

            }
            catch(PDOException $e)
            {
                    throw $e;
            } catch (Exception $ex) {
            
        }
        
    }
    

    public function obtenirParties($Tournoi) {
        try {
            $liste = array();
            $id_tournoi = $Tournoi->getId_tournoi();
            $cnx = Database::get_connexion();

            $pstmt = $cnx->prepare('SELECT * FROM partie WHERE ID_TOURNOI = :num' . ' ORDER BY JOUR_PARTIE, DEBUT_PARTIE');
            $pstmt->execute(array(':num' => $id_tournoi));
           
           while ($res = $pstmt->fetch()){
                $EquipeA = EquipeDAO::obtenir($res['ID_EQUIPE_LOCALE']);
                $EquipeB = EquipeDAO::obtenir($res['ID_EQUIPE_ADVERSE']);
                $ParticipantA = ParticipantDAO::obtenir($EquipeA, $Tournoi);
                $ParticipantB = ParticipantDAO::obtenir($EquipeB, $Tournoi);
                $Patinoire = CalendrierDAO::obtenirPatinoire($res['ID_PATINOIRE']);
                $partie = new Partie($res['JOUR_PARTIE'], $res['DEBUT_PARTIE'], $ParticipantA, $ParticipantB, $Patinoire);
                
                //Set resultat
                $partie->setId_partie($res['ID_PARTIE']);
                $partie->setButsLocaux($res['BUTS_LOCAUX']);
                $partie->setButsAdverses($res['BUTS_ADVERSES']);
                array_push($liste, $partie);
            }
            Database::close();

            return $liste;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }

    public function obtenirToutesPartiesDesc() {
        
        try {
            $liste = array();

            $requete = 'SELECT * FROM partie ORDER BY JOUR_PARTIE DESC, DEBUT_PARTIE';
            $cnx = Database::get_connexion();

            $res = $cnx->query($requete);
            foreach ($res as $row) {
                $EquipeA = EquipeDAO::obtenir($row['ID_EQUIPE_LOCALE']);
                $EquipeB = EquipeDAO::obtenir($row['ID_EQUIPE_ADVERSE']);
                $Tournoi = TournoiDAO::obtenir($row['ID_TOURNOI']);
                $ParticipantA = ParticipantDAO::obtenir($EquipeA, $Tournoi);
                $ParticipantB = ParticipantDAO::obtenir($EquipeB, $Tournoi);
                $Patinoire = CalendrierDAO::obtenirPatinoire($row['ID_PATINOIRE']);
                $partie = new Partie($row['JOUR_PARTIE'], $row['DEBUT_PARTIE'], $ParticipantA, $ParticipantB, $Patinoire);
                $partie->setId_partie($row['ID_PARTIE']);
                //Set resultat
                $partie->setButsLocaux($row['BUTS_LOCAUX']);
                $partie->setButsAdverses($row['BUTS_ADVERSES']);
                array_push($liste, $partie);
            }
            $res->closeCursor();
            Database::close();
            return $liste;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	
        
    }
    
    public function obtenirPartie($idPartie) {
        try {

            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM partie WHERE ID_PARTIE = :num');
            $pstmt->execute(array(':num' => $idPartie));

            $res = $pstmt->fetch(PDO::FETCH_OBJ);

            if ($res) {
                $EquipeA = EquipeDAO::obtenir($res->ID_EQUIPE_LOCALE);
                $EquipeB = EquipeDAO::obtenir($res->ID_EQUIPE_ADVERSE);
                $Tournoi = TournoiDAO::obtenir($res->ID_TOURNOI);
                $ParticipantA = ParticipantDAO::obtenir($EquipeA, $Tournoi);
                $ParticipantB = ParticipantDAO::obtenir($EquipeB, $Tournoi);
                $Patinoire = CalendrierDAO::obtenirPatinoire($res->ID_PATINOIRE);
                $partie = new Partie($res->JOUR_PARTIE, $res->DEBUT_PARTIE, $ParticipantA, $ParticipantB, $Patinoire);
                $partie->setId_partie($res->ID_PARTIE);
                //Set resultats
                $partie->setButsLocaux($res->BUTS_LOCAUX);
                $partie->setButsAdverses($res->BUTS_ADVERSES);

                $pstmt->closeCursor();
                return $partie;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }

    public function obtenirPatinoires() {
        try {
            $liste = array();

            $requete = 'SELECT * FROM patinoire ORDER BY NOM_ARENA';
            $cnx = Database::get_connexion();

            $res = $cnx->query($requete);
            foreach ($res as $row) {
                $pat = new Patinoire($row['NOM_ARENA'], $row['VILLE_ARENA']);
                $pat->setId_patinoire($row['ID_PATINOIRE']);
                array_push($liste, $pat);
            }
            $res->closeCursor();
            Database::close();
            return $liste;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }

    public function obtenirPatinoire($id) {
        try {

            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM patinoire WHERE ID_PATINOIRE = :num');
            $pstmt->execute(array(':num' => $id));

            $res = $pstmt->fetch(PDO::FETCH_OBJ);

            if ($res) {
                $pat = new Patinoire($res->NOM_ARENA, $res->VILLE_ARENA);
                $pat->setId_patinoire($res->ID_PATINOIRE);

                $pstmt->closeCursor();
                return $pat;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }

    public function obtenirCalendrierParTournoi($Tournoi) {
        try {

            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM calendrier WHERE ID_TOURNOI = :num');
            $idTournoi = $Tournoi->getId_tournoi();
            $pstmt->execute(array(':num' => $idTournoi));

            $res = $pstmt->fetch(PDO::FETCH_OBJ);

            if ($res) {
                $cal = new Calendrier($res->DATE_DEBUT_CALENDRIER, $res->DATE_FIN_CALENDRIER, $res->NBR_EQUIPES, $Tournoi);
                $cal->setId_calendrier($res->ID_CALENDRIER);

                $pstmt->closeCursor();
                return $cal;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }
    
    public function obtenirPartieParDate($date){ 
        
        try {
            $liste = array();
            
            $laDate = date('Y-m-d',strtotime($date));

            $cnx = Database::get_connexion();

            $resultats = $cnx->query("SELECT * FROM partie");

            foreach ($resultats as $row) {
               $partie = new Partie($row['JOUR_PARTIE'], $row['DEBUT_PARTIE'], $row['ID_EQUIPE_LOCALE'], $row['ID_EQUIPE_ADVERSE'],$row['ID_PATINOIRE']);
                array_push($liste, $partie);
            }
            $resultats->closeCursor();
            Database::close();
            return $liste;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }

}
