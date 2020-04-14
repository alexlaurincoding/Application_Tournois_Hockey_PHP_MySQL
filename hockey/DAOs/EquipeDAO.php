<?php

class EquipeDAO {
    
    public function creerEquipe($nom_equipe) {
        try
        {
            $db = Database::get_connexion();
            $pstm = $db->prepare("INSERT INTO equipe (NOM_EQUIPE)"
                                                    ." VALUES (:n)");
            $pstm->bindParam(':n',$nom_equipe);
         
            return $pstm->execute();
        }
        catch(PDOException $e)
        {
            throw $e;
        }
    }

    
    public function supprimerEquipe($id) {
       try
            {
                $db = Database::get_connexion();
                $pstm = $db->prepare("DELETE FROM equipe WHERE ID_EQUIPE = :num");
                $idInt = (int)$id;
                $pstm->bindParam(':num', $idInt);
                return $pstm->execute();
            }
            catch(PDOException $e)
            {
                    throw $e;
            }
    }
    
    public function modifierEquipe($id, $nom) {
       try
            {
                $db = Database::get_connexion();
                $pstm = $db->prepare("UPDATE equipe SET NOM_EQUIPE=:nom WHERE ID_EQUIPE = :num");
                return $pstm->execute(array(':nom' => $nom, ':num' => $id));

            }
            catch(PDOException $e)
            {
                    throw $e;
            }
    }
    
    public function obtenirEquipes(){
        try {
                $liste = array();

                $requete = 'SELECT * FROM equipe ORDER BY ID_EQUIPE';
                $cnx = Database::get_connexion();

                $res = $cnx->query($requete);
                foreach($res as $row) {
                    $eq = new Equipe($row['NOM_EQUIPE']);
                    $eq->setId_equipe($row['ID_EQUIPE']);
                    array_push($liste,$eq);
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
            $pstmt = $db->prepare('SELECT * FROM equipe WHERE ID_EQUIPE = :num');
            $idInt = (int)$id;
            $pstmt->execute(array(':num' => $id));

            $res = $pstmt->fetch(PDO::FETCH_OBJ);
            
            if ($res){
                $eq = new Equipe($res->NOM_EQUIPE);
                $eq->setId_equipe($res->ID_EQUIPE);
                
                $pstmt->closeCursor();
                return $eq;
            }
            
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return NULL;
        }	    
            
    }	
    
}