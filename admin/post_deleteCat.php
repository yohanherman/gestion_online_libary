<?php

session_start();

include("includes/config.php");


$id = $_POST['id'];

$requeteSuppr = "DELETE FROM tblcategory WHERE id = :id ";

$stmt = $conn->prepare($requeteSuppr);
$stmt->bindParam(":id", $id);
