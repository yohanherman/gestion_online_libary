<?php
// On récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');
// Après la soumission du formulaire de login ($_POST['change'] existe

if (isset($_POST['change'])) {

     // On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
     // $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)
     if ($_POST["vercode"] != $_SESSION['vercode']) {

          // Si le code est incorrect on informe l'utilisateur par une fenetre pop_up
          echo "<script>alert( 'code de verification incorrecte')</script>";
     } else {
          // Sinon on continue
          // on recupere l'email et le numero de portable saisi par l'utilisateur
          $email = $_POST['EmailId'];
          $number = $_POST['MobileNumber'];
          $password = $_POST['password'];
          // et le nouveau mot de passe que l'on encode (fonction password_hash)

          $newpasshashed = password_hash($password, PASSWORD_ARGON2ID);
          // On cherche en base le lecteur avec cet email et ce numero de tel dans la table tblreaders
          //      $requestSearch = "SELECT * FROM tblreaders WHERE EmailId=:? AND MobileNumber=:?" ;


          //      $query = $dbh->prepare($requestSearch);

          //      $query->execute([$email]);
          //      $result = $query->fetchColumn;

          //      if (!$result) {
          //           echo ("pas trouvé");
          //      } else {
          //           echo "correspondance";
          //      }

          // $query = $dbh->prepare($requestSearch);
          // $query->bindParam(':EmailId', $email);
          // $query->bindParam(':MobileNumber', $number);

          // $query->execute();
          // $result = $query->fetch();

          // }
     }

     $requestSearch = "UPDATE tblreaders SET Password =:Passwordhashed WHERE EmailId =:EmailId AND MobileNumber =:MobileNumber";

     $query = $dbh->prepare($requestSearch);
     $query->bindParam(':Passwordhashed', $newpasshashed, PDO::PARAM_STR);
     $query->bindParam(':EmailId', $email);
     $query->bindParam(':MobileNumber', $number);

     $resultat = $query->execute();

     if ($resultat) {
          echo "<script>alert('mot de passe changé')</script>";
     } elseif (!$resultat) {
          echo "<script>alert('probleme')</script>";
     }

     header("location:index.php");
}


// Si le resultat de recherche n'est pas vide
// On met a jour la table tblreaders avec le nouveau mot de passe
// On informa l'utilisateur par une fenetre popup de la reussite ou de l'echec de l'operation
?>

<!DOCTYPE html>
<html lang="FR">

<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

     <title>Gestion de bibliotheque en ligne | Recuperation de mot de passe </title>
     <!-- BOOTSTRAP CORE STYLE  -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
     <!-- FONT AWESOME STYLE  -->
     <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- CUSTOM STYLE  -->
     <link href="assets/css/style.css" rel="stylesheet" />

     <script type="text/javascript">
          // On cree une fonction nommee valid() qui verifie que les deux mots de passe saisis par l'utilisateur sont identiques.
     </script>

</head>

<body>
     <!--On inclue ici le menu de navigation includes/header.php-->
     <?php include('includes/header.php'); ?>
     <!-- On insere le titre de la page (RECUPERATION MOT DE PASSE -->
     <div class="container">
          <div class="row">
               <div class="col">
                    <h3>RECUPERATION DU MOT DE PASSE</h3>
               </div>
          </div>
     </div>

     <!--On insere le formulaire de recuperation-->

     <form action="user-forgot-password.php" method="POST">
          <div class="form-group">
               <label for="email">Email:</label>
               <input type="text" name="EmailId" id="email">
          </div>

          <div class="form-group">
               <label for="number">Tel Portable:</label>
               <input type="text" name="MobileNumber" id="number">
          </div>

          <div class="form-group">
               <label for="Password">Nouveau Mot de passe:</label>
               <input type="password" name="password" id="Password2">
          </div>

          <div class="form-group">
               <label for="PasswordConfirm">confirmer le mot de passe:</label>
               <input type="text" name="PasswordConfirm" id="PasswordConfirm2">
          </div>

          <div class="form-group">
               <label>Code de vérification</label>
               <input type="text" name="vercode" required style="height:25px;">&nbsp;&nbsp;&nbsp;<img src="captcha.php">;
          </div>



          <button type="submit" name="change" class="btn btn-info change">Envoyer</button>
     </form>
     <!--L'appel de la fonction valid() se fait dans la balise <form> au moyen de la propri�t� onSubmit="return valid();"-->


     <?php include('includes/footer.php'); ?>
     <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
     <script src="scriptrecu.js"></script>
</body>

</html>