<?php

include "../partials/userHeader.php";
session_start();
$user_id = $_SESSION['id'];
$apartment_id = $_GET['id'];

$url = "http://localhost:4000/apartment/get/oneApartment/" . $apartment_id;
$json = file_get_contents($url);
$apartment = json_decode($json, true);

?>

    <div class="responsiveDetailsLocation">
        <div class="containerImageAndReservation">
            <div class="containerImageDetailLocation">
                <div class="canvasContainer">
                    <canvas class="webgl" class="firstImage"></canvas>
                    <script type="module" src="../../javascript/locationdetails.js"></script>
                        <p class="topDescription">VISITE 3D</p>
                        <p class="bottomDescription">Visitez la location en maintenant le clic</p>
                </div>
            </div>
            <form action='http://localhost:4000/apartment/add/apartmentRental' method='POST' class="containerReservation">
                <h2 class="locationReservation">Disponibilitées </h2>
                <div id='calendar-container'></div>

                <h2 class="locationReservation">Choisir une période</h2>
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <input type="hidden" id='apartment_id' name="apartment_id" value="<?= $apartment_id ?>">
                <input type="hidden" id='total_price' name='amount'>
                <div class="containerDateLocationDetails">
                    <div class="dateSelectContainer">
                        <img src="../../images/departSVG.svg" class="global-icon"></img>
                        <input type="date" class="inputDate" id="start-date" name='start_date'>
                    </div>      
                    <div class="dateSelectContainer">
                        <img src="../../images/returnSVG.svg" class="global-icon"></img>
                        <input type="date" class="inputDate" id="end-date" name='end_date'>
                    </div>
                </div>
                <hr class="reservationHr">
                
                <div class="containerCostReservation">
                    <h3 class="locationReservation"><?= $apartment['apartment_price'] ?> €<span> par nuit</span></h3>
                    <div class="costReservation">
                        <div class="contentCostReservation"><p id="unit-price"><?= $apartment['apartment_price'] ?></p> <span> € x </span> <span id="nights"> <span></div> 
                        <div class="contentCostReservation"><p id="total-price"></p> <span> €</span></div>
                    </div>
                    <div class="costReservation">
                        <p>Taxes</p>
                        <div class="contentCostReservation"><p id='tax'> </p> <span> €</span></div>
                    </div>
                </div> 
                <hr class="reservationHr">
                <div class="costReservation">
                    <h3>Total</h3>
                    <div class="contentCostReservation"><p id='price-ttc'> </p> <span> €</span></div>
                </div>
                    <button class="global-reserveButton marginReserveButton">Réserver</button>
            </form>
        </div>
    </div>

    <div class="containerdetails">
        <h3><?= $apartment['apartment_adress'] ?></h3>
        <p class="grayTextLocation">Capacité: <?=$apartment['apartment_capacity']?> voyageurs · <?=$apartment['apartment_bedroom']?> chambres · <?=$apartment['apartment_size']?> m²</p>
        <hr class="reservationHr">
        <p><?=$apartment['apartment_description']?></p>
    </div>

    <div class="containerdetails">
        <h3>Équipements</h3>
        <div class="listEquipment">
            <?php $services = json_decode($apartment['services'], true); ?>
            <?php foreach($services as $service): ?>
                <div class="oneEquipment">
                    <img src="../../images/Cuisine.svg" alt="" class="global-icon">
                    <p><?= $service['service_name'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="containerdetails">
        <h3>Reviews</h3>
        <hr class="reservationHr">
        <?php $reviews = json_decode($apartment['reviews'], true); ?>
        <?php if ($reviews) : ?>
            <?php foreach($reviews as $review): ?>
                <div>
                    <div class="reviewsNameAndDate">
                        <p><?= $review['firstname'] ?>, <?= $review['lastname']?></p>
                        <p class="dateReviews">Jan 11</p>
                    </div>
                    <br>
                    <p><?= $review['comment'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (!$reviews) : ?>
            <p>Aucun commentaire</p>
        <?php endif; ?>

    </div>

    <div class="containerdetails bottomLocation">
        <div class="rulesHeader">
            <h3>Règlement</h3>
            <div class="supportContact">
                <button class="global-reserveButton">Contacter le support</button>
            </div>
        </div>
        <div class="interiorSecurityLocation">
            <div>
                <p>intérieur</p>
                <p class="grayTextLocation">Arrivée à partir de 12:00</p>
                <p class="grayTextLocation">Départ avant 11:00</p>
                <p class="grayTextLocation"> 5 voyageurs maximum</p>
            </div>
            <div>
                <p>Sécurité</p>
                <p class="grayTextLocation">Détecteur de fumée</p>
                <p class="grayTextLocation">Détecteur de monoxyde de carbone</p>
            </div>
        </div>
        <div class="conditionLocation">
            <p>Condition d'annulation</p>
            <p class="grayTextLocation">Si vous annulez avant le 3 juin, vous aurez droit à un remboursement partiel.</p>
            <p class="grayTextLocation">Consultez les conditions d'annulation complètes de l'hôte, qui s'appliquent même si vous annulez pour cause de maladie ou de perturbations causées par le Covid-19.</p>
        </div>
    </div>
    <script src="../../javascript/calandar.js"></script>


</body>
</html>