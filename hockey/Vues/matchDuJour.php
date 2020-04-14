<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
         <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/bootstrap-4.4.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/Styles/ligueCSSPrincipal.css">

        <title>Ligue de Hockey</title>

    </head>

    <body>

        <header class="site-header">

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
            <br>
          <?php
          
            $listePartie = CalendrierServices::obtenirToutesPartiesDesc();
            
            //Commencer par afficher la date en titre
            foreach($listePartie as $partie){

                 $date = $partie->getJour_partie();
                 
                 if ($date == $_REQUEST['date']){
                     
                 
                    $dateModif = strtotime($date);
                    $mois = date("F", $dateModif);
                    $annee = date("Y", $dateModif);
                    $jourNum = date("d", $dateModif);
                    //Enlever le 0 dans le numero du jour
                    if (substr($jourNum, 0, 1) == 0){
                        $jourNum = (substr($jourNum, 1, 1));
                    }
                    $jourString = date("D", $dateModif);

                    //Regler pour le francais
                    if ($mois == "January")
                        $mois = "Janvier";
                    else if ($mois == "Februray")
                        $mois = "Fevrier";
                    else if ($mois == "March")
                        $mois = "Mars";
                    else if ($mois == "April")
                        $mois = "Avril";
                    else if ($mois == "May")
                        $mois = "Mai";
                    else if ($mois == "June")
                        $mois = "Juin";
                    else if ($mois == "Juillet")
                        $mois = "Juillet";
                    else if ($mois == "August")
                        $mois = "Aout";
                    else if ($mois == "September")
                        $mois = "Septembre";
                    else if ($mois == "October")
                        $mois = "Octobre";
                    else if ($mois == "November")
                        $mois = "Novembre";
                    else if ($mois == "December")
                        $mois = "Decembre";

                    if ($jourString == "Mon")
                        $jourString = "Lundi";
                    else if ($jourString == "Tue")
                        $jourString = "Mardi";
                    else if ($jourString == "Wed")
                        $jourString = "Mercredi";
                    else if ($jourString == "Thu")
                        $jourString = "Jeudi";
                    else if ($jourString == "Fri")
                        $jourString = "Vendredi";
                    else if ($jourString == "Sat")
                        $jourString = "Samedi";
                    else if ($jourString == "Sun")
                        $jourString = "Dimanche";

                    ?>

                    <h2 style="text-align: center;"><?= $jourString ?>, <?= $jourNum ?> <?= $mois ?> <?= $annee ?></h2>

                        <?php
                        break;
                 }
            }
            
            
            $noMatch = 0;
            
            //Ensuite, afficher les details de chaque partie de la journee
        
        foreach($listePartie as $partie){

            $date = $partie->getJour_partie();
            
            
           
            
            
            if ($date == $_REQUEST['date']){
               
                $noMatch++;

                $participA = $partie->getParticipant_local();
                $equipeA = $participA->getEquipe_participante();
                $nomA = $equipeA->getNom_equipe();
                
                $participB = $partie->getParticipant_adverse();
                $equipeB = $participB->getEquipe_participante();
                $nomB = $equipeB->getNom_equipe();
                
                $patinoire = $partie->getPatinoire();
                $nomPatinoire = $patinoire->getNom_arena();
                $ville = $patinoire->getVille_arena();
                
                //Enlever le 0 dans le numero du jour
                 $heureSansSec = substr($partie->getHeure_partie(), 0, 5);
                if (substr($heureSansSec, 0, 1) == 0){
                    $heureSansSec = (substr($heureSansSec, 1, 4));
                }
                
                ?>
               
                
                <div class="content-section-login col-md-8">
                    <h4>Match #<?=$noMatch?></h4>
                            <div style="color: olive; font-style: italic;">

                                <?= $heureSansSec ?> - <?= $ville ?>, <?= $nomPatinoire ?>

                            </div> 
                            <br>
                            
                            <table class="table table-sm" style="width: 50%;">

                                <tbody>
                                    <tr class="table-info">
                                        <td scope="row"><?= $nomA ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                
                                    <tr class="table-warning">
                                        <td scope="row"><?= $nomB ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                            <?php
                
            }
            
            
        }
        //echo $message;
          ?>
        </main>
        <footer>
         <?php
                include("./Vues/Partial/footer.php");
        
            ?>
        </footer>

        <!-- Optional JavaScript for Bootstrap-->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
