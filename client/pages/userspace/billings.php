<?php

include_once "../partials/navBarreProfile.php";
$invoices = json_decode($user['invoices'], true); 

?>

<body class="bodyProfile">

    <div class="containerAllBillings">
        <h2 class="titleProfile titleBillings">Factures</h2>
        
        <div class="allBillings">
            <!-- <div class="ser"> -->
                <?php if (!$invoices): ?>
                    <p style="margin-top: 100px;"> Aucune facture </p>
                <?php endif ?>
                <?php if ($invoices): ?>
                    <div class="srollbillings"></div>
                    <?php foreach($invoices as $invoice ): ?>
                        <div class="oneBilling">
                            <hr class="reservationHr">
                            <div class="contentBilling">
                                <p><strong>Location :</strong><br><?= $invoice['apartment-name'] ?>, <?= $invoice['apartment-zipCode'] ?></p>
                                    <div class="containerDate">
                                        <div class="dateBillings">
                                            <p><?= $invoice['payment-date'] ?></p>
                                        </div>
                                    </div>
                                <h4><?= $invoice['amount'] ?>€</h4>
                            </div>
                            <hr class="reservationHr">
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>    
            <!-- </div> -->
        </div>
        
        

    </div>
    <script src="../../javascript/navBarreProfile.js"></script>
</body>
</html>