<?php
// On demarre ou on recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// On invalide le cache de session $_SESSION['alogin'] = ''
if (isset($_SESSION['alogin']) && $_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}

// A faire :

// Apres la soumission du formulaire de login (plus bas dans ce fichier)
if (isset($_POST["alogin"])) {


    // On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
    // $_POST["vercode"] et la valeur initialis�e $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas

    if ($_SESSION["vercode"] != $_POST["vercode"]) {
        echo "<script>alert('code de verification incorrect')</script>";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('email non valid')</script>";
    } else {
        // Le code est correct, on peut continuer
        // On recupere le nom de l'utilisateur saisi dans le formulaire
        // On recupere le mot de passe saisi par l'utilisateur et on le crypte (fonction md5)
        $name = strip_tags($_POST["name"]);
        $Email = strip_tags($_POST["email"]);
        $password = strip_tags($_POST["password"]);
        $verification = $_POST["vercode"];

        // On construit la requete qui permet de retrouver l'utilisateur a partir de son nom et de son mot de passe
        // depuis la table admin

        $cherche = "SELECT UserName , Password FROM admin WHERE UserName =:UserName";
        $query = $dbh->prepare($cherche);
        $query->bindParam(':UserName', $name);
        // $query->bindParam(':AdminEmail', $Email);
        $query->execute();

        $result = $query->fetch();

        // Si le resultat de recherche n'est pas vide 
        if (!empty($result) && password_verify($_POST["password"], $result["Password"])) {
            // On stocke le nom de l'utilisateur  $_POST['username'] en session $_SESSION

            $_SESSION['alogin'] = $_POST["name"];
            // $_SESSION['username'] = $result['UserName'];
            // $_SESSION['username'] = $result["UserName"];    


            header("location:admin/dashboard.php");
            // echo "ok c'est bon";
            exit;
        } else {
            echo "<script>alert('acces refusé')</script>";
        }
    }
}




// On redirige l'utilisateur vers le tableau de bord administration (n'existe pas encore)

// sinon le login est refuse. On le signal par une popup

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
    <?php include('includes/header.php'); ?>

    <div class="content-wrapper">
        <!--On affiche le titre de la page-->
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3>ADMIN LOGIN</h3>
                </div>
            </div>
        </div>

        <!--On affiche le formulaire de login-->
        <div class="containerForm col-lg-8 col-md-10 col-sm-12 ">
            <form action="adminlogin.php" method="POST">
                <div class="form-group">
                    <label for="name">nom</label>
                    <input class="form-control" type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">votre Email</label>
                    <input class="form-control" type="email" name="email">
                </div>

                <div class="form-group">
                    <label for="email">votre mot de passe</label>
                    <input class="form-control" type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>code de verification</label>
                    <input type="text" name="vercode" required style="height:25px;">&nbsp;&nbsp;&nbsp;<img src="captcha.php">
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-12 mt-5">
                    <button type="submit" name="alogin" class="btn-block btn btn-info">se connecter</button>
                </div>
            </form>
        </div>

        <!--A la suite de la zone de saisie du captcha, on ins�re l'image cr��e par captcha.php : <img src="captcha.php">  -->
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>