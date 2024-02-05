<?php
session_start();

include('includes/config.php');
echo $_POST["id"];
echo $_POST["name"];


if (strlen($_SESSION['alogin']) == 0) {
     header("location:../index.php");
} else {


     $errorMessage = "";

     if (isset($_POST['update'])) {

          $name = $_POST['name'];
          $id = $_POST['id'];

          if (empty($name) || empty($id)) {
               $errorMessage = "Ce champs est requis";
          } else {

               $requete = "UPDATE tblauthors SET AuthorName =:AuthorName WHERE id =:id";
               $query = $conn->prepare($requete);
               $query->bindParam(":AuthorName", $name);
               $query->bindParam(":id", $id);
               $query->execute();
          }
     }
}
// echo $_POST['name'];

// echo $_POST['id'];
?>
<!DOCTYPE html>
<html lang="FR">

<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

     <title>Gestion de bibliothèque en ligne | Auteurs</title>
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
     <div class="">
          <div class="">
               <div>
                    <h3>EDITER L'AUTEUR</h3>
               </div>
          </div>
     </div>

     <div class="border border-secondary m-3 rounded ">
          <div class="bg-info p-2">Info auteur</div>
          <form action="edit-author.php" method="POST" class="mt-3 p-3">
               <div class="form-group">
                    <label class="form-label font-weight-bold" for="name">Nom</label>
                    <input class="form-control" type="text" name="name" value="<?php echo $_POST['name'] ?>">
                    <input class="form-control" type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
               </div>
               <span class="mt-3" style="color:red"><?php echo $errorMessage ?></span>
               <div class="mt-3 col-lg-2 col-md-2 col-sm-12">
                    <button class="border-0 bg-info rounded btn-block" type="submit" name="update">Mettre a jour</button>
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