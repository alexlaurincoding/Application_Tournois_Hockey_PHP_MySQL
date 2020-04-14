
<!DOCTYPE html>

<html>
    <head>

        <!-- Meta tags requis pour Bootstrap -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/bootstrap-4.4.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/Styles/ligueCSSPrincipal.css">


        <title>Ligue de Hockey</title>
    </head>

    <body>
        

        <?php
        $equipesAffichees = EquipeServices::getListeEquipe();

        //Toutes les parties:
        $toutesParties = CalendrierServices::obtenirToutesPartiesDesc();

        //Les tournois de la ligue
        //$tournoisAffiches = TournoiServices::getListeTournoi();
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

        <br><br><br>
        <!-- Partie principale de la page -->


        <main role="main" class="container-fluid">


            <div class="row">

                <div class="col-md-8">
        <img height="300" src="<?= Util::PATH() ?>/Vues/Images/resultats2.png">


                    <div>


                        <?php
                        $dateAffiche = '';

                        foreach ($toutesParties as $partie) {
                            
                         

                            //Afficher seulement s'il y a un resultat pour cette partie
                            if (ResultatServices::obtenirResultat($partie) != null) {
                                $leResultat = ResultatServices::obtenirResultat($partie);
                                $idResultat = $leResultat->getId_resultat();


                                $participA = $partie->getParticipant_local();
                                $eqA = $participA->getEquipe_participante();
                                $participB = $partie->getParticipant_adverse();
                                $eqB = $participB->getEquipe_participante();
                                $nomEqA = $eqA->getNom_equipe();
                                $nomEqB = $eqB->getNom_equipe();
                                $patin = $partie->getPatinoire();
                                $nomPatin = $patin->getNom_arena();
                                $ville = $patin->getVille_arena();


                                setlocale(LC_TIME, 'fr_FR');
                                $month_name = date('F', mktime(0, 0, 0));

                                $date = strtotime($partie->getJour_partie());
                                $mois = date("F", $date);
                                $annee = date("Y", $date);
                                $jourNum = date("d", $date);
                                //Enlever le 0 dans le numero du jour
                                if (substr($jourNum, 0, 1) == 0){
                                    $jourNum = (substr($jourNum, 1, 1));
                                }
                                $jourString = date("D", $date);
                                $heureSansSec = substr($partie->getHeure_partie(), 0, 5);
                                //Enlever le 0 dans l'heure
                                if (substr($heureSansSec, 0, 1) == 0){
                                    $heureSansSec = (substr($heureSansSec, 1, 4));
                                }

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




                                //Si nouveau jour, changer de section
                                if ($dateAffiche != $partie->getJour_partie()) {
                                    ?>
                                </div>
                                <div class="content-section-login">

                                    <h4><?= $jourString ?>, <?= $jourNum ?> <?= $mois ?> <?= $annee ?></h4>
                                    <br>
                                    <?php
                                }

                                //Reinitialiser la date affichee
                                $dateAffiche = $partie->getJour_partie();
                                ?>



                                <div class="container">
                                    <div style="color: olive; font-style: italic;">

                                        <?= $heureSansSec ?> - <?= $ville ?>, <?= $nomPatin ?>

                                    </div> 
                                    <br>
                                    
                                    <table class="table table-sm" style="width: 50%;">
                                       
                                        <tbody>
                                            <tr class="table-info">
                                                <td scope="row"><?= $nomEqA ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong><?= $leResultat->getButs_locaux() ?></strong></td>
                                               
                                            </tr>
                                            <tr class="table-warning">
                                                <td scope="row"><?= $nomEqB ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong><?= $leResultat->getButs_adverses() ?></strong></td>
                                               
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                </div>

                                <?php
                            }
                        }
                        ?>
                    </div>

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