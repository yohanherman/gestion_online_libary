<?php
session_start();

include('includes/config.php');

if (strlen($_SESSION["alogin"]) == 0) {
      header("location:../index.php");
} else {
      $requete = " SELECT id,AuthorName ,creationDate ,UpdationDate FROM tblauthors";
      $query = $conn->prepare($requete);
      $query->execute();
      $results = $query->fetchAll();
      $compteur = 1;
      // print_r($results);
}



if (isset($_POST["delete"])) {

      $id = $_POST["id"];

      $requeteSupp = "DELETE FROM tblauthors WHERE id =:id";
      $stmt = $conn->prepare($requeteSupp);
      $stmt->bindParam(":id", $id);
      $stmt->execute();

      header("location:manage-authors.php");
}





?>

<!DOCTYPE html>
<html lang="FR">

<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

      <title>Gestion de bibliothèque en ligne | Gestion des auteurs</title>
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
      <div class="mt-4 ">
            <div class="row">
                  <div class="col">
                        <h3>GESTION DES AUTEURS</h3>
                  </div>
            </div>
      </div>

      <div class="">
            <div class="bg-secondary p-3 text-white">Auteur</div>

            <table class="col-lg-12 col-md-12 col-sm-12 m-2 table table-striped">
                  <tr>
                        <td class="entete">#</td>
                        <td class="entete">Nom</td>
                        <td class="entete">Cree le</td>
                        <td class="entete">Mis a jour le</td>
                        <td class="entete">Action</td>
                  </tr>


                  <?php
                  foreach ($results as $result) {
                  ?>
                        <tr>
                              <td><?= $compteur++ ?></td>
                              <!-- <td><= $result["id"] ?></td> -->
                              <td><?= $result['AuthorName'] ?></td>
                              <td><?= $result['creationDate'] ?></td>
                              <td><?= $result['UpdationDate'] ?></td>
                              <td class="d-flex">
                                    <form action="manage-authors.php" method="POST" class="pr-2">
                                          <button class="supprimer border-0 bg-danger rounded" name="delete" type="submit">&#10008;Supprimer</button>
                                    </form>
                                    <form action="edit-author.php" method="POST">
                                          <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                                          <input type="hidden" name="name" value="<?php echo $result['AuthorName'] ?>">
                                          <button class="border-0  bg-primary rounded" type="submit" name="editer">&#9998;Mettre a jour</button>

                                    </form>
                              </td>

                        <?php
                  }
                        ?>

                        </tr>

            </table>
      </div>

      <!-- CONTENT-WRAPPER SECTION END-->
      <?php include('includes/footer.php'); ?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>