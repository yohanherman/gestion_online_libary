<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('includes/config.php');

// echo $_SESSION["rdid"];
if (strlen($_SESSION['rdid']) == 0) {
     // Si l'utilisateur est déconnecté
     // L'utilisateur est renvoyé vers la page de login : index.php

     header('location:index.php');
} else {
     // On récupère l'identifiant du lecteur dans le tableau $_SESSION

     $lecteurId = $_SESSION["rdid"];
     // On veut savoir combien de livres ce lecteur a emprunte
     // On construit la requete permettant de le savoir a partir de la table tblissuedbookdetails

     $requete = "SELECT COUNT(ReaderID) FROM tblissuedbookdetails WHERE ReaderID =:ReaderID ";

     $query = $dbh->prepare($requete);

     $query->bindParam(':ReaderID', $lecteurId);

     $query->execute();

     // On stocke le résultat dans une variable
     // $result = $query->rowCount();
     // print_r($result = $query->fetch());
     // print_r($resul = $query->fetchAll());
     $result = $query->fetchColumn();
     // print_r($result);

     // On veut savoir combien de livres ce lecteur n'a pas rendu
     // On construit la requete qui permet de compter combien de livres sont associ�s � ce lecteur avec le ReturnStatus � 0 

     $requetelivreRendu = "SELECT COUNT(ReturnStatus) FROM tblissuedbookdetails WHERE ReaderID =:ReaderID AND ReturnStatus = 0";
     $query = $dbh->prepare($requetelivreRendu);
     $query->bindParam(':ReaderID', $lecteurId);
     $query->execute();
     $resultsRendu = $query->fetchColumn();

     // print_r($resultsRendu);

     // On stocke le résultat dans une variable

?>

     <!DOCTYPE html>
     <html lang="FR">

     <head>
          <meta charset="utf-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
          <title>Gestion de librairie en ligne | Tableau de bord utilisateur</title>
          <!-- BOOTSTRAP CORE STYLE  -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
          <!-- FONT AWESOME STYLE  -->
          <link href="assets/css/font-awesome.css" rel="stylesheet" />
          <!-- CUSTOM STYLE  -->
          <link href="assets/css/style.css" rel="stylesheet" />
          <link rel="stylesheet" href="style2.css">
     </head>

     <body>

          <!--On inclue ici le menu de navigation includes/header.php-->
          <?php include('includes/header.php'); ?>
          <!-- On affiche le titre de la page : Tableau de bord utilisateur-->
          <div class="">
               <div class="container mt-4">
                    <div class="row">
                         <h3>TABLEAU DE BORD UTILISATEUR</h3>
                    </div>
               </div>

               <!-- On affiche la carte des livres emprunt�s par le lecteur-->

               <div class="d-flex justify-content-start align-items-center m-5">
                    <div class="containerEmpruntelivre">
                         <div class="display-4 text-center text-info mb-3">&#9776;</div>
                         <p class="text-center text-info"><?php echo $result ?></p>
                         <p class="text-center text-info">Livres empruntes</p>
                    </div>



                    <div class="containerlivreNonRendu d-flex justify-content-center align-items-center mt-4 ml-5">
                         <div class="">
                              <div class="display-4 text-center text-warning mt-2">&#9842;</div>
                              <p class="text-center text-warning"><?php echo $resultsRendu ?></p>
                              <p class="text-center text-warning">Livres non encore rendus</p>
                         </div>

                    </div>
               </div>


               <!-- On affiche la carte des livres non rendus le lecteur-->

               <?php include('includes/footer.php'); ?>
               <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
     </body>

     </html>
<?php } ?>