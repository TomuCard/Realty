<?php

include "../partials/userHeader.php";

?>

<body class="bodyLogin">

    <?php include "../../pages/partials/userHeader.php" ?>

    <div class="containerLogin">
        <div class="form sign-in">

            <h2 class="h2Login">Connexion</h2>

            <form action="http://localhost:4000/user/loginAccount" method="POST">

                <div class="labelLogin">
                    <label for='email' class="spanLogin">E-mail</label>
                    <input class="inputLogin" type="mail" name="mail" id="email" required>
                </div>

                <div class="labelLogin">
                    <label for='password' class="spanLogin">Mot de Passe</label>
                    <input class="inputLogin" type="password" name="password" id="password" required>
                </div>


                <button type="submit" name="fformsend" id="fformsend" class="submit buttonLogin" required>se
                    connecter</button>
            </form>



            <p class="forgot-pass">Mot de passe oublié ?</p>
        </div>

        <div class="sub-containerLogin">
            <div class="img">
                <div class="img-text m-up">
                    <h2 class="h2Login">Nouveau ici?</h2>
                    <p class="pLogin">Inscris-toi et découvre de nouvelles opportunitées!</p>
                </div>
                <div class="img-text m-in">
                    <h2 class="h2Login">Déjà parmis nous ? </h2>
                    <p class="pLogin">Si tu as déjà un compte, connecte toi !</p>
                </div>
                <div class="img-btn">
                    <span class="m-up spanLogin">Inscription</span>
                    <span class="m-in spanLogin">Connexion</span>
                </div>
            </div>
            <div class="form sign-up">
                <h2 class="h2Login">Inscription</h2>

                <form action="http://localhost:4000/user/createAccount" method="post">
                    <div class="labelLogin">
                        <label for='firstname' class="spanLogin">Prénom</label>
                        <input class="inputLogin" type="text" name="firstname" id="firstname" required>
                    </div>
                    <div class="labelLogin">
                        <label for='name' class="spanLogin">Nom</label>
                        <input class="inputLogin" type="text" name="lastname" id="name" required>
                    </div>
                    <div class="labelLogin">
                        <label for='birthday' class="spanLogin">Date de naissance</label>
                        <input class="inputLogin" type="date" name="birthday" id="birthday" required>
                    </div>
                    <div class="labelLogin">
                        <label for='Email' class="spanLogin">E-mail</label>
                        <input class="inputLogin" type="mail" name="mail" id="Email" required>
                    </div>
                    <div class="labelLogin">
                        <label for='password' class="spanLogin">Mot de Passe</label>
                        <input class="inputLogin" type="password" name="password" id="password" required>
                    </div>

                    <button type="submit" name="formsend" id="formsend" class="submit buttonLogin"
                        value="OK">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../../javascript/login.js"></script>
</body>

</html>