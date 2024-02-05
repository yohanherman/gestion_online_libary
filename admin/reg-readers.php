<?php
// On démarre ou on récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

// Si l'utilisateur n'est logué ($_SESSION['alogin'] est vide)
// On le redirige vers la page d'accueil

if (isset($_SESSION["alogin"]) == 0) {
    header("location:../index.php");
} else {
    // Sinon on affiche la liste des lecteurs de la table tblreaders

    $requete = "SELECT id , ReaderId ,FullName ,EmailId,MobileNumber, RegDate, Status FROM tblreaders";
    $query = $conn->prepare($requete);
    $query->execute();
    $results = $query->fetchAll();
    $compteur = 1;

    // error_log(print_r($results, 1));

    if (isset($_POST["desactiver"]) == TRUE) {

        $id = $_POST["id"];
        $status = $_POST["status"];
        //     error_log($id);
        //     error_log($status);

        $requete1 = "UPDATE tblreaders SET Status = 0 WHERE id =:id ";
        $stmt = $conn->prepare($requete1);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        header("location:reg-readers.php");
    } elseif (isset($_POST["activer"]) == TRUE) {

        $id = $_POST["id"];
        $status = $_POST["status"];

        error_log($id);
        error_log($status);

        $requete2 = "UPDATE tblreaders SET Status = 1 WHERE id =:id";
        $stmt1 = $conn->prepare($requete2);
        $stmt1->bindParam("id", $id);
        $stmt1->execute();
        header("location:reg-readers.php");
    } elseif (isset($_POST["supprimer"])) {

        $id = $_POST["id"];
        $status = $_POST["status"];

        error_log($id);
        error_log($status);

        $requete3 = "UPDATE tblreaders SET Status = 2 WHERE id =:id";
        $stmt2 = $conn->prepare($requete3);
        $stmt2->bindParam("id", $id);
        $stmt2->execute();
        header("location:reg-readers.php");
    }
}



// Lors d'un click sur un bouton "inactif", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['inid']
// et on met à jour le statut (0) dans la table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "actif", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['id']
// et on met à jour le statut (1) dans  table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "supprimer", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['del']
// et on met à jour le statut (2) dans la table tblreaders pour cet identifiant de lecteur

// On récupère tous les lecteurs dans la base de données
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Reg lecteurs</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!--On inclue ici le menu de navigation includes/header.php-->
    <?php include('includes/header.php'); ?>
    <!-- Titre de la page (Gestion du Registre des lecteurs) -->
    <div class="mt-3">
        <div>
            <div>
                <h3>GESTION DU REGISTRE DES LECTEURS</h3>
            </div>
        </div>
        <hr>
    </div>
    <div class="border border-secondary m-3">
        <div class="bg-secondary p-3 text-white">Registre lecteurs</div>
        <div class="p-3">
            <table class="table table-striped">
                <tr>
                    <td class="font-weight-bold">#</td>
                    <td class="font-weight-bold">ID Lecteurs</td>
                    <td class="font-weight-bold">Nom</td>
                    <td class="font-weight-bold">Email</td>
                    <td class="font-weight-bold">Portable</td>
                    <td class="font-weight-bold">Date de reg</td>
                    <td class="font-weight-bold">Status</td>
                    <td class="font-weight-bold">Action</td>
                </tr>


                <?php foreach ($results as $result) {
                ?>
                    <tr>
                        <!-- <td><= $result["id"] ?></td> -->
                        <td><?= $compteur++ ?></td>
                        <td><?= $result["ReaderId"] ?></td>
                        <td><?= $result["FullName"] ?></td>
                        <td><?= $result["EmailId"] ?></td>
                        <td><?= $result["MobileNumber"] ?></td>
                        <td><?= $result["RegDate"] ?></td>

                        <td><?php if ($result["Status"] == 1) { ?>

                                <span class="text-success">Actif</span>

                            <?php

                            } elseif ($result["Status"] == 0) { ?>

                                <span class="text-warning">bloqué(e)</span>

                            <?php

                            } elseif ($result["Status"] == 2) { ?>

                                <span class='text-danger'>Supprimé(e)</span>

                            <?php

                            } ?>

                        </td>
                        <td><?php if ($result["Status"] == 2) {
                                // quand le statut est 2 aucune action n'est possible
                            } elseif ($result["Status"] == 1) {

                            ?>
                                <form action="reg-readers.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $result["id"] ?>">
                                    <input type="hidden" name="status" value="<?php echo $result["Status"] ?>">
                                    <button type="submit" class="border-0 bg-warning rounded text-white p-2" name="desactiver">inactif</button>
                                    <button type="submit" class="border-0 bg-danger rounded text-white p-2" name="supprimer">supprimer</button>

                                </form>

                                <!-- <form action="deleteLecteur" method="POST">

                                    <input type="hidden" name="id" value="<php echo $result["id"] ?>">
                                    <input type="hidden" name="id" value="<php echo $result["Status"] ?>">
                                    <button type="submit" name="Supprimer">Supprimer</button>
                                </form> -->


                            <?php

                            } elseif ($result["Status"] == 0) {

                            ?>
                                <form action="reg-readers.php" method="POST">

                                    <input type="hidden" name="id" value="<?= $result["id"] ?>">
                                    <input type="hidden" name="status" value="<?php echo $result["Status"] ?>">
                                    <button class="bg-primary rounded border-0 text-white p-2" type="submit" name="activer">Actif</button>
                                    <button type="submit" class="bg-danger rounded border-0 text-white p-2" name="supprimer">supprimer</button>

                                </form>

                            <?php

                            } ?>


                        </td>

                    <?php

                }

                    ?>

                    </tr>

            </table>
        </div>
    </div>
    <!--On insère ici le tableau des lecteurs.
    
       On gère l'affichage des boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>