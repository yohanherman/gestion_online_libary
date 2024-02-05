<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Profil</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
    <?php include('includes/header.php'); ?>
    <!--On affiche le titre de la page : EDITION DU PROFIL-->
    <div class="container mb-3">
        <div class="row">
            <h3 class="col mt-3">MON COMPTE</h3>

        </div>

    </div>

    <!--On affiche le formulaire-->
    <?php
    // $email = $_SESSION["login"];

    // $requete = "SELECT ReaderId,RegDate,UpdateDate,FullName,MobileNumber,EmailId ,Status FROM tblreaders WHERE EmailId= :Email";
    // $query = $dbh->prepare($requete);
    // $query->bindParam(":Email", $email);
    // $query->execute();
    // $results = $query->fetchAll();

    foreach ($results as $result) {

    ?>
        <div class="container">
            <p>Identifiant : <?php echo $result["ReaderId"] ?></p>
            <p> Date d'enregistrement : <?= $result["RegDate"] ?></p>
            <p>Derniere mise a jour : <?= $result["UpdateDate"] ?></p>
            <p>Statut : <?php if ($result["Status"] === 1) {
                        ?> <span style="color:green">Actif</span>
                <?php

                        } else {
                ?>
                    <span style="color:red">Inactif</span>

                <?php
                        }
                ?>
            </p>

            <form action="my-profile.php" method="POST">
                <div>
                    <label class="form-label " for="">Nom Complet :</label>
                    <input class="form-control" type="text " name="fullName" value="<?= $result['FullName'] ?>">
                </div>

                <div>
                    <label class="form-label" for="">Numero portable :</label>
                    <input class='form-control' type="text " name="MobileNumber" value="<?= $result['MobileNumber'] ?>">
                </div>

                <div>
                    <label class="form-label" for="EmailId">Email :</label>
                    <input class="form-control" name="EmailId" type="email" value="<?= $result['EmailId'] ?>">
                </div>
                <div>
                    <input class="form-control" name="id" type="hidden" value="<?= $result['ReaderId'] ?>">
                </div>
                <div>

                    <button class="btn btn-primary mt-3 col-lg-2 col-md-3 col-sm-8 mb-5" name="updatepro" type="submit" class="btnProfil">Mettre à jour</button>
                </div>
            </form>
        </div>


    <?php

    }
    ?>

    <!--On affiche l'identifiant - non editable-->

    <!--On affiche la date d'enregistrement - non editable-->

    <!--On affiche la date de derniere mise a jour - non editable-->

    <!--On affiche la statut du lecteur - non editable-->

    <!--On affiche le nom complet - editable-->

    <!--On affiche le numero de portable- editable-->

    <!--On affiche l'email- editable-->

    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>