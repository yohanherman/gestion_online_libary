   <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
       <span class="navbar-toggler-icon"></span>
   </button>

   <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="dashboard.php">TABLEAU DE BORD</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              CATEGORIES
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-category.php">Ajouter une catégorie</a>
                  <a class="dropdown-item" href="manage-categories.php">Gérer les catégories</a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              AUTEURS
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-author.php">Ajouter un auteur</a>
                  <a class="dropdown-item" href="manage-authors.php">Gérer les auteurs</a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              LIVRES
              </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-book.php">Ajouter un livre</a>
                  <a class="dropdown-item" href="manage-books.php">Gérer les livres</a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              SORTIES
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-issue-book.php">Ajouter une sortie</a>
                  <a class="dropdown-item" href="manage-issued-books.php">Gérer les sorties</a>
              </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="reg-readers.php">LECTEURS</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="change-password.php">MODIFIER LE MOT DE PASSE</a>
          </li>
      </ul>
   </div>
   <div class="right-div">
       <a href="logout.php" class="btn btn-danger pull-right">DECONNEXION</a>
   </div>    
</nav>