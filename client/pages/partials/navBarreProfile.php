<?php

    include "../partials/userHeader.php";
    session_start();
    if(!$_SESSION['id']){
        header('Location:http://localhost:3000/pages/userspace/login.php');
    }
    $user_id = $_SESSION['id'];
    $url='http://localhost:4000/user/getAccount/' . $user_id;
    $json = file_get_contents($url);
    $user = json_decode($json, true);
   
    $user_id = $_SESSION['id'];
    $url='http://localhost:4000/apartment/get/rentalInProgress/' . $user_id;
    $json = file_get_contents($url);
    $apartment = json_decode($json, true);

?>

<div class="navbarProfile">
    <a href="http://localhost:3000/pages/userspace/profile.php">Profil</a>

    <?php if ($_SESSION['statut'] == 'Logistique' || $_SESSION['statut'] == 'Menage'): ?>
        <a href="http://localhost:3000/pages/company/employee/menu.php">Logistique</a>
    <?php endif; ?>

    <?php if ($_SESSION['statut'] == 'Client'): ?>
        <a href="http://localhost:3000/pages/userspace/historyLocations.php">Mes locations</a>
        <a href="http://localhost:3000/pages/userspace/billings.php">Mes factures</a>
    <?php endif; ?>

    <?php if ($apartment): ?>
        <a href="http://localhost:3000/pages/userspace/message.php">Messages</a>
    <?php endif ?>

    <a href="http://localhost:4000/user/logout">Déconnexion</a>
    <a href="#">Désactiver le compte</a>
    <a href="#">Supprimer le compte</a>
    <script src="../../javascript/navBarreProfile.js"></script>   
</div>
<script src="../../javascript/navBarreProfile.js"></script>
