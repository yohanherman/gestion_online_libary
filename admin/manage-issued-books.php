<?php
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {

    header('location:../index.php');
} else {

    $requete = "SELECT tblissuedbookdetails.id ,tblreaders.FullName, tblbooks.BookName ,tblbooks.ISBNNumber, tblissuedbookdetails.IssuesDate ,tblissuedbookdetails.ReturnDate FROM tblissuedbookdetails JOIN tblreaders ON tblissuedbookdetails.ReaderID = tblreaders.ReaderId  JOIN tblbooks ON tblissuedbookdetails.BookId = tblbooks.ISBNNumber ";
    $stmt = $conn->prepare($requete);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $compteur = 1;

    // var_dump($results);
}



?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion des sorties</title>
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

    <div class="mt-3">
        <div>
            <div>
                <h3> GESTION DES SORTIES</h3>
            </div>
        </div>
    </div>
    <hr>
    <div class="border border-secondary m-3">
        <div class="p-2 bg-secondary text-white">Sorties</div>
        <div class="m-3">
            <table class="table table-striped">
                <tr>
                    <td class="font-weight-bold">#</td>
                    <td class="font-weight-bold">Lecteur</td>
                    <td class="font-weight-bold">Titre</td>
                    <td class="font-weight-bold">ISBN</td>
                    <td class="font-weight-bold">Sortie le</td>
                    <td class="font-weight-bold">Retourné le</td>
                    <td class="font-weight-bold">Action</td>


                    <?php foreach ($results as $result) { ?>

                </tr>

                <!-- <td><= $result['id'] ?></td> -->
                <td><?= $compteur++ ?></td>
                <td><?= $result['FullName'] ?></td>
                <td><?= $result['BookName'] ?></td>
                <td><?= $result['ISBNNumber'] ?></td>
                <td><?= $result['IssuesDate'] ?></td>
                <td><?php if ($result['ReturnDate'] == "" || $result['ReturnDate'] == null || $result['ReturnDate'] == "0000-00-00 00:00:00") {

                    ?>
                        <span class="text-danger">Non Retourné</span>

                    <?php
                        } else {

                    ?>
                        <span><?= $result['ReturnDate'] ?></span>
                    <?php
                        }
                    ?>
                </td>

                <td>
                    <form action="edit-issue-book.php" method="POST">
                        <input type="hidden" name="id" value="<?= $result['id'] ?>">
                        <input type="hidden" name="title" value="<?= $result["BookName"] ?>">
                        <input type="hidden" name="ReturnDate" value="<?= $result['ReturnDate'] ?>">
                        <input type="hidden" name="auteur" value="<?= $result['FullName'] ?>">
                        <button type="submit" name="editer" class=" border-0 bg-info rounded p-2 text-white ">&#9998; Editer</button>

                    </form>
                </td>

            <?php
                    }

            ?>


            <tr>


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