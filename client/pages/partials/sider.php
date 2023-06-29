<?php 
    ini_set('display_errors', 1);
    session_start();
    $user_id = $_SESSION['id'];
    $user_statut = $_SESSION['statut'];

    $url = "http://localhost:4000/user/get/apartmentEmployee/" . $user_id . '/' . $user_statut;
    $json = file_get_contents($url);
    $result = json_decode($json, true);
    
    $apartments = json_decode($result['apartments'], true);

    $url='http://localhost:4000/notification/getAll/' . $user_id;
    $json = file_get_contents($url);
    $notifications = json_decode($json, true);

    $count = 0;
   
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/index.css">
    <title>Realty</title>
</head>

<body>

    <div class="global-sider">
            <a href="../../location/locations.php"><img src="../../../images/RealtyIcon.svg" alt="Logo Realty" class="global-logoSider"></a>
            <a href="../../company/employee/menu.php"><img src="../../../images/iconProfile.svg" alt="Photo Apartment" class="global-imgApart"></a>
            <div>
                <h3><?= $user_statut?></h3> 
                <strong><?= $result['user_firstname'] ?> <?= $result['user_lastname'] ?></strong>
            </div>

            <a href="../../company/employee/dashboard.php" class="global-buttonHref"><img src="../../../images/iconDashboard.svg" alt="Icone Dashboard" class="global-icone">Appartements</a>
            <a href="../../company/employee/employeemessage.php" class="global-buttonHref"><img src="../../../images/iconMessage.svg" alt="Icone Message" class="global-icone">Message</a>
            <a href="../../company/employee/checklist.php" class="global-buttonHref"><img src="../../../images/iconChecklist.svg" alt="Icone Checklist" class="global-icone">Equipes</a>
            <a href="../../company/employee/planning.php" class="global-buttonHref"><img src="../../../images/iconPlanning.svg" alt="Icone Planning" class="global-icone">Planning</a>
            <a href="../../company/employee/report.php" class="global-buttonHref"><img src="../../../images/iconReport.svg" alt="Icone Report" class="global-icone">Report</a>
            <br>
            <script type="module" src="../../../javascript/sider.js"></script>
        
    </div>