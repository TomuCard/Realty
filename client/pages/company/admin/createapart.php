<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../styles/index.css">
    <title>Mettre un bien en vente - Realty</title>
    <a href="../../location/locations.php"><img class="iconRealityCreateApart" src="../../../images/RealtyIcon.svg" alt="Logo Realty"></a>
</head>
<body>
    <form class="formCreateApart">
        <div class="containerAddPicture">
            <div id="image-container"></div>
            <div class="buttonInput-FileCreateApart">
                <input type="file" id="file-input"> 
                <label class="buttonInput-File" for="file-input">Ajouter une image</label>
            </div>
        </div>
            <input class="inputTypeOfAccommodation" type="text" placeholder="Type : Maison, Appartement....." id="name" name="name" required>
            <input class="inputCapacity" type="text" placeholder="Capaciter: 2 Voyageurs, 1 Chambre..." id="name" name="name" required>
            <textarea class="descriptionCreateApart" name="description" rows="15" cols="36" placeholder="Description..."></textarea>

        <div class="equipementCreateApart">
            <h1 id="textEquipement">Équipement :</h1> 
            <div class="equipementList" id="equipementJs">

                <!-- <div class="listEquipement">
                    <input type="checkbox" id="kitchen" name="kitchen">
                    <img class="kitchenPicture" src="../.././../images/kitchen.svg">
                    <label for="kitchen" class="textKitchen">Cuisine complète</label>       
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="camera" name="camera">
                    <label for="camera" class="textCamera">Caméra</label>
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="workspace" name="workspace">
                    <label for="workspace" class="textWorkspace">Espace de travail</label>                                    
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="smokeAlarm" name="smokeAlarm">
                    <label for="smokeAlarm" class="textSmokeAlarm">Détecteur</label>
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="wifi" name="wifi">
                    <label for="wifi" class="textWifi">Wifi</label>
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="firstKit" name="firstKit">
                    <label for="firstKit" class="textFirstKit">Kit de soin</label>
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="dryer" name="dryer">
                    <label for="dryer" class="textDryer">Sèche-linge</label>
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="privateParking" name="privateParking">
                    <label for="privateParking" class="textPrivateParking">Parking Privé</label>
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="climateControl" name="climateControl">
                    <label for="climateControl" class="textClimateControl">Climatiseur</label>
                </div>
                <div class="listEquipement">
                    <input type="checkbox" id="heating" name="heating">
                    <label for="heating" class="textHeating">Chauffage</label>
                </div> -->

                
            </div> 
            <input type="text">
        </div>
        <input class="inputInterior" type="text" placeholder="Intérieur" id="interior" name="interior" required>
        <input class="inputSecurity" type="text" placeholder="Sécuriter" id="security" name="interior" required>
        <textarea class="cancellationConditionCreateApart" name="description" rows="15" cols="36" placeholder="Condition d'annulation"></textarea>
        <button class="buttonSave" type="button">Enregistrer</button>
    </form>
    <!-- <form action="" class="appendEquipement">
        <input class="addService" type="text" placeholder="Ajouter un service   " id="textService" name="name" required>
        <input type="button" onclick="equipement()" value="Ajouter">
    </form> -->
    <script src="../../../javascript/createApart.js"></script>
</body>
</html>