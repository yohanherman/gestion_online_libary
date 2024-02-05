<?php

// On récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

// Si l'utilisateur n'est pas connecte, on le dirige vers la page de login
if (!$_SESSION["login"]) {
    header("location:index.php");
}

// Sinon on peut continuer
//	Si le bouton de suppression a ete clique($_GET['del'] existe)
//On recupere l'identifiant du livre
// On supprime le livre en base
// On redirige l'utilisateur vers issued-book.php
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Gestion des livres</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="./assets/css/style.css" rel="stylesheet" />
    <link href="style2.css" rel="stylesheet" />

</head>

<body>
    <!--On insere ici le menu de navigation T-->
    <?php include('includes/header.php'); ?>
    <!-- On affiche le titre de la page : LIVRES SORTIS -->
    <div class="containerForm d-flex justify-content-center align-items-center">
        <div class="row">
            <h3 class="ttt mb-4 mt-5">LIVRES EMPRUNTES</h3>
        </div>
    </div>

    <!-- On affiche la liste des sorties contenus dans $results sous la forme d'un tableau -->

    <div class="containerForm d-flex justify-content-center align-items-center mb-5 ml-3 mr-3">
        <table>
            <tr>
                <td class="entete">#</td>
                <td class="entete">Titre</td>
                <td class="entete">ISBN</td>
                <td class="entete">Date de sortie</td>
                <td class="entete">Date de retour</td>
            </tr>

            <?php

            $requete = " SELECT e.id , e.BookName , e.ISBNNumber , a.IssuesDate , a.ReturnDate FROM tblbooks e , tblissuedbookdetails a WHERE e.ISBNNumber = a.BookId";
            $query = $dbh->prepare($requete);
            $query->execute();

            $results = $query->fetchAll();

            foreach ($results as $result) {

            ?>
                <tr class="backgroundrow">
                    <td><?php echo $result['id'] ?></td>
                    <td><?php echo $result['BookName'] ?></td>
                    <td><?php echo $result['ISBNNumber'] ?></td>
                    <td><?php echo $result['IssuesDate'] ?></td>

                    <?php
                    if (!$result["ReturnDate"]) {

                    ?>

                        <td style="color:red"><?php echo "Non retourné" ?></td>
                    <?php

                    } else {

                    ?>

                        <td><?php echo $result['ReturnDate'] ?></td>

                    <?php

                    }

                    ?>
                </tr>

            <?php
            }

            ?>

        </table>
    </div>


    <!-- Sinon on peut continuer -->


    <!-- Si il n'y a pas de date de retour, on affiche non retourne -->


    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>