<?php

include_once "../partials/navBarreProfile.php";
?>

<body class="bodyProfile">

    <div class="profile">
        <div class="profile-card">
            <div class="frontProfile">
                <img class="" src="../../images/RealtyIcon.svg"></img>
                <div class="detailsProfile">
                    <p class="pProfile"><strong>Prénom:</strong> <?= $user['user_firstname'] ?></p>
                    <p class="pProfile"><strong>Nom:</strong> <?= $user['user_lastname'] ?></p>
                    <p class="pProfile"><strong>Date de Naissance:</strong> <?= $user['user_birth'] ?></p>
                    <p class="pProfile"><strong>Téléphone:</strong> <?= $user['user_phone'] ?></p>
                    <p class="pProfile"><strong>Ville:</strong> <?= $user['user_city'] ?></p>
                    <p class="pProfile"><strong>Code Postal:</strong> <?= $user['user_zip_code'] ?></p>
                    <p class="pProfile"><strong>Adresse Mail:</strong> <?= $user['user_mail'] ?></p>
                    <p class="pProfile"><strong>Adresse:</strong> <?= $user['user_address'] ?></p>
                </div>
                <button class="global-saveButton">Modifier le profil</button>
            </div>
            <form action='http://localhost:4000/user/updateAccount' method='POST' class="backProfile">

                <div class="containerinputProfile">
                    <h2 class="titleProfile">Profil</h2>
                    <div class="containerTwoInput">
                        <input type="hidden" value="<?= $user['user_id'] ?>" name="userId">

                        <div class="field">
                            <input type="text" value=" <?= $user['user_firstname'] ?>" name="firstname">
                            <label for="firsname">Prénom</label>
                        </div>
                        <div class="field">
                            <input type="text" class="inputProfile" value=" <?= $user['user_lastname'] ?>" name="lastname">
                            <label for="lastname">Nom de famille</label>
                        </div>

                    </div>

                    <div class="containerTwoInput">
                        <div class="field">
                            <input type="date" 	id="username" name='birthday' value='<?= $user['user_birth'] ?>'>
		                    <label for="username">Date de naissance</label>
                        </div>
                        <div class="field">
                            <input type="text" value=" <?= $user['user_phone'] ?>" name="phone">
		                    <label for="username">Numéro</label>
                        </div>
                    </div>
                    <div class="containerTwoInput">
                        <div class="field">
                            <input type="text" value=" <?= $user['user_city'] ?>" name="city">
                            <label for="city">Ville</label>
                        </div>
                        <div class="field">
                            <input type="text" value=" <?= $user['user_zip_code'] ?>" name="zipCode">
		                    <label for="username">Code postal</label>
                        </div>
                    </div>

                    <div class="field">
                        <input type="text" value=" <?= $user['user_address'] ?>" name="address">
		                <label for="address">Adresse personnelle</label>
                    </div>
                    <div class="field">
                        <input type="mail" value=" <?= $user['user_mail'] ?>" name="mail">
		                <label for="address">Adresse mail</label>
                    </div>
                    

                    <button class="global-saveButton">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../../javascript/profile.js"></script>
</body>

</html>