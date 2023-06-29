<?php

include_once "../partials/navBarreProfile.php";
$currentDate = date('Y-m-d');
$rentals = json_decode($user['rentals'], true); 
?>

<body class="bodyProfile">

    <div class="containerHistoryLocation">
        
        <h2 class="firsthistory titleTimeHistory">Locations terminées :</h2>

        <?php foreach($rentals as $rental ): ?>
            <?php if ($currentDate > $rental['end-date']): ?>
                <div class="oneHitoryLocation">
                    <hr class="reservationHr">
                    <div class="contentHistoryLocation">
                        <p class="global-title"><?= $rental['apartment-name'] ?> </p>
                        <p class="global-subtitle" display="grid"><?= $rental['apartment-zipCode'] ?></p>
                        <p class="global-subtitle"><?= $rental['apartment-city'] ?></p>
                        <p class="global-subtitle"><?= $rental['start-date'] ?></p>
                        <p class="global-subtitle"><?= $rental['end-date'] ?></p>
                        <a href="./comment.php?id=<?= $rental['apartment-id'] ?>" class="reviewButton">Donner un avis</a>
                    </div>
                    <hr class="reservationHr">
                </div>
            <?php endif ?>
        <?php endforeach; ?>
        
        <div>
            
            <h2 class="titleTimeHistory">Location en cours:</h2>
            
            <?php foreach($rentals as $rental ): ?>
                <?php if ($currentDate > $rental['start-date'] && $currentDate < $rental['end-date']): ?>
                    <div class="oneHistoryLocation">
                        <hr class="reservationHr">
                        <div class="contentHistoryLocation">
                            <p class="global-title"><?= $rental['apartment-name'] ?> </p>
                            <p class="global-subtitle" display="grid"><?= $rental['apartment-zipCode'] ?></p>
                            <p class="global-subtitle"><?= $rental['apartment-city'] ?></p>
                            <p class="global-subtitle"><?= $rental['start-date'] ?></p>
                            <p class="global-subtitle"><?= $rental['end-date'] ?></p>
                        </div>
                        <hr class="reservationHr">
                    </div>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
    
        <div>
            
            <h2 class="titleTimeHistory">Location future:</h2>
            <?php foreach($rentals as $rental ): ?>
                <?php if ($currentDate < $rental['start-date']): ?>
                    <div class="oneHistoryLocation">
                    <hr class="reservationHr">
                        <div class="contentHistoryLocation">   
                            <p class="global-title"><?= $rental['apartment-name'] ?> </p>
                            <p class="global-subtitle" display="grid"><?= $rental['apartment-zipCode'] ?></p>
                            <p class="global-subtitle"><?= $rental['apartment-city'] ?></p>
                            <p class="global-subtitle"><?= $rental['start-date'] ?></p>
                            <p class="global-subtitle"><?= $rental['end-date'] ?></p>
                        </div>
                        <hr class="reservationHr">
                    </div>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
    </div>
   
    
    <script src="../../javascript/navBarreProfile.js"></script>
</body>
</html>