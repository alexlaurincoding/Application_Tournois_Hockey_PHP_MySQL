<?php

class ParticipantDAO {


    public function creerParticipant($Equipe_participante, $Tournoi) {
        try {
            $db = Database::get_connexion();
            
            //D'abord aller chercher les id du tournoi et de l'equipe
            $id_equipe = $Equipe_participante->getId_equipe();
            $id_tournoi = $Tournoi->getId_tournoi();
            
            //Ensuite, on est pret a creer le participant            
            $pstm = $db->prepare("INSERT INTO participant (ID_EQUIPE, ID_TOURNOI)"
                    . " VALUES (:e, :t)");
            $pstm->bindParam(':e', $id_equipe);
            $pstm->bindParam(':t', $id_tournoi);
            
            return $pstm->execute();
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
    //Supprimer Participant
    public function supprimerParticipant($Equipe, $Tournoi) {
       try
            {
                //D'abord aller chercher les id du tournoi et de l'equipe
                $id_equipe = $Equipe->getId_equipe();
                $id_tournoi = $Tournoi->getId_tournoi();

                $db = Database::get_connexion();
                $pstm = $db->prepare("DELETE FROM participant WHERE ID_EQUIPE = :e AND ID_TOURNOI = :t");
                $idEqInt = (int)$id_equipe;
                $idTourInt = (int)$id_tournoi;
                $pstm->bindParam(':e', $idEqInt);
                $pstm->bindParam(':t', $idTourInt);
                return $pstm->execute();
            }
            catch(PDOException $e)
            {
                    throw $e;
            }
    }
    
    //Creer fiche
    public function creerFiche($Participant){
         try {
            $db = Database::get_connexion();
                        
            //Aller chercher les id de l'equipe et du tournoi du participant
            $Equipe = $Participant->getEquipe_participante();
            $idEquipe = $Equipe->getId_equipe();
            $Tournoi = $Participant->getTournoi();
            $idTournoi = $Tournoi->getId_tournoi();
            
            //Creer la Fiche
            $pstm = $db->prepare("INSERT INTO fiche (NB_VICTOIRES, NB_DEFAITES, NB_NULLES, ID_EQUIPE, ID_TOURNOI)"
                    . " VALUES (:v, :d, :n, :e, :t)");
            return $pstm->execute(array(':v' => 0, ':d' => 0, ':n' => 0, ':e'=> $idEquipe, ':t'=> $idTournoi));
            
        } catch (PDOException $e) {
            throw $e;
            return null;
        }
    }
    
    //Obtenir fiche a partir du Participant
    public function obtenirFiche($Participant){
        try {
            
            //Aller chercher l'id de l'Equipe et du Tournoi
            $Equipe = $Participant->getEquipe_participante();
            $Tournoi = $Participant->getTournoi();
            $idEquipe = $Equipe->getId_equipe();
            $idTournoi = $Tournoi->getId_tournoi();
            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM fiche WHERE ID_EQUIPE = :e AND ID_TOURNOI = :t');
            $pstmt->execute(array(':e' => $idEquipe, ':t' => $idTournoi));
            $res = $pstmt->fetch(PDO::FETCH_OBJ);
            
            if ($res){
                $v = $res->NB_VICTOIRES;
                $d = $res->NB_DEFAITES;
                $n = $res->NB_NULLES;
                
                $laFiche = new Fiche($Participant, $v, $d, $n);
                $laFiche->setId_fiche($res->ID_FICHE);                
                $pstmt->closeCursor();
                return $laFiche;
            }
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	    
            
    }	
    
    
    public function modifierFiche($Participant, $v, $d, $n){
                
         try {
            
            //Aller chercher l'id de l'Equipe et du Tournoi
            $Equipe = $Participant->getEquipe_participante();
            $Tournoi = $Participant->getTournoi();
            $idEquipe = $Equipe->getId_equipe();
            $idTournoi = $Tournoi->getId_tournoi();
            $db = Database::get_connexion();
            $pstmt = $db->prepare("UPDATE fiche SET NB_VICTOIRES = :v, " ."NB_DEFAITES = :d, " . "NB_NULLES = :n WHERE ID_EQUIPE = :e " . "AND ID_TOURNOI = :t"); 

            return $pstmt->execute(array(':v' => $v, ':d' => $d, ':n' => $n, ':e' => $idEquipe, ':t' => $idTournoi));
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	    
        
    }
   
    
    //Obtenir le Participant a partir de l'Equipe et le Tournoi (et retourner null si n'existe pas)
    public function obtenir($Equipe, $Tournoi){
        try {
            
            //Aller chercher l'id de l'Equipe et du Tournoi
            $idEquipe = $Equipe->getId_equipe();
            $idTournoi = $Tournoi->getId_tournoi();
            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM participant WHERE ID_EQUIPE = :e AND ID_TOURNOI = :t');
            $idEqInt = (int)$idEquipe;
            $idTourInt = (int)$idTournoi;
            $pstmt->execute(array(':e' => $idEqInt, ':t' => $idTourInt));
            $res = $pstmt->fetch(PDO::FETCH_OBJ);
            
            if ($res){
                $idEquipe2 = $res->ID_EQUIPE;
                $idTournoi2 = $res->ID_TOURNOI;
                
                $Equipe2 = EquipeDAO::obtenir($idEquipe2);
                $Tournoi2 = TournoiDAO::obtenir($idTournoi2);
                
                $leParticipant = new Participant($Equipe2, $Tournoi2);
                
                $pstmt->closeCursor();
                return $leParticipant;
            }
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	    
            
    }	
    
    public function obtenirParTournoi($Tournoi){
        try {
            
            $liste = array();
            
            //Aller chercher l'id du Tournoi
            $idTournoi = $Tournoi->getId_tournoi();
            $cnx = Database::get_connexion();
            
            $requete = "SELECT * FROM participant WHERE ID_TOURNOI = " .$idTournoi;
                        
            $resultats = $cnx->query($requete);

            foreach ($resultats as $row) {
                $idEquipe2 = $row['ID_EQUIPE'];
                $idTournoi2 = $row['ID_TOURNOI'];

                $Equipe2 = EquipeDAO::obtenir($idEquipe2);
                $Tournoi2 = TournoiDAO::obtenir($idTournoi2);

                $leParticipant = new Participant($Equipe2, $Tournoi2);
                array_push($liste, $leParticipant);

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
