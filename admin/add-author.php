<?php
session_start();

include('includes/config.php');


if (strlen($_SESSION["alogin"]) == 0) {
      header("location:../index.php");
}


$errorMessage = "";
if (isset($_POST['ajouter'])) {

      $name = strip_tags($_POST['name']);

      if (empty($name)) {
            $errorMessage = "Ce champs est requis";
      } else {

            $requete = "INSERT INTO tblauthors(AuthorName) VALUES(:AuthorsName)";
            $query = $conn->prepare($requete);
            $query->bindParam(':AuthorsName', $name);
            $query->execute();

            if ($query->rowCount() > 0) {
                  echo "<script>alert('ajouter avec succes')</script>";
            } else {
                  echo "<script>alert('un probleme est survenu')</script>";
            }
      }
}


?>


<!DOCTYPE html>
<html lang="FR">

<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

      <title>Gestion de bibliothèque en ligne | Ajout de categories</title>
      <!-- BOOTSTRAP CORE STYLE  -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      <!-- FONT AWESOME STYLE  -->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- CUSTOM STYLE  -->
      <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
      <!------MENU SECTION START-->
      <?php include('includes/header.php'); ?>

      <div class="container">
            <div class="row">
                  <div class="col">
                        <h3 class="">AJOUTER UN AUTEUR</h3>
                  </div>
            </div>
      </div>
      <div class="border border-info m-3">
            <div class="bg-info p-2">Information auteur</div>
            <form action="add-author.php" method="POST">
                  <div class="form-group m-2">
                        <label class="form-label fw-bolder" for="name">Nom</label>
                        <input type="text" name="name" id="name" class="form-control">
                  </div>
                  <span class="m-5" style="color:red"><?php echo $errorMessage ?></span>
                  <div class=" mt-3 m-4 ">
                        <button type="submit" name="ajouter" class="btn btn-info btn-block mt-3 col-lg-2 col-md-2 col-sm-12">Ajouter</button>
                  </div>
            </form>
      </div>
      <!-- CONTENT-WRAPPER SECTION END-->
      <?php include('includes/footer.php'); ?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>