<?php
session_start();

// error_log("POST : ".print_r($_POST, 1));

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {

      header("location:../index.php");
} else {


      if (isset($_POST['modifier'])) {


            $id = $_POST["id"];
            $returnDate = $_POST["ReturnDate"];

            $requete = "UPDATE tblissuedbookdetails SET ReturnDate =:ReturnDate WHERE id =:id";

            $stmt = $conn->prepare($requete);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':ReturnDate', $returnDate);
            $stmt->execute();

            header("location:manage-issued-books.php");
            // exit("modifier avec succes");
      }
}

?>
<!DOCTYPE html>
<html lang="FR">

<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

      <title>Gestion de bibliothèque en ligne | Sorties</title>
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
      <!-- MENU SECTION END-->
      <div class="mt-4">
            <div>
                  <div>
                        <h3>EDITION DES SORTIES</h3>
                  </div>
            </div>
      </div>

      <div class="border border-secondary m-4 rounded">

            <div class="bg-info p-2 text-white">Infos Sorties</div>

            <!-- <div class="p-2">
                  <p>TITRE DU LIVRE : <span class="font-weight-bold"><= $_POST['title'] ?></span></p>
                  <p>AUTEUR : <span class="font-weight-bold"><= $_POST["auteur"] ?></span></p>
            </div> -->

            <form action="edit-issue-book.php" method="POST" class="p-2">

                  <div class="form-group">
                        <input type="hidden" name="id" value="<?= $_POST["id"] ?>">
                        <label for="RetutnDate">Date de Retour du livre : </label>
                        <input class="form-control" type="text" name="ReturnDate" value="<?= $_POST["ReturnDate"] ?>">
                  </div>
                  <div>
                        <button type="submit" class="border-0 bg-info rounded text-white" name="modifier">Mettre a jour</button>
                  </div>

            </form>
      </div>

      <!-- CONTENT-WRAPPER SECTION END-->
      <?php include('includes/footer.php'); ?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <script src="script3.js"></script>
</body>

</html>