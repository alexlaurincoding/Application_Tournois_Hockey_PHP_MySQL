<?php

class EquipeController{
    
    
    public function Index() {
         
        return 'ligueAdmin';
    }
    
    public function Afficher(){
       $lesEquipes = EquipeServices::getListeEquipe();
       if (Count($lesEquipes) == 0){
           echo '{"nombre": "aucun"}';
           die();
       }
       
       $tableauObjetsJSON = "[";
       foreach($lesEquipes as $equipe){
           $tableauObjetsJSON.= '{"id_equipe": '.$equipe->getId_equipe() .', "nom_equipe": "'.$equipe->getNom_equipe().'"},';
       }
       
       //Enlever la derniere virgule et la remplacer par ] pour fermer le tableau
       $tableauFinal = substr($tableauObjetsJSON, 0, -1)."]";
       echo $tableauFinal;
       die();
    }
    
    public function Ajouter(){
        
        $nomEquipe = $_REQUEST['nomEquipe'];
         EquipeServices::ajouterEquipe($nomEquipe);
         echo '{"reponse":"OK"}';
         die();
    }
    

    public function Supprimer(){
        $idEquipe = $_REQUEST['idEquipe'];
        EquipeServices::supprimerEquipe($idEquipe);
        echo '{"reponse":"OK"}';
        die();
    }
    
    public function Modifier(){
        $idEquipe = $_REQUEST['idEquipe'];
        $nomEquipe = $_REQUEST['nomEquipe'];
        EquipeServices::modifierEquipe($idEquipe, $nomEquipe);
        echo '{"reponse":"OK"}';
        die();
    }
}

