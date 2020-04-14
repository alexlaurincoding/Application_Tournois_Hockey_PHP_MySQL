
<!DOCTYPE html>
<html>
    
    
    <head>

        <!-- Meta tags requis pour Bootstrap -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
<!--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

         Notre propre CSS 
        <link rel="stylesheet" type="text/css" href="ligueCSSPrincipal.css">-->
         <link rel="stylesheet" type="text/css" href="<?=Util::PATH()?>/bootstrap-4.4.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?=Util::PATH()?>/Styles/ligueCSSPrincipal.css">


        <title>Ligue de Hockey</title>
    </head>
    <body>
        <!--Barre de navigation-->
        <header class="site-header">
       <?php 
        if (Session::userIsConnected()) {
           include("./Vues/Partial/bannerAdmin.php");
        }else{
             include("./Vues/Partial/banner.php");
        }   
          ?>
        </header>

        <!-- Partie principale de la page -->
        <main role="main" class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="content-section-login main-section-top">
                        <h3>S'Identifier</h3><br>


                        <form method="post" action="./Admin">
                            
                            <div class="form-group">
                                <p style="color:red;"><?=Util::message("courriel")?></p>
                                <p style="color:red;"><?=Util::message("motDePasse")?></p>
                                <label for="exampleInputEmail1">Courriel</label>
                                <input type="email" id="courriel" name="courriel" value="<?=Util::param("courriel")?>"  class="form-control" aria-describedby="emailHelp"  required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Mot de Passe</label>
                                <input type="password" id="motDePasse" value="<?= Util::param('motDePasse')?>" name="motDePasse" class="form-control" required>
                            </div>

                            <input class="btn btn-secondary" type="submit" name="submit" value="Envoyer">
                        </form>
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
</html>