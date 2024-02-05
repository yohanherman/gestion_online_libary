<?php
session_start();

include("includes/config.php");

$isbn = $_POST["isbn"];

$requete = "SELECT BookName FROM tblbooks WHERE ISBNNumber =:ISBNNumber";

$query = $conn->prepare($requete);

$query->bindParam(":ISBNNumber", $isbn);

$query->execute();
$results = $query->fetch();

// error_log(print_r($results, 1));

if ($query->rowCount() > 0) {
?>

	<div class="m-3"> <?= $results['BookName'] ?></div>

<?php
}

/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero ISBN du livre*/
// On prepare la requete de recherche du livre correspondnat
// On execute la requete
// Si un resultat est trouve
// On affiche le nom du livre
// On active le bouton de soumission du formulaire
// Sinon
// On affiche que "ISBN est non valide"
// On desactive le bouton de soumission du formulaire 
