<?php
session_start();

include('includes/config.php');


if ($_SESSION["alogin"] == 0) {

      header('location:../index.php');
} else {

      // je selectionne les les categories pour mettre dans mon select
      $requeteselect = "SELECT id , CategoryName FROM tblcategory";
      $query = $conn->prepare($requeteselect);
      $query->execute();
      $results = $query->fetchAll();

      // je recupere les auteur a mettre dans mon select

      $requeteselect2 = "SELECT id , AuthorName FROM tblauthors";
      $stmt = $conn->prepare($requeteselect2);
      $stmt->execute();
      $results2 = $stmt->fetchAll();

      $errorMessage = "";

      if (isset($_POST['modifier'])) {

            $id = $_POST["id"];
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


                  $requeteupdate = "UPDATE tblbooks SET BookName =:BookName ,CatId =:CatId , AuthorId =:AuthorId ,BookPrice =:prix ,ISBNNumber =:isbn WHERE id =:id";

                  $stmt = $conn->prepare($requeteupdate);

                  $stmt->bindParam(':id', $id);
                  $stmt->bindParam(':BookName', $titre);
                  $stmt->bindParam(':CatId', $categorie);
                  $stmt->bindParam(':AuthorId', $auteur);
                  $stmt->bindParam(':prix', $prix);
                  $stmt->bindParam(':isbn', $isbn);

                  $stmt->execute();

                  header("location:manage-books.php");
            }
      }
}





?>

<!DOCTYPE html>
<html>

<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

      <title>Gestion de bibliothèque en ligne | Livres</title>
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
                        <h3>EDITER UN LIVRE</h3>
                  </div>
            </div>
      </div>

      <div class="border border-info m-2 rounded mt-5 mb-5">
            <h5 class=" bg-info p-2">Info Livre</h5>
            <div>
                  <div class="d-flex justify-content-end mr-2">
                        <div><span class="text-danger">*</span> Champs obligatoires</div>
                  </div>
                  <form class="p-3" action="edit-book.php" method="POST">
                        <div class="form-group">

                              <label class="form-label font-weight-bold" for="title">Titre</label><span class="text-danger">*</span>
                              <input class="form-control" type="text" name="title" value="<?php echo $_POST['auteur'] ?>">
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
                              <select name="auteur" id="auteur" class="w-100 p-2 rounded border border-opacity-10">

                                    <?php foreach ($results2 as $result2) { ?>
                                          <option value="<?php echo $result2["id"] ?>"><?= $result2["AuthorName"] ?></option>

                                    <?php

                                    }

                                    ?>

                              </select>

                        </div>

                        <div class="form-group">
                              <label class="form-label font-weight-bold" for="isbn">ISBN</label><span class="text-danger">*</span>
                              <input type="number" name="isbn" class="form-control isbn" value="<?php echo $_POST["isbn"] ?>">
                              <span>Le numero ISBN doit etre unique</span>
                              <!-- <div class="textContainer"></div> pour la requete ajax -->
                        </div>

                        <div>
                              <input type="hidden" name="id" value='<?php echo $_POST["id"] ?>'>
                        </div>

                        <div class="form-group mb-5">
                              <label class="form-label font-weight-bold" for="prix">Prix</label><span class="text-danger">*</span>
                              <input class="form-control" type="number" name="prix" value="<?php echo $_POST['prix'] ?>">
                        </div>
                        <span style="color:red"><?= $errorMessage ?></span>
                        <div class="col-lg-2 col-md-2 col-sm-12 mb-3">
                              <button class="border-0 bg-info rounded btn-block text-white mt-3" name="modifier" type="submit">Mettre a jour</button>
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