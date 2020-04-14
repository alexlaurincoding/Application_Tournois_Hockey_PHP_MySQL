
<!DOCTYPE html>
<html>
    <head>

        <!-- Meta tags requis pour Bootstrap -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--     Bootstrap CSS 
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
             Notre propre CSS 
            <link rel="stylesheet" type="text/css" href="http://localhost/hockey/Vues/ligueCSSPrincipal.css">-->
        <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/bootstrap-4.4.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= Util::PATH() ?>/Styles/ligueCSSPrincipal.css">



        <title>Ligue de Hockey</title>
    </head>

    <body>

        <!--Barre de navigation-->
        <header class="site-header">
            <?php
            if (Session::userIsConnected()) {
                include("./Vues/Partial/bannerAdmin.php");
            } else {
                include("./Vues/Partial/banner.php");
            }
            ?>
            <br><br><br>

            <img id="banner-top" src="<?= Util::PATH() ?>/Vues/Images/banner-hockey.jpg" width="100%" height="250px">

        </header>

        <!-- Partie principale de la page -->
        <main role="main" class="container-fluid">
            <br><br><br>
            <div class="row">
                <div class="col-md-8">
                    <div class="content-section main-section-top">

                        <h3>Bienvenue sur le site du Championnat de la Ligue des Faux-Pamplemousses !</h3><br>

                        <img class="imageAccueilEquipe" src="<?= Util::PATH() ?>/Vues/Images/equipe_page_accueil.png">


                    </div>
                </div>
                <div class="col-md-4">

                    <div class="content-section" id="right-box">
                        <h3>Quoi de 9?</h3>
                        <p class='text-muted'>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-light">Tournoi 2020 arrive à grands pas!</li>
                            <li class="list-group-item list-group-item-light"><strong>Joueur de la semaine:</strong><br><br> Raymond Chabot de l'équipe des Chameaux<br><br>BRAVO RAYMOND!</li>
                            <li class="list-group-item list-group-item-light">Champions 2019: Les Chevaliers Huilés!</li>
                            <li class="list-group-item list-group-item-light"><a href="https://www.cafdn.org/for-youth/covid-19-youth-support-fund/">Aidez à combattre le Covid-19</a></li>
                        </ul>
                        </p>
                    </div>
                </div>
                
            </div>
        </main>

        <!-- Optional JavaScript for Bootstrap-->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    <footer>
                <?php
                include("./Vues/Partial/footer.php");
        
            ?>
    </footer>
</html>

