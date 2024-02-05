<?php
session_start();
include('includes/config.php');

if (strlen($_SESSION["alogin"]) == 0) {

      header("location:../index.php");
} else {
      $requete = "SELECT tblbooks.id ,tblbooks.BookName ,tblcategory.CategoryName ,tblauthors.AuthorName ,tblbooks.ISBNNumber,tblbooks.BookPrice FROM tblbooks JOIN tblcategory ON tblbooks.CatId=tblcategory.id JOIN tblauthors ON tblbooks.AuthorId=tblauthors.id";
      $query = $conn->prepare($requete);
      $query->execute();
      $results = $query->fetchAll();
      $compteur = 1;




      // requete de verifiction du numero isbn;

      // $isbn = $_POST["isbn"];


      // $requete = "SELECT ISBNNumber FROM tblbooks WHERE ISBNNumber =:ISBNNumber";
      // $stmt->prepare($requete);
      // $stmt->bindParam(':ISBNNumber', $isbn);
      // $stmt->fetc
}





?>

<!DOCTYPE html>
<html lang="FR">

<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

      <title>Gestion de bibliothèque en ligne | Gestion livres</title>
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

      <div class="mt-4 mb-4">
            <div>
                  <h3>GESTION DES LIVRES</h3>
            </div>
      </div>

      <div class="border border-secondary m-2 ">
            <p class="bg-secondary text-white p-2">Les livres</p>
            <div class="p-2">
                  <table class="table table-striped">
                        <tr>
                              <td class="font-weight-bold">#</td>
                              <td class="font-weight-bold">Title</td>
                              <td class="font-weight-bold">Categorie</td>
                              <td class="font-weight-bold">Auteur</td>
                              <td class="font-weight-bold">ISBNNumber</td>
                              <td class="font-weight-bold">prix</td>
                              <td class="font-weight-bold">Action</td>
                        </tr>

                        <?php foreach ($results as $result) { ?>

                              <tr>

                                    <td><?= $compteur++ ?>
                                    <!-- <td><= $result['id'] ?> -->
                                    <td><?= $result['BookName'] ?>
                                    <td><?= $result['CategoryName'] ?>
                                    <td><?= $result['AuthorName'] ?>
                                    <td><?= $result['ISBNNumber'] ?>
                                    <td><?= $result['BookPrice'] ?>
                                    <td class="d-flex justify-content-start">
                                          <form action="edit-book.php" class="mr-2" method="POST">
                                                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                                                <input type="hidden" name="isbn" value="<?php echo $result['ISBNNumber'] ?>">
                                                <input type="hidden" name="auteur" value="<?php echo $result['BookName'] ?>">
                                                <input type="hidden" name="prix" value="<?php echo $result['BookPrice'] ?>">
                                                <button class="border-0 bg-info rounded p-2 text-white" type="submit" name="editer">&#9998;Edition</button>
                                          </form>

                                          <form action="bookdelete.php" method="POST">
                                                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                                                <input type="hidden" name="title" value="<?php echo $result['BookName'] ?>">
                                                <input type="hidden" name="categorie" value="<?php echo $result['CategoryName'] ?>">
                                                <input type="hidden" name="auteur" value="<?php echo $result['AuthorName'] ?>">
                                                <button class="border-0 bg-danger rounded p-2 text-white" type="submit" name="effacer">&#10008;supprimer</button>
                                          </form>
                                    </td>
                              <?php

                        }
                              ?>
                              </tr>
                  </table>
            </div>
      </div>


      <?php include('includes/footer.php'); ?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>