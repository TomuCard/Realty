<?php include "../../partials/sider.php";
if(isset($_GET['id'])){
    $apartment_id = $_GET['id'];
};
$urlApartment = 'http://localhost:4000/apartment/logistic/get/oneApartment/' . $apartment_id;
$jsonApartment = file_get_contents($urlApartment);
$resultApartment = json_decode($jsonApartment, true);
$services = json_decode($resultApartment['servicesOfApartment'], true);
$comments = json_decode($resultApartment['commentProgress'], true);
?>
<div class="global-containerCompany">
    <div class="containerUpdateApart">
        <div class="blabla">
            <h2><?= $resultApartment['apartment_adress'] ?></h2>
            <h2><?= $resultApartment['apartment_zip_code'] ?></h2>
        </div>
        <form class="containerAddPicture">
            <img src="<?= $resultApartment['apartment_main_picture'] ?>" alt="Photo appartement <?= $resultApartment['apartment_adress'] ?>" id="image-container"/>
            <div class="buttonInput-FileUpdateApart">
                <input class="buttonInputUpdateApart" type="file" id="file-input"> 
                <label class="buttonInput-File" for="file-input">Modifier</label>
            </div>
        </form>
        <hr class="reservationHr">
        <h2>Services:</h2>
        <div class="containerAddService">
                <div class="allServicesContainer">
                    <h3 class="serviceSubTitle">Services actuelles</h3>
                    <?php foreach($services as $service): ?>
                        <div class="allServicesOfApartment"> 
                            <p class="oneServiceOfApartment"><?= $service['service_name'] ?></p>
                            <form action="">
                                <button>supprimer</button>
                            </form>  
                        </div>
                    <?php endforeach; ?>
                </div> 
            <div>
                <div>
                    <form action="">
                        <h3 class="serviceSubTitle">Ajouter un service</h3>
                        <select name="">
                            <option value="Choix">
                                Choisir un service a ajouter
                            </option>
                            <option value="">
                                
                            </option>
                        </select>

                        <button>Ajouter</button>
                    </form>

                    <form action="">
                        <h3 class="serviceSubTitle">créer un service</h3>
                        <input type="text">
                        <button>Créer</button>
                    </form>
                </div>
            </div>   
        </div>
        <hr class="reservationHr">
        <div class="updateComment">
            <h2>Commentaire :</h2>
            <a href="#" class="moreComment">Plus de commantaire</a>
        </div>
        <div class="containerComment">
            <?php if ($comments): ?>
                <div class="oneComment">
                    <?php foreach($comments as $comment): ?>  
                        <div class="contentOneComment">
                            <strong><?= $comment['firstname'] ?> <?= $comment['lastname'] ?></strong>
                            <p><?= $comment['comment'] ?></p>
                        </div>
                    <?php endforeach; ?>
                    <div class="buttonOneComment">
                        <form action="">
                            <button class="greenButtonOneComment">Valider</button>
                        </form>
                        <form action="">
                            <button class="redButtonOneComment">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <hr class="reservationHr">
        <h3 class="planningName">Planning ménage :</h3>
        <div class="employeUpdateApart">
            <strong>Tomu Cardonnel</strong>
            <a href="../../userspace/profile.php">Détails</a>
        </div>
        <div class="containerPlanningUpdateApart">
            <div class="onePlanningUpdateApart">
                <p class="contentPlanningUpdateApart">07/06/2023</p>
                <button>Modifier</button>
            </div>
            <div class="onePlanningUpdateApart">
                <p class="contentPlanningUpdateApart">07/06/2023</p>
                <button>Modifier</button>
            </div>
            <div class="onePlanningUpdateApart">
                <p class="contentPlanningUpdateApart">07/06/2023</p>
                <button>Modifier</button>
            </div>
        </div>
    </div>
</div>
</body>
<script src="../../../javascript/createApart.js"></script>
</html>