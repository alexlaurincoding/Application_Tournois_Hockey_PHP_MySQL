<?php

class ResultatDAO {

    public function creerResultat($Partie, $butsA, $butsB) {
        try {
            $db = Database::get_connexion();

            $id_partie = $Partie->getId_partie();
            
            //Commencer par inserer dans la table Resultat           
            $pstm = $db->prepare("INSERT INTO resultat (BUTS_LOCAUX, BUTS_ADVERSES, ID_PARTIE)"
                    . " VALUES (:l, :a, :p)");

            $pstm->execute(array(':l' => $butsA, ':a' => $butsB, ':p' => $id_partie));
            
            //Puis, inserer dans la table Partie
            $pstm = $db->prepare("UPDATE partie SET BUTS_LOCAUX=:l, BUTS_ADVERSES=:a WHERE ID_PARTIE = :p");

            return $pstm->execute(array(':l' => $butsA, ':a' => $butsB, ':p' => $id_partie));
            
            
        } catch (PDOException $e) {
            throw $e;
            return null;
        }
    }
    
    public function modifierResultat($Partie, $butsA, $butsB) {
        try {
            $db = Database::get_connexion();

            $id_partie = $Partie->getId_partie();
            
            //Commencer par Modifier dans la table Resultat           
            $pstm = $db->prepare("UPDATE resultat SET BUTS_LOCAUX=:l, BUTS_ADVERSES=:a WHERE ID_PARTIE =:p");

            $pstm->execute(array(':l' => $butsA, ':a' => $butsB, ':p' => $id_partie));

            
            //Puis, modifier dans la table Partie
            $pstm = $db->prepare("UPDATE partie SET BUTS_LOCAUX=:l, BUTS_ADVERSES=:a WHERE ID_PARTIE = :p");

            return $pstm->execute(array(':l' => $butsA, ':a' => $butsB, ':p' => $id_partie));
            
            
        } catch (PDOException $e) {
            throw $e;
            return null;
        }
    }
    
    public function supprimerResultat($Resultat) {
       try
            {
                //Aller chercher les id du Resultat et de la Partie
                $db = Database::get_connexion();
                $idResultat = $Resultat->getId_resultat();
                
                $pstm = $db->prepare('SELECT * FROM resultat WHERE ID_RESULTAT = :r');
                $pstm->execute(array(':r' => $idResultat));
                $res = $pstm->fetch(PDO::FETCH_OBJ);
                $idPartie = null;
                
                if ($res){
                    $idPartie = $res->ID_PARTIE;
                }
                
                //Commencer par supprimer dans la table Resultat           
                $pstm = $db->prepare("DELETE FROM resultat WHERE ID_RESULTAT = :num");
                $pstm->bindParam(':num', $idResultat);
                $pstm->execute();
                
                //Puis, set a null dans la table Partie
                $pstm = $db->prepare("UPDATE partie SET BUTS_LOCAUX=:l, BUTS_ADVERSES=:a WHERE ID_PARTIE = :p");
                return $pstm->execute(array(':l' => null, ':a' => null, ':p' => $idPartie));
                
            }
            catch(PDOException $e)
            {
                    throw $e;
            }
    }
    
    public function obtenirResultat($Partie){
        try {
            
            //Aller chercher l'id de la partie
            $idPartie = $Partie->getId_partie();
            
            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM resultat WHERE ID_PARTIE = :p');
            $pstmt->execute(array(':p' => $idPartie));
            $res = $pstmt->fetch(PDO::FETCH_OBJ);
            
            if ($res){
                $l = $res->BUTS_LOCAUX;
                $a = $res->BUTS_ADVERSES;
                
                $resultat = new Resultat($l, $a);
                $resultat->setId_resultat($res->ID_RESULTAT);                
                $pstmt->closeCursor();
                return $resultat;
            }
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	    
            
    }
    
    
    
    
     public function obtenirPartie($Resultat){
        try {
            
            //Commencer par aller chercher le resultat pour avoir l'id de la partie
            $idResultat = $Resultat->getId_resultat();
            
            $db = Database::get_connexion();
            $pstmt = $db->prepare('SELECT * FROM resultat WHERE ID_RESULTAT = :num');
            $pstmt->execute(array(':num' => $idResultat));

            $res = $pstmt->fetch(PDO::FETCH_OBJ);
            $idPartie = null;
            
            if ($res){
                $idPartie = $res->ID_PARTIE;
            }
            
            //Aller chercher tous les details de la partie a partir de son id
            $pstmt = $db->prepare('SELECT * FROM partie WHERE ID_PARTIE = :p');
            $pstmt->execute(array(':p' => $idPartie));
            $res2 = $pstmt->fetch(PDO::FETCH_OBJ);
            
            if ($res2){
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
            }
            
            $pstmt->closeCursor();
            return $partie;
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	
     }    
}

