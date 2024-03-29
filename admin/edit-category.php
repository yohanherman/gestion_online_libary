<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logué
if (strlen($_SESSION['alogin']) == 0) {
    // On le redirige vers la page de login  
    header('location:../index.php');
} else {
    // Sinon
    // Apres soumission du formulaire de categorie
    $requete = "SELECT id, CategoryName, Status FROM tblcategory";

    $query = $conn->prepare($requete);
    $query->execute();
    $result = $query->fetchAll();

    // print_r($result);

    // echo $_POST['Status'];
    // error_log($_POST['id']);


    // On recupere l'identifiant, le statut, le nom

    // On prepare la requete de mise a jour

    // On prepare la requete de recherche des elements de la categorie dans tblcategory

    // On execute la requete

    // On stocke dans $_SESSION le message "Categorie mise a jour"

    // On redirige l'utilisateur vers edit-categories.php
}
$errorMessage = "";

if (isset($_POST['confirmer'])) {
    error_log("confirm : " . print_r($_POST, 1));
    $name = $_POST['name'];
    $Status = $_POST['nouveauStatus'];
    $id = $_POST['id'];


    if (empty($name)) {
        $errorMessage = "le champs Nom est requis";
    } else {
        $requeteEdit = "UPDATE tblcategory SET CategoryName =:CategoryName, Status =:Status WHERE id =:id";
        $query = $conn->prepare($requeteEdit);
        $query->bindParam(":CategoryName", $name);
        $query->bindParam(":Status", $Status);
        $query->bindParam(":id", $id);
        $query->execute();
    }
}


?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Categories</title>
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
    <!-- On affiche le titre de la page "Editer la categorie-->
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <h4 class="header-line">Editer la categorie</h4>
            </div>
        </div>
        <!-- On affiche le formulaire dedition-->
        <div class='m-4'>
            <div class=''>
                <!-- On affiche ici le formulaire d'édition -->
                <form class="" action="edit-category.php" method="POST" class="">


                    <div>
                        <label for="name">Nouveau Nom</label>
                        <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
                        <input class="form-control" type="text" name="name" value="<?php echo $_POST['name'] ?>">
                    </div>
                    <div class="mb-5 mt-4">
                        <span class='fw-bold'>Nouveau status</span>
                        <div class='form-group'>

                            <?php if ($_POST['Status'] == 1) { ?>

                                <input type="hidden" name="Status" value="<?php echo $_POST['Status'] ?>">
                                <input class='' type="radio" name="nouveauStatus" id='1' value='1' checked />
                                <label for="name">Active</label>
                        </div>
                        <div class='form-group'>

                            <input class='' type="radio" name="nouveauStatus" id='0' value='0'>
                            <label for='name'>Inactive</label>
                        </div>
                        <span style="color:red"><?= $errorMessage ?></span>
                        <div>
                            <button class="border-0 bg-info" name="confirmer" type="submit">Confirmer</button>
                        </div>
                    </div>






                <?php
                            } else {

                ?>
                    <div class='form-group'>
                        <input type="hidden" name="Status" value="<?php echo $_POST['Status'] ?>">
                        <input class='' type="radio" name="nouveauStatus" id='1' value='1' />
                        <label for="name">Active</label>
                    </div>
                    <div class='form-group'>
                        <input class='' type="radio" name="nouveauStatus" id='0' value='0' checked>
                        <label for='name'>Inactive</label>
                    </div>
                    <span><?= $errorMessage ?></span>
                    <div>
                        <button class="border-0 bg-info" name="confirmer" type="submit">Confirmer</button>
                    </div>

                </form>
            </div>
        <?php
                            }

        ?>


        <!-- Si la categorie est active (status == 1)-->
        <!-- On coche le bouton radio "actif"-->
        <!-- Sinon-->
        <!-- On coche le bouton radio "inactif"-->

        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>