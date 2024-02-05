<?php
// On démarre (ou on récupère) la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

error_log(print_r($_SESSION, 1));

if (strlen($_SESSION['alogin']) == 0) {
  // Si l'utilisateur est déconnecté
  // L'utilisateur est renvoyé vers la page de login : index.php
  header('location:../index.php');
} else {
  // sinon on récupère les informations à afficher depuis la base de données
  // On récupère le nombre de livres depuis la table tblbooks

  $requete1 = " SELECT COUNT(id) FROM tblbooks ";

  $query = $conn->prepare($requete1);

  $query->execute();

  $result = $query->fetch();

  // On récupère le nombre de livres en prêt depuis la table tblissuedbookdetails

  $requete2 = " SELECT COUNT(id) FROM tblissuedbookdetails";

  $query = $conn->prepare($requete2);

  $query->execute();

  $result1 = $query->fetch();


  // On récupère le nombre de livres retournés  depuis la table tblissuedbookdetails
  // Ce sont les livres dont le statut est à 1

  $requete3 = " SELECT COUNT(ReturnStatus) FROM tblissuedbookdetails WHERE ReturnStatus = 1";

  $query = $conn->prepare($requete3);

  $query->execute();

  $result2 = $query->fetch();




  // On récupère le nombre de lecteurs dans la table tblreaders²

  $requete3 = " SELECT COUNT(ReaderId) FROM tblreaders";

  $query = $conn->prepare($requete3);

  $query->execute();

  $result3 = $query->fetch();

  // On récupère le nombre d'auteurs dans la table tblauthors

  $requete4 = "SELECT COUNT(id) FROM tblauthors";

  $query = $conn->prepare($requete4);

  $query->execute();

  $result4 = $query->fetch();

  // On récupère le nombre de catégories dans la table tblcategory

  $requete5 = "SELECT COUNT(id) FROM tblcategory";

  $query = $conn->prepare($requete5);

  $query->execute();

  $result5 = $query->fetch();

?>
  <!DOCTYPE html>
  <html lang="FR">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Tab bord administration</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
  </head>

  <body>
    <!--On inclue ici le menu de navigation includes/header.php-->
    <?php include('includes/header.php'); ?>
    <!-- On affiche le titre de la page : TABLEAU DE BORD ADMINISTRATION-->
    <div class="container mt-5">
      <div class="row">
        <div class="col">
          <h3>TABLEAU DE BORD ADMINISTRATION</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-md-3 m-2 border border-success">
          <!-- On affiche la carte Nombre de livres -->
          <div class="alert alert-succes text-center text-success">
            <span class="fa fa-book fa-5x">
              <h3><?php echo $result[0]; ?></h3>
            </span>
            <div>
              Nombre de livre
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-3 m-2 border border-info">
          <!-- On affiche la carte Livres en pr�t -->
          <div class="alert alert-succes text-center text-info">
            <span class="fa fa-bars fa-5x">
              <h3><?php echo $result1[0]; ?></h3>

            </span>
            <div>
              Livres en pret
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-3 m-2 border border-warning">
          <!-- On affiche la carte Livres retourn�s -->
          <div class="alert alert-succes text-center text-warning">
            <span class="fa fa-recycle fa-5x">
              <h3><?php echo $result2[0]; ?></h3>

            </span>
            <div>
              Livres retournés
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-3 border border-danger mb-3 m-2">
          <!-- On affiche la carte Lecteurs -->
          <div class="alert alert-succes text-center text-danger">
            <span class="fa fa-users fa-5x">
              <h3><?php echo $result3[0]; ?></h3>

            </span>
            <div>
              Lecteurs
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-3 m-2 border border-success mb-3">
          <!-- On affiche la carte Auteurs -->
          <div class="alert alert-succes text-center text-success">
            <span class="fa fa-users fa-5x">
              <h3><?php echo $result4[0]; ?></h3>

            </span>
            <div>
              Auteurs
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-3 m-2 border border-info mb-3 ">
          <!-- On affiche la carte Cat�gories -->
          <div class="alert alert-succes text-center text-info">
            <span class="fa fa-file-archive-o fa-5x">
              <h3><?php echo $result5[0]; ?></h3>

            </span>
            <div>
              Catégories
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>

  </html>
<?php } ?>