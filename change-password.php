<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include("includes/config.php");

// Si l'utilisateur n'est pas logue, on le redirige vers la page de login (index.php)
if (!$_SESSION["login"]) {

	header("location:index.php");
}

// sinon, on peut continuer,


if (isset($_POST["change"])) {

	// $presentPassWord = $_POST["presentPassword"];

	// $cherche = "SELECT EmailId FROM tblreaders WHERE Password =:presentPassword";

	$newPassword = $_POST["newPassword"];
	$presentPassword = $_POST["presentPassword"];
	$passwordHasheh = password_hash($presentPassword, PASSWORD_ARGON2ID);

	$requete = " UPDATE tblreaders SET Password =:newPassword WHERE Password =:PresentPasswordhashed";

	$query = $dbh->prepare($requete);

	$query->bindParam(":PresentPasswordhashed", $passwordHasheh);


	$query->execute();
	// $query->bindParam(":EmailId", $email);


	// $query->execute();
}
// si le formulaire a ete envoye : $_POST['change'] existe
// On recupere le mot de passe et on le crypte (fonction php password_hash)
// On recupere l'email de l'utilisateur dans le tabeau $_SESSION
// On cherche en base l'utilisateur avec ce mot de passe et cet email
// Si le resultat de recherche n'est pas vide
// On met a jour en base le nouveau mot de passe (tblreader) pour ce lecteur
// On stocke le message d'operation reussie
// sinon (resultat de recherche vide)
// On stocke le message "mot de passe invalide"

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<title>Gestion de bibliotheque en ligne | changement de mot de passe</title>
	<!-- BOOTSTRAP CORE STYLE  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- FONT AWESOME STYLE  -->
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLE  -->
	<link href="assets/css/style.css" rel="stylesheet" />

	<!-- Penser au code CSS de mise en forme des message de succes ou d'erreur -->

</head>
<script type="text/javascript">
	/* On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques 
	Cette fonction retourne un booleen*/
</script>

<body>
	<!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
	<?php include('includes/header.php'); ?>
	<!--On affiche le titre de la page : CHANGER MON MOT DE PASSE-->
	<div class="container">
		<div class="row">
			<div class="col">
				<h3>CHANGER LE MOT DE PASSE</h3>
			</div>
		</div>
	</div>
	<div class="containerForm d-flex justify-content-center align-items-center">
		<form action="change-password.php" method="POST" class=" col-lg-10 col-md-10 col-sm-10">

			<div>
				<label for="presentPassword" class="form-label">Mot de passe actuel</label>
				<input class="form-control" type="password" name="presentPassword" id="presentPassword">
			</div>

			<div>
				<label for="newPassword" class="form-label">Nouveau mot de passe</label>
				<input class="form-control" type="password" name="newPassword" id="newPassword">
			</div>

			<div>
				<label for="confirmPassWord" class="form-label">Confirmer le mot de passe</label>
				<input class="form-control" type="password" name="confirmPassWord" id="confirmPassWord">
			</div>

			<div>
				<button type="submit" name="change">Changer</button>
			</div>
		</form>
	</div>
	<!--  Si on a une erreur, on l'affiche ici -->
	<!--  Si on a un message, on l'affiche ici -->

	<!--On affiche le formulaire-->


	<!-- la fonction de validation de mot de passe est appelee dans la balise form : onSubmit="return valid();"-->


	<?php include('includes/footer.php'); ?>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>