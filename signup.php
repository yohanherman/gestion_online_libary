<?php
// On récupère la session courante
session_start();


// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

// Aaprès la soumission du formulaire de compte (plus bas dans ce fichier)

$errorMessage = "";

if (isset($_POST['signup']) === TRUE) {

    //     On vérifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
    //     $_POST["vercode"] et la valeur initialisée $_SESSION["vercode"] lors de l'appel à captcha.php (voir plus bas)

    if ($_POST['vercode'] != $_SESSION['vercode']) {

        // echo "<script>alert('code de verification incoreecte')</script>";
        $errorMessage = "code de verification incorrecte ⚠️";
    } elseif (empty($_POST['FullName']) || empty($_POST['MobileNumber'])  || empty($_POST['EmailId']) || empty($_POST["password"])) {

        $errorMessage = "vous devez remplir tous les champs";
    } elseif (!filter_var($_POST["EmailId"], FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Cet Email n'est pas valide";
    } else {
        //On lit le contenu du fichier readerid.txt au moyen de la fonction 'file'. Ce fichier contient le dernier identifiant lecteur cree.
        $ressourceLue = file('readerid.txt');
        error_log(print_r($ressourceLue, 1));
        // On incrémente de 1 la valeur lue
        $ressourceIncr = ++$ressourceLue[0];
        error_log($ressourceIncr);
        // On ouvre le fichier readerid.txt en écriture
        $ressource = fopen('readerid.txt', 'c+b');
        // On écrit dans ce fichier la nouvelle valeur
        $write = fwrite($ressource, $ressourceIncr);
        // On referme le fichier
        fclose($ressource);
        // On récupère le nom saisi par le lecteur
        $fullName = $_POST['FullName'];
        // On récupère le numéro de portable
        $phoneNumber = $_POST['MobileNumber'];
        // On récupère l'email
        $email = $_POST['EmailId'];
        // On récupère le mot de passe
        $passWord = $_POST["password"];
        // On fixe le statut du lecteur à 1 par défaut (actif)
        $Status = 1;
        // On prépare la requete d'insertion en base de données de toutes ces valeurs dans la table tblreaders

        // $_SESSION['email'] = $_POST['EmailId'];





        $requeteSend = "INSERT INTO tblreaders(ReaderId,FullName,EmailId,MobileNumber,Password,Status) VALUES(:ReaderId,:FullName,:EmailId,:MobileNumber,:passwordhashed,1)";
        error_log($requeteSend);
        $query = $dbh->prepare($requeteSend);
        // d'abord je formate l'identifiant du lecteur avec le préfixe "SID" suivi du numéro incrémenté avec la methode STR_PAD();
        //$ReaderId = 'SID' . str_pad($write, 3, '0', STR_PAD_LEFT);
        $passhased = password_hash($passWord, PASSWORD_ARGON2ID);
        // On éxecute la requete
        $query->bindParam(':ReaderId', $ressourceIncr, PDO::PARAM_STR);
        $query->bindParam(':FullName', $fullName, PDO::PARAM_STR);
        $query->bindParam(':EmailId', $email, PDO::PARAM_STR);
        $query->bindParam(':MobileNumber', $phoneNumber, PDO::PARAM_INT);
        $query->bindParam(':passwordhashed', $passhased, PDO::PARAM_STR);
        $query->execute();
        header("location:index.php");
    }
}

// On récupère le dernier id inséré en bd (fonction lastInsertId)

// Si ce dernier id existe, on affiche dans une pop-up que l'opération s'est bien déroulée,
// et on affiche l'identifiant lecteur (valeur de $hit[0] après incrémentation)

// Sinon on affiche qu'il y a eu un problème
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Gestion de bibliotheque en ligne | Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="style2.css">

    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        // On cree une fonction valid() sans paramètre qui renvoie 
        // TRUE si les mots de passe saisis dans le formulaire sont identiques
        // FALSE sinon
        function valid() {

            // j'ai deplace ma fonction dans un fichier javascript separé
        }

        // On cree une fonction avec l'email passé en paramêtre et qui vérifie la disponibilité de l'email
        // Cette fonction effectue un appel fetch vers check_availability.php
        // Le mail est passé dans l'url

        // async function checkAvailability($email) {
        //     let response = await fetch('check_availability.php?EmailId=' + $email, {
        //         method: 'GET'
        //     });
        //     let data = await response.json();
        //     console.log(data);
        // }
    </script>
</head>

<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
    <?php include('includes/header.php'); ?>
    <!-- On affiche le titre de la page : CREER UN COMPTE (c'est ce que j'ai completé)-->
    <div class="container d-flex justify-content-center mb-3 mt-2">
        <div class="row">
            <div class="col">
                <h3>CREER UN COMPTE</h3>
            </div>
        </div>
    </div>
    <!--On affiche le formulaire de creation de compte-->
    <div class="containerForm d-flex justify-content-center align-items-center">
        <form action="signup.php" method="POST" class=" col-lg-10 col-md-10 col-sm-10">
            <div class="form-group">
                <label for="name" class="form-label">Entrer votre nom complet</label>
                <input type="text" name="FullName" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="number" class="form-label">Portable:</label>
                <input type="text" name="MobileNumber" id="number" class="form-control">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="text" name="EmailId" id="email" class="form-control" onblur="checkAvailability()">
            </div>

            <div class="form-group">
                <label for="Password" class="form-label">Mot de passe:</label>
                <input type="password" name="password" id="Password" class="form-control">
            </div>

            <div class="form-group">
                <label for="PasswordConfirm" class="form-label">confirmez le mot de passe:</label>
                <input type="text" name="PasswordConfirm" id="PasswordConfirm" class="form-control">
            </div>

            <div class="form-group">
                <label>Code de vérification</label>
                <input type="text" name="vercode" required style="height:25px;" class="">&nbsp;&nbsp;&nbsp;<img src="captcha.php">
            </div>
            <div class="containerError d-flex justify-content-center align-items-center">
                <span class="error"><?php echo $errorMessage; ?></span>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 mt-5">
                <button name="signup" class="btn btn-danger enregister btn-block mb-5">ENREGISTRER</button>
            </div>
        </form>

        <div id="messageaffichage"></div>
    </div>
    <!--A la suite de la zone de saisie du captcha, on insère l'image créée par captcha.php : <img src="captcha.php">  -->
    <!-- On appelle la fonction valid() dans la balise <form> onSubmit="return valid(); -->
    <!-- On appelle la fonction checkAvailability() dans la balise <input> de l'email onBlur="checkAvailability(this.value)" -->



    <?php include('includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>