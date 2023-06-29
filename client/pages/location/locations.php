<?php

include "../partials/userHeader.php";

$url = "http://localhost:4000/apartment/get/allApartment";
$json = file_get_contents($url);
$apartments = json_decode($json, true);

if($zipCode && $startDate == null && $endDate == null){
    $url_search = "http://localhost:4000/apartment/search/" . $zipCode;
    $json_search = file_get_contents($url_search);
    $results = json_decode($json_search, true);
}else if ($zipCode == null && $startDate && $endDate){
    $url_search = "http://localhost:4000/apartment/search/" . $startDate . '/' . $endDate;
    $json_search = file_get_contents($url_search);
    $results = json_decode($json_search, true);
}else if ($zipCode && $startDate && $endDate) {
    $url_search = "http://localhost:4000/apartment/search/" . $zipCode . '/' . $startDate . '/' . $endDate;
    $json_search = file_get_contents($url_search);
    $results = json_decode($json_search, true);
}else{
    $results = null;
}

?>

<body>
    
    <div class="filterContainer">
        <div class="dateSelectContainer secondaryElement">
            <button data-page="1" class="global-icon">
                <img src="../../images/leftArrow.svg" class="global-icon"></img>
            </button>
            <p class="global-title">
                1
            </p>
            <button data-page="2" class="global-icon">
                <img src="../../images/rightArrow.svg" class="global-icon"></img>
            </button>
        </div>
    </div>

    <script>
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('departureDate').value = today;
    </script>

    <?php if($results == null): ?>
        <div class="global-mainContainer" id="locationsContainer">
        <p><?= $results ?></p>
            <?php foreach ($apartments as $apartment): ?>
                <a class="global-locationContainer"
                    href="http://localhost:3000/pages/location/locationdetails.php?id=<?= $apartment['apartment_id'] ?>">
                    <img class="global-imgLocation" src="<?= $apartment['apartment_main_picture'] ?>" alt="appartement">
                    <div>
                        <div class="global-textposition">
                            <p class="global-title">
                                <?= $apartment['apartment_adress'] ?>
                            </p>
                            <p class="global-description" display="grid">
                                <?= $apartment['apartment_description'] ?>
                            </p>
                            <p class="global-subtitle">
                                <?= $apartment['apartment_price'] ?>€ la nuit
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($results)): ?>
        <div class="global-mainContainer" id="locationsContainer">
            
            <?php foreach ($results as $result): ?>
                <a class="global-locationContainer"
                    href="http://localhost:3000/pages/location/locationdetails.php?id=<?= $result['apartment_id'] ?>">
                    <img class="global-imgLocation" src="<?= $result['apartment_main_picture'] ?>" alt="appartement">
                    <div>
                        <div class="global-textposition">
                            <p class="global-title">
                                <?= $result['apartment_adress'] ?>
                            </p>
                            <p class="global-description" display="grid">
                                <?= $result['apartment_description'] ?>
                            </p>
                            <p class="global-subtitle">
                                <?= $result['apartment_price'] ?>€ la nuit
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <script>
        var totalLocationsPHP = <?= count($apartments) ?>;
    </script>
    <script src="../../javascript/locations.js"></script>
</body>