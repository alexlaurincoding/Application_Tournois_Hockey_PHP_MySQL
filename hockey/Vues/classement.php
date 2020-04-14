
<!DOCTYPE html>

<html>
    <head>

        <!-- Meta tags requis pour Bootstrap -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/bootstrap-4.4.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/Styles/ligueCSSPrincipal.css">
        
        <script>
            //Au demarrage de la page, afficher la table de l'equipe selectionne (qui est l'equipe la plus recente dans la liste)
            window.onload = function(){
                
            afficherParticipants();
            
            //Monter le scroller au haut de la table
            let top = document.getElementById("top");
            top.scrollIntoView(true);
        };
            
        
        </script>


        <title>Ligue de Hockey</title>
    </head>

    <body id="top">

        <?php
        $equipesAffichees = EquipeServices::getListeEquipe();

        //Les tournois de la ligue

        $tournoisAffiches = TournoiServices::getListeTournoi();
        ?>

        <!--Barre de navigation-->
        <header class="site-header-">

            <?php
            if (Session::userIsConnected()) {
                include("./Vues/Partial/bannerAdmin.php");
            } else {
                include("./Vues/Partial/banner.php");
            }
            ?>
        </header>         


        <!-- Partie principale de la page -->

        <main role="main" class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <br>
                    
                    <div class="content-section-login">
                        
                        <img src="<?= Util::PATH() ?>/Vues/Images/classement2.png">
                        <br><br>
                        
                        

                        <script type="text/javascript">
                            function afficherParticipants() {
                                idTournoi = document.getElementById("tournoisParticipants").value;
                                lesTables = document.getElementsByClassName("tournois");
                                sectionAffichage = document.getElementById("sectionAffichage");

                                if (idTournoi == "defaut"){
                                    sectionAffichage.style.display = "none";
                                }
                                else{
                                    
                                    sectionAffichage.style.display = "block";
                                    
                                    for (let i=0; i<lesTables.length; i++){
                                        if (lesTables[i].id == idTournoi){
                                            
                                            lesTables[i].style.display = "block";
                                        }
                                        else{
                                            lesTables[i].style.display = "none";
                                        }
 
                                    }
                                }

                            }

                        </script>
                        
                       

                        <div class="form-group col-md-6">
                             <br><br>
                             <select onchange="afficherParticipants()" id="tournoisParticipants" class="form-control form-control-lg">
                                <option value='defaut' selected="true">--Tournoi--</option>
                                <?php
                                //Pour chaque tournoi
                                foreach ($tournoisAffiches as $tour) 
                                 { 
                                    //Si c'est le dernier tournoi, le selectionner par defaut (et  l'afficher au demarrage avec JavaScript)
                                    $dernier = end($tournoisAffiches);
                                    if ($tour == $dernier){
                                         ?>
                                <option selected="true" value='<?= $tour->getId_tournoi() ?>'><?= $tour->getNom_tournoi() ?></option>
                                
                                    <?php
                                    }
                                    else{
                                        
                                    
                                    ?>
                                    <option value='<?= $tour->getId_tournoi() ?>'><?= $tour->getNom_tournoi() ?></option>
                                
                                    <?php
                                    }
                                    
                                 }
                                 ?>

                            </select>
                        </div>

                        <br><br> 
                        <div id="sectionAffichage" style="display: none;">
                        <?php
                        foreach ($tournoisAffiches as $tour) {

                            //Creer une liste des participants qui a comme cle l'id de l'equipe participante et comme valeur son nombre de points - pouis l'ordonner (decroissant) par ordre de points
                            $classementEquipes = array();
                            ?>

                            <!--En-tete de la table qui affiche le classement-->
                                <table class="table table-striped tournois" id="<?=$tour->getId_tournoi() ?>" style="display: none;">
                                    <thead class="table-warning">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Équipes</th>
                                            <th scope="col">Victoire</th>
                                            <th scope="col">Nulles</th>
                                            <th scope="col">Défaites</th>
                                            <th scope="col">Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                                                  
                                        foreach ($equipesAffichees as $eq) {

                                            //Pour chaque participant, aller chercher son id et nombre de points (etc), pour l'ajouter a la liste/array
                                            if (ParticipantServices::getParticipant($eq, $tour) != null) {
                                                $idEquipe = $eq->getId_equipe();
                                                $participant = ParticipantServices::getParticipant($eq, $tour);
                                                $fiche = ParticipantServices::obtenirFiche($participant);
                                                $points = $fiche->getPoints();
                                                $victoire = $fiche->getNb_victoires();
                                                $defaites = $fiche->getNb_defaites();
                                                $nulles = $fiche->getNb_nulles();

                                                //Inserer dans le array avec comme cle l'id du participant et comme valeur un array qui contient les infos
                                                $classementEquipes[$idEquipe] = array();
                                                $classementEquipes[$idEquipe]["points"] = $fiche->getPoints();
                                                $classementEquipes[$idEquipe]["victoires"] = $fiche->getNb_victoires();
                                                $classementEquipes[$idEquipe]["nulles"] = $fiche->getNb_nulles();
                                                $classementEquipes[$idEquipe]["defaites"] = $fiche->getNb_defaites();
                                            }
                                        }
                                        
                                        

                                        //Maintenant qu'on a rempli la liste, on la sort selon differentes etapes                                      
                                        uasort($classementEquipes, function ($a, $b){
                                            
                                            //Si le meme nombre de points, classer par nombre de victoires
                                            if ($a["points"] == $b["points"]){
                                                
                                                //Si le meme nombre de victoires, classer par nulles
                                                if ($a["victoires"] == $b["victoires"]){
                                                    
                                                    //Si le meme nombre de nulles, classer par l'equipe qui a LE MOINS de defaites
                                                    if ($a["nulles"] == $b["nulles"]){
                                                        
                                                        return $a["defaites"] - $b["defaites"];
                                                    }
                                                    return $b["nulles"] - $a["nulles"];
                                                    
                                                }
                                                return $b["victoires"] - $a["victoires"];
                                            }
                                            
                                            return $b["points"] - $a["points"];
                                        });
                                                                                

                                        //On est maintenant pret a afficher les results
                                        $compteurEq = 1;
                                        foreach ($classementEquipes as $id => $tableau) {
                                            $Equipe = EquipeServices::getEquipe($id);
                                            $nom = $Equipe->getNom_equipe();
                                            $partAfficher = ParticipantServices::getParticipant($Equipe, $tour);
                                            $ficheAffich = ParticipantServices::obtenirFiche($partAfficher);
                                            $vic = $ficheAffich->getNb_victoires();
                                            $def = $ficheAffich->getNb_defaites();
                                            $nul = $ficheAffich->getNb_nulles();
                                            $points = $ficheAffich->getPoints();
                                            ?>


                                            <tr>
                                                <td><strong><?= $compteurEq++?></strong></td>
                                                <td><?= $nom ?></td>
                                                <td><?= $vic ?></td>
                                                <td><?= $nul?></td>
                                                <td><?= $def ?></td>
                                                <td><?= $points ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <span id="bottom"></span>

                            <?php
                        }
                        ?>
                        </div>


                    </div>
                </div>
            </div>

        </main>
        
         <?php
                include("./Vues/Partial/footer.php");
        
            ?>


        <!-- Optional JavaScript for Bootstrap-->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>