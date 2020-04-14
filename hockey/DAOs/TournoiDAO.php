<?php

class TournoiDAO {

    public function creerTournoi($nom_tournoi, $nbr_min_equipes, $nbr_max_equipes, $date_debut_tournoi, $date_fin_tournoi, $date_limite_inscription) {
        try {
            $db = Database::get_connexion();
            $pstm = $db->prepare("INSERT INTO tournoi (NOM_TOURNOI, NBR_MAX_EQUIPES, NBR_MIN_EQUIPES, DATE_DEBUT_TOURNOI, DATE_FIN_TOURNOI, DATE_LIMITE_INSCRIPTION)"
                    . " VALUES (:nom, :max, :min, :deb, :fin, :lim)");
            $pstm->bindParam(':nom', $nom_tournoi);
            $pstm->bindParam(':max', $nbr_max_equipes);
            $pstm->bindParam(':min', $nbr_min_equipes);
            $pstm->bindParam(':deb', $date_debut_tournoi);
            $pstm->bindParam(':fin', $date_fin_tournoi);
            $pstm->bindParam(':lim', $date_limite_inscription);
            return $pstm->execute();
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
    
    public function supprimerTournoi($id) {
       try
            {
                $db = Database::get_connexion();
                $pstm = $db->prepare("DELETE FROM tournoi WHERE ID_TOURNOI = :num");
                $pstm->bindParam(':num', $id);
                return $pstm->execute();
            }
            catch(PDOException $e)
            {
                    throw $e;
            }
    }
    
        
    public function modifierTournoi($idTournoi, $nomTournoi, $min, $max, $debut, $fin, $limite) {
        try {
            
            $db = Database::get_connexion();
            $pstm = $db->prepare("UPDATE tournoi SET NOM_TOURNOI=:nom, NBR_MIN_EQUIPES=:min, NBR_MAX_EQUIPES=:max, DATE_DEBUT_TOURNOI=:debut, DATE_FIN_TOURNOI=:fin, DATE_LIMITE_INSCRIPTION=:limite WHERE ID_TOURNOI = :num");
            return $pstm->execute(array(':nom' => $nomTournoi, ':min' => $min, ':max' => $max, ':debut' => $debut, ':fin' => $fin, ':limite' => $limite, ':num' => $idTournoi));
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }

    public function obtenirTournois() {
        try {
            $liste = array();

            $requete = 'SELECT * FROM tournoi ORDER BY ID_TOURNOI DESC';
            $cnx = Database::get_connexion();

            $res = $cnx->query($requete);
            foreach ($res as $row) {
                $tour = new Tournoi($row['NOM_TOURNOI'], $row['NBR_MIN_EQUIPES'], $row['NBR_MAX_EQUIPES'], $row['DATE_DEBUT_TOURNOI'], $row['DATE_FIN_TOURNOI'], $row['DATE_LIMITE_INSCRIPTION']);
                $tour->setId_tournoi($row['ID_TOURNOI']);
                array_push($liste, $tour);
            }
            $res->closeCursor();
            Database::close();
            return $liste;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }
    }
    
    
    public function obtenir($id){
         try {
            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM tournoi WHERE ID_TOURNOI = :num');
            $idInt = (int)$id;
            $pstmt->execute(array(':num' => $id));

               
            $res = $pstmt->fetch(PDO::FETCH_OBJ);
            
            if ($res){
                $tour = new Tournoi($res->NOM_TOURNOI, $res->NBR_MIN_EQUIPES, $res->NBR_MAX_EQUIPES, $res->DATE_DEBUT_TOURNOI, $res->DATE_FIN_TOURNOI, $res->DATE_LIMITE_INSCRIPTION);
                $tour->setId_tournoi($res->ID_TOURNOI);
                
                $pstmt->closeCursor();

                return $tour;
            }
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	    
            
    }	


}
