<?php
session_start();

include("includes/config.php");

if (strlen($_SESSION["alogin"]) == 0) {

    header('location:../index.php');
} else {


    if (isset($_POST['effacerdefinivement'])) {

        $id = $_POST['id'];

        // if (!is_numeric($id) || empty($id)) {
        //     echo "erreur";

        $requete = " DELETE FROM tblbooks WHERE id = :id";
        $query = $conn->prepare($requete);
        $query->bindParam(':id', $id);
        $query->execute();

        header("location:manage-books.php");
    }
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
    <div class="m-4 display-5"><a href="manage-books.php"> &#8678; RETOUR</a></div>
    <div class="d-flex justify-content-center ">

        <form action="bookdelete.php" class="border border-danger p-4 m-5 rounded" method="POST">

            <p><span class="text-info">TITRE DU LIVRE </span>: <?php echo $_POST['title'] ?></p>
            <p><span class="text-info">AUTEUR </span>: <?php echo $_POST['auteur'] ?>
            </p>
            <p><span class="text-info">CATEGORIE </span> : <?php echo $_POST['categorie'] ?>
            </p>
            <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
            <button class="bg-danger text-white p-2 border-0 rounded" type="submit" name="effacerdefinivement">LA SUPPRESSION EST DEFINITIVE/SOUHAITEZ-VOUS CONTINUER</button>

        </form>
    </div>