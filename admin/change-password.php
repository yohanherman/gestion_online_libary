<?php
session_start();

include('includes/config.php');

if (strlen($_SESSION["alogin"]) == 0) {
	// Si l'utilisateur n'est plus logué
	// On le redirige vers la page de login
	header("location:../index.php");
} else {
	// Sinon on peut continuer. Après soumission du formulaire de modification du mot de passe
	if (isset($_POST["creer"])) {
		// Si le formulaire a bien ete soumis

		// On recupere le nom de l'utilisateur stocké dans $_SESSION
		// error_log($_SESSION["alogin"]);
		$nomgardeEnSessionlorsConnexion = $_SESSION["alogin"];

		error_log($nomgardeEnSessionlorsConnexion);

		// On recupere le mot de passe courant
		$passwordActuel = $_POST["presentpass"];
		// On recupere le nouveau mot de passe
		$newpass = $_POST["newpass"];

		$passhashed = password_hash($newpass, PASSWORD_ARGON2ID);

		error_log($passwordActuel);
		// error_log($newpass);
		error_log($passhashed);


		// On prepare la requete de recherche pour recuperer l'id de l'administrateur (table admin)
		// dont on connait le nom et le mot de passe actuel
		// On execute la requete

		// Si on trouve un resultat
		// On prepare la requete de mise a jour du nouveau mot de passe de cet id

		$requete1 = "SELECT id FROM admin WHERE UserName = '$nomgardeEnSessionlorsConnexion'";

		error_log("SELECT id FROM admin WHERE UserName = '$nomgardeEnSessionlorsConnexion'");

		$query = $conn->prepare($requete1);
		$query->execute();

		$result = $query->fetch(PDO::FETCH_OBJ);
		error_log(print_r($result, 1));

		// On execute la requete

		$requete = "UPDATE admin SET Password =:Passwordchange WHERE id = $result->id ";
		$query = $conn->prepare($requete);
		$query->bindParam(":Passwordchange", $passhashed);

		// $query->bindParam(":Passwordhashed", $passwordActuel);
		$query->execute();
		error_log($query->execute());
	}
}





// On stocke un message de succès de l'operation
// On purge le message d'erreur
// Sinon on a trouve personne	
// On stocke un message d'erreur

// Sinon le formulaire n'a pas encore ete soumis
// On initialise le message de succes et le message d'erreur (chaines vides)
?>

<!DOCTYPE html>
<html lang="FR">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Gestion bibliotheque en ligne</title>
	<!-- BOOTSTRAP CORE STYLE  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- FONT AWESOME STYLE  -->
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLE  -->
	<link href="assets/css/style.css" rel="stylesheet" />
	<!-- Penser a mettre dans la feuille de style les classes pour afficher le message de succes ou d'erreur  -->
</head>
<script type="text/javascript">
	// On cree une fonction JS valid() qui renvoie
	// true si les mots de passe sont identiques
	// false sinon

	// document.addEventListener("DOMContentLoaded", () => {

	// })
</script>

<body>
	<!------MENU SECTION START-->
	<?php include('includes/header.php'); ?>
	<!-- MENU SECTION END-->
	<!-- On affiche le titre de la page "Changer de mot de passe"  -->
	<div class="mt-3 mb-4">
		<div>
			<div>
				<h3>CHANGER LE MOT DE PASSE DE L'UTILISATEUR COURANT</h3>
			</div>
		</div>
	</div>
	<!-- On affiche le message de succes ou d'erreur  -->

	<div class="border border-info rounded m-4">

		<div class="bg-info text-white p-2">Changer le mot de passe</div>
		<div class="p-3">
			<form action="change-password.php" method="POST">
				<div class="form-group">
					<label class="form-label font-weight-bold" for="presentpass">Mot de passe actuel</label>
					<input class="form-control" type="text" name="presentpass" id="presentpass">
				</div>

				<div class="form-group">
					<label class="form-label font-weight-bold" for="newpass">Nouveau mot de passe</label>
					<input class="form-control" type="text" name="newpass" id="newpass">
				</div>

				<div class="form-group">
					<label class="form-label font-weight-bold" for="newpassconfirm">confirmer le mot de passe </label>
					<input class="form-control" type="text" name="newpass" id="newpassconfirm">
				</div>
				<span class="message"></span>
				<div class="mt-3">
					<button class="border-0 text-white rounded bg-info btnverif" type="submit" name="creer">Change</button>
				</div>
			</form>
		</div>
	</div>
	<!-- On affiche le formulaire de changement de mot de passe-->
	<!-- La fonction JS valid() est appelee lors de la soumission du formulaire onSubmit="return valid();" -->

	<!-- CONTENT-WRAPPER SECTION END-->
	<?php include('includes/footer.php'); ?>
	<!-- FOOTER SECTION END-->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="script3.js"></script>
</body>

</html>