<?php

function getResult()
{
    session_start();

    // error_log(print_r($_SESSION, 1));

    // echo $_SESSION["vercode"];
    // echo $_SESSION["emaill"];

    // On inclue le fichier de configuration et de connexion à la base de données
    include("includes/config.php");


    // Si l'utilisateur n'est plus logué
    if (!$_SESSION["login"]) {
        // On le redirige vers la page de login
        header("location:index.php");
    }
    // Sinon on peut continuer. Après soumission du formulaire de profil

    // On recupere l'id du lecteur (cle secondaire)


    // On recupere le nom complet du lecteur

    // On recupere le numero de portable

    // On update la table tblreaders avec ces valeurs
    // On informe l'utilisateur du resultat de l'operation


    // On souhaite voir la fiche de lecteur courant.
    // On recupere l'id de session dans $_SESSION

    // On prepare la requete permettant d'obtenir 
    if (isset($_POST["updatepro"])) {

        $fullName = $_POST['fullName'];
        $Mobile = $_POST['MobileNumber'];
        $mail = $_POST['EmailId'];
        $idreader = $_POST["id"];

        // $request = "UPDATE tblreaders SET FullName =:FullName , MobileNumber =:MobileNumber , EmailId =:EmailId WHERE ReaderId =:ReaderId";
        $request = "UPDATE tblreaders SET FullName =:FullName , MobileNumber =:MobileNumber , EmailId =:EmailId WHERE ReaderId =:ReaderId";

        $query = $dbh->prepare($request);
        $query->bindParam(':FullName', $fullName, PDO::PARAM_STR);
        $query->bindParam(':MobileNumber', $Mobile, PDO::PARAM_INT);
        $query->bindParam(':EmailId', $mail, PDO::PARAM_STR);
        $query->bindParam(':ReaderId', $idreader, PDO::PARAM_STR);
        $query->execute();
        header('location:my-profile.php');
        // error_log("update done");
    }


    // partie pour recuperer et afficher les elements sur ma page

    $email = $_SESSION["login"];

    $requete = "SELECT ReaderId,RegDate,UpdateDate,FullName,MobileNumber,EmailId ,Status FROM tblreaders WHERE EmailId= :Email";
    $query = $dbh->prepare($requete);
    $query->bindParam(":Email", $email);
    $query->execute();
    $results = $query->fetchAll();

    return $results;
}
