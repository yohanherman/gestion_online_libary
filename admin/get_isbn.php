<?php

include("includes/config.php");

$isbn = $_POST["isbn"];

$requete = "SELECT * FROM tblbooks WHERE ISBNNumber =:ISBNNumber";
$query = $conn->prepare($requete);
$query->bindParam(":ISBNNumber", $isbn);
$query->execute();
$results = $query->fetchAll();


if ($query->rowCount() > 0) {
?>
    <div class="text-danger"><?php echo "ISBN deja existant" ?></div>

<?php
}

error_log(print_r($results, 1));
