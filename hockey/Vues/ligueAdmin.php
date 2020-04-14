
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
            <div class="row">
                <div class="col-md-10">
                    <div class="content-section-login">
                        <h3>Page Admin</h3><br>

                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button id="btnHeading1" onclick="afficherEquipes('<?= Util::PATH() ?>');" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Gérer les Équipes de la Ligue
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">

                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Équipes de la Ligue</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyAffichageEquipes">
                                                <!--On insere ici les equipes dynamiquement-->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button id="btnHeading2" onclick="afficherTournois('<?= Util::PATH() ?>');" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Gérer les Tournois
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">

                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Tournois de la Ligue</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableAffichageTournois">

                                                <!--Afficher les tournois dynamiquement ici -->

                                            </tbody>
                                        </table>
                                        <div id="sectionAjouterTournoi">
                                            
                                            
                                        <strong><span id='titreTournoi'>AJOUTER UN TOURNOI</span></strong><br><br>

                                        <label>Nom Tournoi:</label>
                                        <input id='nomTournoiAjout' type='text' name='nom' class='form-control'>

                                        <label>Nombre minimum d'équipes:</label>
                                        <input id='minTournoi' type='text' name='min' class='form-control'>

                                        <label>Nombre maximum d'équipes:</label>
                                        <input id='maxTournoi' type='text' name='max' class='form-control'>

                                        <label>Début Tournoi:</label>
                                        <input id='dateDebutTournoi' type='date' name='debut' class='form-control'>

                                        <label>Fin Tournoi:</label>
                                        <input id='dateFinTournoi' type='date' name='fin' class='form-control'>

                                        <label>Date Limite d'Inscription:</label>
                                        <input id='dateLimiteInscription' type='date' name='limite' class='form-control'><br>


                                        <button id='btnAjouterTournoi' class='btn btn-secondary' type='button' onclick='ajouterTournoi("<?= Util::PATH() ?>")'>Ajouter</button>
                                        <button style='display:none;' id='btnAnnulerModifTournoi' class='btn btn-secondary' type='button'  onclick='annulerModifTournoi("<?= Util::PATH() ?>")'>Annuler</button>
                                        </div>                                            
                                            
                                    </div>
                                </div>
                            </div>




                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button onclick="afficherOptionsTournois('<?= Util::PATH() ?>', 3);" id="btnHeading3" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Gérer les Participants d'un Tournoi
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">

                                        <select id="selectTournoi3" class="form-control form-control-lg" onchange="afficherParticipants('<?= Util::PATH() ?>', 3);">
                                            <option value="option1" id="premiereOptionTournoi3">--Sélectionnez un Tournoi--</option>

                                            <!--On insère ici dynamiquement les tournois comme étant des options -->
                                        </select>

                                        <br><br>   

                                        <div id="lesTablesEquipes">
                                            <table id="afficherEquipes"  class="table" style="display:none;">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Équipes</th>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyTableAfficherEquipes">
                                                    <!--On insere ici dynamiquement toutes les equipes -->

                                                </tbody>

                                            </table>
                                            <?php
