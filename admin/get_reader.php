<?php
session_start();
include("includes/config.php");
error_log(print_r($_POST, 1));

/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero l'identifiant du lecteur SID---*/
// On prepare la requete de recherche du lecteur correspondnat

$readerId = $_POST["identifiant"];

$requete = "SELECT FullName FROM tblreaders WHERE ReaderId =:ReaderId ";
$stmt = $conn->prepare($requete);
$stmt->bindParam(':ReaderId', $readerId);
$stmt->execute();
$results = $stmt->fetch();

if ($stmt->rowCount() > 0) {

?>
	<div class="m-3"><?php echo $results["FullName"] ?></div>



<?php
}
// error_log(print_r($results, 1));







// On execute la requete
// Si un resultat est trouve
// On affiche le nom du lecteur
// On active le bouton de soumission du formulaire
// Sinon
// Si le lecteur n existe pas
// On affiche que "Le lecteur est non valide"
// On desactive le bouton de soumission du formulaire
// Si le lecteur est bloque
// On affiche lecteur bloque
// On desactive le bouton de soumission du formulaire
