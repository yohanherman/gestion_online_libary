<?php
session_start();

include('includes/config.php');


if ($_SESSION["alogin"] == 0) {

  header('location:../index.php');
} else {


  // je selectionne les les categories pour mettre dans mon se
  $requeteselect = "SELECT id , CategoryName FROM tblcategory";
  $query = $conn->prepare($requeteselect);
  $query->execute();
  $results = $query->fetchAll();

  // je recupere les auteur a mettre dans mon select

  $requeteselect2 = "SELECT id , AuthorName FROM tblauthors";
  $stmt = $conn->prepare($requeteselect2);
  $stmt->execute();
  $results2 = $stmt->fetchAll();





  // ajout de mes livres
  $errorMessage = "";

  if (isset($_POST['ajouter'])) {

    $titre = $_POST['title'];
    $categorie = $_POST['categorie'];
    $auteur = $_POST['auteur'];
    $prix = $_POST['prix'];
    $isbn = $_POST["isbn"];


    if (empty($titre) || empty($categorie) || empty($auteur) || empty($prix) || empty($isbn)) {

      $errorMessage = "tous les champs sont requis";
    } elseif (!preg_match('/[0-9a-zA-Z.+_]/', $titre)) {

      $errorMessage = "le titre du livre n'est pas valide";
    } else {

      // ma requete d'ajout a la base de donnees

      $requeteAjout = "INSERT INTO tblbooks (BookName , CatId , AuthorId, ISBNNumber , BookPrice ) VALUES (:title , :categorie ,:auteur ,:isbn ,:prix)";
      error_log($titre);
      error_log($categorie);
      error_log($auteur);
      error_log($prix);
      error_log($isbn);
      $stmt = $conn->prepare($requeteAjout);

      $stmt->bindParam(':title', $titre);
      $stmt->bindParam(':categorie', $categorie);
      $stmt->bindParam(':auteur', $auteur);
      $stmt->bindParam(':prix', $prix);
      $stmt->bindParam(':isbn', $isbn);

      $stmt->execute();

      header('location:manage-books.php');
    }
  }
}


?>
<!DOCTYPE html>
<html lang="FR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <title>Gestion de bibliothèque en ligne | Ajout de livres</title>
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
  <div class="mt-3">
    <div>
      <div>
        <h3 class="m-2">AJOUTER UN LIVRE</h3>
      </div>
    </div>
  </div>
  <div class="border border-info m-2 rounded mt-5 mb-5">
    <h5 class=" bg-info p-2">Information Livre</h5>
    <div>
      <div class="d-flex justify-content-end mr-2">
        <div><span class="text-danger">*</span> Champs obligatoires</div>
      </div>
      <form class="p-3" action="add-book.php" method="POST">
        <div class="form-group">
          <label class="form-label font-weight-bold" for="title">Titre</label><span class="text-danger">*</span>
          <input class="form-control" type="text" name="title">
        </div>
        <div class="form-group">
          <label class="form-label font-weight-bold" for="categories">Categorie</label><span class="text-danger">*</span>
          <select name="categorie" id="categorie" class="w-100 p-2 rounded">

            <?php foreach ($results as $result) { ?>
              <option value="<?php echo $result["id"] ?>"><?= $result["CategoryName"] ?></option>

            <?php
            }
            ?>

          </select>

        </div>
        <div class="form-group">

          <label class="form-label font-weight-bold " for="auteur">Auteur</label><span class="text-danger">*</span><br>
          <select name="auteur" id="auteur" class="w-100 p-2 rounded">

            <?php foreach ($results2 as $result2) { ?>
              <option value="<?php echo $result2["id"] ?>"><?= $result2["AuthorName"] ?></option>

            <?php

            }

            ?>

          </select>

        </div>

        <div class="form-group">
          <label class="form-label font-weight-bold" for="isbn">ISBN</label><span class="text-danger">*</span>
          <input type="number" name="isbn" class="form-control isbn" id="isbn" onblur="checkISBN()">
          <span class="containerHtml"></span>
          <span>Le numero ISBN doit etre unique</span>
          <div class="textContainer"></div>
        </div>

        <div class="form-group mb-5">
          <label class="form-label font-weight-bold" for="prix">Prix</label><span class="text-danger">*</span>
          <input class="form-control" type="number" name="prix">
        </div>
        <span style="color:red"><?= $errorMessage ?></span>
        <div class="col-lg-2 col-md-2 col-sm-12 mb-3">
          <button class="border-0 bg-info rounded btn-block text-white mt-3" name="ajouter" id="ajouter" type="submit">Ajouter</button>
        </div>
      </form>
    </div>
  </div>

  <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php'); ?>
  <!-- FOOTER SECTION END-->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="script3.js"></script>
</body>

</html>