//     }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h5 class="mb-0">
                                        <button id="btnHeading4" onclick="afficherOptionsTournois('<?= Util::PATH() ?>', 4);" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            Gérer le Calendrier et les Parties d'un Tournoi
                                        </button>
                                    </h5>
                                </div>


                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body">

                                        <select id="selectTournoi4" class="form-control form-control-lg" onchange="gererCalendrier('<?= Util::PATH() ?>', 4);">
                                            <option value="option1" id="premiereOptionTournoi4">--Sélectionnez un Tournoi--</option>
                                            <!--Generer les options dynamiquement -->
                                        </select>

                                        <br><br>   

                                        <div style="display: none;" id="formulaireCreerCalendrier">


                                            <strong>CRÉER LE CALENDRIER</strong>
                                            <br> <br>

                                            <label>Nombre d'équipes:</label>
                                            <input type="text" name="nombre" class="form-control" id="nbrEquipes">
                                            <label>Debut Calendrier:</label>
                                            <input type="date" name="debut" class="form-control" id="debutCalendrier">
                                            <label>Fin Calendrier:</label>
                                            <input type="date" name="fin" class="form-control" id="finCalendrier">
                                            <input id="inputIdTournoiCalendrier" type="hidden" name="idTournoi"> <!--On ajoute l'id du tournoi dynamiquement ici-->
                                            <br>
                                            <button onclick="creerCalendrier('<?= Util::PATH() ?>', 4)" class="btn btn-secondary" type="button">Créer</button>
                                        </div>



                                        <div style="display: none;" id="affichageParties">
                                            <div id="formModifierCalendrier">
                                                <strong>MODIFIER LE CALENDRIER</strong>
                                                <br> <br>
                                                <label>Nombre d'équipes:</label>
                                                <input type="text" name="nombre" class="form-control" id="nbrEquipesModifCalendrier">
                                                <label>Debut Calendrier:</label>
                                                <input type="date" name="debut" class="form-control" id="debutModifCalendrier">
                                                <label>Fin Calendrier:</label>
                                                <input type="date" name="fin" class="form-control" id="finModifCalendrier">
                                                <input id="idTournoiModifCalendrier" type="hidden" name="idTournoi"> <!--On ajoute l'id du tournoi dynamiquement ici-->
                                                <br>
                                            </div>
                                            <button id="btnModifCal" onclick="remplirModifCalendrier('<?= Util::PATH() ?>', 4)" class="btn btn-warning" type="button">Modifier le calendrier</button>
                                            <button style='display:none;' id='btnAnnulerModifCalendrier' class='btn btn-secondary' type='button'  onclick='gererCalendrier("<?= Util::PATH() ?>", 4)'>Annuler</button>

                                            <br> <br><br> <br>

                                            <strong>PARTIES DU TOURNOI</strong>
                                            <br> <br>

                                            <table id="tableAfficherParties" class="table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Jour</th>
                                                        <th scope="col">Heure</th>
                                                        <th scope="col">Locale</th>
                                                        <th scope="col">Adverse</th>
                                                        <th scope="col">Patinoire</th>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyTableAfficherParties">

                                                    <!--Afficher les parties dynamiquement ici -->

                                                </tbody>
                                            </table>

                                            <br> <br>
                                            <div id="sectionAjoutPartie">
                                                <div id="titreAjoutPartie"><strong>AJOUTER UNE PARTIE</strong></div>
                                                 <br>

                                                <select id="selectEquipesA" name="equipesA" class="form-control form-control-lg">
                                                    <option value="option1EquipeA" id="option1EquipeA">--Équipe Locale--</option>
                                                    <!--Inserer dynamiquement les equipes -->
                                                </select>

                                                <h4 style="text-align: center;"> vs </h4>
                                                
                                                <select id="selectEquipesB" name="equipesB" class="form-control form-control-lg">
                                                    <option value="option1EquipeB" id="option1EquipeB">--Équipe Adverse--</option>
                                                    <!--Inserer dynamiquement les equipes -->

                                                </select>

                                                <br>


                                                <input id="datePartieAjout" type="date" name="jour" class="form-control">
                                                <br>

                                                <input id="heurePartieAjout" type="time" name="heure" class="form-control">

                                                <br>
                                                <select id="selectPatinoire" name="patinoire" class="form-control form-control-lg">
                                                    <option value="option1Patinoire" id="option1Patinoire">--Patinoire--</option>
                                                    <?php 
                                                    
                                                    $patinoiresAffichees = CalendrierServices::obtenirPatinoires();
                                                    
                                                    if (Count($patinoiresAffichees) != 0){
                                                        
                                                        foreach($patinoiresAffichees as $patinoire){

                                                            ?>

                                                                <option value='<?= $patinoire->getId_patinoire() ?>'><?= $patinoire->getNom_arena() ?>, <?= $patinoire->getVille_arena() ?></option>

                                                                <?php
                                                            }
                                                    }
                                                    ?>
                                                    
                                                    
                                                </select>
                                                <input id="inputIdTournoiCreerParties" type="hidden" name="idTournoi"> <!--On ajoute l'id du tournoi dynamiquement ici-->

                                                <br>
                                                <button id="btnCreerPartie" onclick="creerPartie('<?= Util::PATH() ?>', 4)" class="btn btn-secondary" type="button">Ajouter</button>
                                                <button style='display:none;' id='btnAnnulerModifPartie' class='btn btn-secondary' type='button'  onclick='gererCalendrier("<?= Util::PATH() ?>", 4)'>Annuler</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <h5 class="mb-0">
                                        <button id="btnHeading5" onclick="afficherOptionsTournois('<?= Util::PATH() ?>', 5);"  class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            Gérer les Résultats des Parties
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="card-body">


                                        <select id="selectTournoi5" class="form-control form-control-lg" onchange="afficherResultats('<?= Util::PATH() ?>', 5);">
                                            <option value="option1" id="premiereOptionTournoi5">--Sélectionnez un Tournoi--</option>
                                            <!--Generer les options dynamiquement -->
                                           
                                        </select>

                                        <br><br>   

                                            <div style="display: none;" id="afficherPartiesSection5">

                                                <strong>RÉSULTATS DES PARTIES</strong>
                                                <br> <br>

                                                <table class="table table-borderless" id="tableAfficherPartiesSection5">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">Jour</th>
                                                            <th scope="col">Heure</th>
                                                            <th scope="col">Locale</th>
                                                            <th scope="col">Adverse</th>
                                                            <th scope="col">Patinoire</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyAfficherPartiesSection5">
                                                        
                                                        <!-- Inserer dynamiquement -->
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </main>
        
            <?php
                include("./Vues/Partial/footer.php");
        
            ?>


        <!-- Mon JS, puis jQuery, etc.-->
        <script src="<?= Util::PATH() ?>/js/scriptPrincipal.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>