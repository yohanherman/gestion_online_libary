<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('includes/config.php');

// Si l'utilisateur est déconnecté

if (strlen($_SESSION['alogin']) == 0) {
    // L'utilisateur est renvoyé vers la page de login : index.php
    header("location:../index.php");
} else {
    // On recupere l'identifiant de la catégorie a supprimer

    $requete1 = "SELECT id ,CategoryName ,Status, CreationDate, UpdationDate FROM tblcategory";

    $query = $conn->prepare($requete1);

    $query->execute();

    $result1 = $query->fetchAll();

    // compteur pour les identifiant;

    $compteur = 1;
}

// On prepare la requete de suppression

if (isset($_POST["delete"])) {
    error_log($_POST["Status"]);
    $id = $_POST["id"];
    $status = $_POST["Status"];

    if ($status == 1) {

        $requetemodifstatus = "UPDATE tblcategory SET Status = 0 WHERE id = :id ";
        $stmt = $conn->prepare($requetemodifstatus);
        // $stmt->bindParam(":Status", $status);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    } elseif ($status == 0) {

        $requetemodifstatus = "UPDATE tblcategory SET Status = 1 WHERE id = :id ";
        $stmt = $conn->prepare($requetemodifstatus);
        // $stmt->bindParam(":Status", $status);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
    header("location:manage-categories.php");



    // $stmt->execute();

    // $requeteSuppr = "DELETE FROM tblcategory WHERE id = :id ";
    // $stmt = $conn->prepare($requeteSuppr);
    // $stmt->bindParam(':id', $id);

    // $stmt->execute();

    // if ($stmt->rowCount() < 0) {

    //     echo '<script>alert("effacer avec succes")</script>';
    // }
}



// On execute la requete

// On informe l'utilisateur du resultat de loperation

// On redirige l'utilisateur vers la page manage-categories.php

?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion categories</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <!-- On affiche le titre de la page-->
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h3>GESTION DE CATEGORIES</h3>
            </div>
        </div>
    </div>
    <br>

    <!-- On prevoit ici une div pour l'affichage des erreurs ou du succes de l'operation de mise a jour ou de suppression d'une categorie-->

    <!-- On affiche le formulaire de gestion des categories-->

    <div class="containerGestion border border-secondary  p-3 m-3 col-lg-12 col-md-12 col-sm-12">
        <div class="category p-2 ">categories</div>

        <table class="w-100 table table-striped">

            <tr>
                <td class="entete">#</td>
                <td class="entete">Nom</td>
                <td class="entete">Statut</td>
                <td class="entete">Cree le</td>
                <td class="entete">Mise a jour le </td>
                <td class="entete">Action</td>
            </tr>

            <?php

            foreach ($result1 as $result) {

            ?>
                <tr>
                    <td><?= $compteur++ ?></td>
                    <!-- <td><= $result["id"] ?></td> -->
                    <td><?= $result["CategoryName"] ?></td>
                    <td><?php if ($result["Status"] == 1) {

                        ?>
                            <span class="colorStatusActive">Active</span>

                        <?php

                        } else {

                        ?>
                            <span class="colorStatusInactive ">Inactive</span>
                        <?php
                        }

                        ?>
                    </td>

                    <td><?= $result["CreationDate"] ?></td>
                    <td><?= $result["UpdationDate"] ?></td>

                    <!-- <td>
                        <form action="manage-categories.php" method="POST">
                            <input type="hidden" name='id' value="<php echo $result['id'] ?>">
                            <a class="editer" href="edit-category.php"><span>&#10002;</span> Editer</a> <button type="submit" name="delete" class="supprimer">&#10008;supprimer</button>
                        </form>

                    </td> -->

                    <td class="d-flex">
                        <form action="manage-categories.php" method="POST" class="mr-2">
                            <input type="hidden" name='id' value="<?php echo $result['id'] ?>">
                            <input type="hidden" name='Status' value="<?php echo $result['Status'] ?>">
                            <button type="submit" name="delete" class="border-0 bg-danger rounded p-2">&#10008;supprimer</button>
                        </form>


                        <form action="edit-category.php" method="POST">
                            <input type="hidden" name='id' value="<?php echo $result['id'] ?>">
                            <input type="hidden" name="name" value="<?php echo $result['CategoryName'] ?>">
                            <input type="hidden" name="Status" value="<?php echo $result['Status'] ?>">
                            <div>
                                <button type="submit" name="editer" class="border-0 bg-primary rounded p-2">&#9998;editer</button>
                            </div>

                        </form>

                    </td>

                <?php

            }
                ?>
                </tr>


        </table>

    </div>


    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>