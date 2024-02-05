<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logué

if (!$_SESSION["alogin"]) {
    // if(strlen($_SESSION["alogin"])){}

    // On le redirige vers la page de login
    header('location:../index.php');
} else {

    // Sinon on peut continuer. Après soumission du formulaire de creation
    // On recupere le nom et le statut de la categorie
    $errorMessage = "";

    if (isset($_POST["creer"])) {

        $name = $_POST['name'];
        $StatusState = $_POST['statusState'];

        error_log(print_r($_POST, 1));

        if (empty($name)) {
            $errorMessage = "veuillez remplir le champs Nom";
        } else {


            $requete1 = "INSERT INTO tblcategory(CategoryName , Status) VALUES (:CategoryName ,:Status)";

            $query = $conn->prepare($requete1);
            $query->bindParam(":CategoryName", $name);
            $query->bindParam(":Status", $StatusState);
            $query->execute();

            if ($query->rowCount() > 0) {
                echo " <script>alert('ajouter avec sucess')</script>";

                $_SESSION['messageSucces'] = "Categorie ajouter avec succes";
            }
        }
    }
}

//     error_log(print_r($_POST, 1));


// On prepare la requete d'insertion dans la table tblcategory
// On execute la requete
// On stocke dans $_SESSION le message correspondant au resultat de loperation
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
    <!-- MENU SECTION END-->
    <!-- On affiche le titre de la page-->
    <div class="mt-3">
        <div class="row">
            <div class="col">
                <h3>AJOUTER UNE CATEGORIE</h3>
            </div>
        </div>
    </div>
    <!-- On affiche le formulaire de creation-->

    <div class='m-5'>
        <form action="add-category.php" method="POST" class="border border-info ">

            <div class=" bg-info p-3 ">Information categories</div>

            <div class="form-group p-3">
                <label for="name" class="form-label ml-2 fw-bold">Nom</label>
                <input class="form-control ml-1 " type="text" name="name">
            </div>

            <div class="fw-bold p-3">Status</div>
            <div class="form-group pl-3 ">
                <div>
                    <input type="radio" name="statusState" id="1" value="1" checked />
                    <label for="active">Active</label>
                </div>
                <div>
                    <input type="radio" name="statusState" id="0" value="0">
                    <label for="inactive">Inactive</label>
                </div>
                <span class="m-4" style="color:red"><?= $errorMessage ?></span>
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <button class="btn btn-info btn-block mt-4" type="submit" name="creer">Creer</button>
                </div>
            </div>



        </form>
    </div>
    <!-- Par defaut, la categorie est active-->

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>