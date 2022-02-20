<?php

    
echo '<div class="container">';
echo '<div class="pos-f-t">';
echo '       <div class="collapse" id="navbarToggleExternalContent">';
echo '        <div class="bg-dark p-4">';
echo '            <h4 class="text-white">Collapsed content</h4>';
echo '           <span class="text-muted">Toggleable via the navbar brand.</span>';
echo '       </div>';
echo '       </div>';
echo '<nav class="navbar navbar-dark bg-dark" style="background-color: transparent ">';
echo '<ul class="nav justify-content-center">';
echo '  <li class="nav-item"><a class="nav-link" href="index.php?action=accueil&id='.$_SESSION["token"].'">Accueil</a></li>';
echo '<li class="nav-item"><a class="nav-link" href="index.php?action=ajoutLivre&id='.$_SESSION["token"].'">Ajouter un livre</a></li>';
echo '<li class="nav-item"><a class="nav-link" href="index.php?action=allLivre&id='.$_SESSION["token"].'">Liste des livres</a></li>';
echo '  <li class="nav-item"><a class="nav-link" href="index.php?action=deleteLivre&id='.$_SESSION["token"].'">Supprimer un livre</a></li>';
echo '  <li class="nav-item"><a class="nav-link" href="index.php?action=moncompte&id='.$_SESSION["token"].'">Mon Compte</a></li>';
echo '  <li class="nav-item"><a class="nav-link " href="index.php">Déconnexion</a></li>';
echo '</ul>';
echo '</nav>';
echo '</div>';



?>