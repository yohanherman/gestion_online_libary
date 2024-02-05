<?php
session_start();

include('includes/config.php');

if (strlen($_SESSION["alogin"]) == 0) {

    header("location:../index.php");
} else {

    $errorMessage = "";

    if (isset($_POST['creer']) == TRUE) {

        $lecteurind = $_POST["identifiantLec"];
        $ISBN = $_POST["isbn"];

        if (empty($lecteurind) || empty($ISBN)) {
            $errorMessage = "champs requis";
        } else {

            $requete = "INSERT INTO tblissuedbookdetails (BookId ,ReaderID) VALUES (:ISBN, :ReaderID)";
            $stmt = $conn->prepare($requete);
            $stmt->bindParam(':ISBN', $ISBN);
            $stmt->bindParam(':ReaderID', $lecteurind);
            $stmt->execute();

            header("location:manage-issued-books");

            if ($stmt->rowCount() > 0) {
                // $_SESSION["message"]=""
                echo '<script>alert("ajouter avec succes")</script>';
            }
        }
    }
}



?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Ajout de sortie</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <script>
        // On crée une fonction JS pour récuperer le nom du lecteur à partir de son identifiant

        // On crée une fonction JS pour recuperer le titre du livre a partir de son identifiant ISBN

        // document.addEventListener("DOMContentLoaded", activer());

        // function activer() {
        //     let btn = document.querySelector("#btn")
        //     btn.disabled = false;

        // }

        // function recupLivre() {
        //     let titrelivre = document.querySelector("#isbn").value;

        //     const xmlhttp = new XMLHttpRequest();
        //     xmlhttp.onreadystatechange = function() {
        //         if (this.readyState == 4 && this.status == 400) {
        //             document.querySelector(".containerHTML2").innerHTML = this.responseText;
        //         }
        //     }

        //     xmlhttp.open("POST", "get_book.php", true);
        //     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //     xmlhttp.send('isbn=' + titrelivre);
        // }
    </script>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="mt-4">
        <div>
            <div>
                <h3>SORTIE D'UN LIVRE</h3>
            </div>
        </div>
    </div>

    <!-- Dans le formulaire du sortie, on appelle les fonctions JS de recuperation du nom du lecteur et du titre du livre 
 sur evenement onBlur-->
    <div class="border border-info m-2 rounded mb-5 mt-5">
        <div class="bg-info p-2 text-white">Sortie d'un livre</div>
        <div class="p-3">
            <form action="add-issue-book.php" method="POST">
                <div class="form-group">
                    <label class="form-label font-weight-bold" for="identifiantLec">identifiant lecteur<span class="text-danger">*</span></label>
                    <input type="text" class="form-control identifiant" name="identifiantLec" id="identifiant" onblur="recuplecteur()">
                    <span class="containerHTML"></span>
                </div>

                <div class="form-group">
                    <label class="form-label font-weight-bold" for="isbn">ISBN<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="isbn" id="isbn" onblur="recupLivre()">
                    <span class="containerHTML2"></span>
                </div>
                <span class="text-danger "><?= $errorMessage ?></span>
                <div>
                    <button type="submit" class="border-0 bg-info rounded text-white mt-3" id="btn" name="creer">Creer la sortie</button>
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