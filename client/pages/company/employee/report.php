<?php

include "../../partials/sider.php";

?>
    <div class="global-containerCompany">
        <div class="containerReport">
            <h2 class="titleReport">Historique de vérification de (nom de l'appartement)</h2>
            <div class="messagesReport">
                <p class="messageReport greenReport"> Salle à manger vérifiée dans sa totalité,<br>
                                        aucun problème à signaler.
                </p>
                <p class="messageReport greenReport"> Terrassse vérifiée dans sa totalité,<br>
                                        aucun problème à signaler.
                </p>
                <p class="messageReport redReport">Le chauffage est en panne, il faut le<br>
                                        réparer avant l'arrivée du prochain<br>
                                        client.
                </p>
                <p class="messageReport greenReport">Salon vérifiée dans sa totalité<br>
                                        aucun problème à signaler.Salon vérifiée dans sa totalité<br>
                                        aucun problème à signaler.Salon vérifiée dans sa totalité<br>
                                        aucun problème à signaler.Salon vérifiée dans sa totalité<br>
                                        aucun problème à signaler.Salon vérifiée dans sa totalité<br>
                                        aucun problème à signaler.Salon vérifiée dans sa totalité<br>
                                        aucun problème à signaler.Salon vérifiée dans sa totalité<br>
                                        aucun problème à signaler.
                </p>
                <p class="messageReport greenReport">Cuisine vérifiée dans sa totalité,<br>
                                        aucun problème à signaler.
                </p>
            </div>
                <div class="reservationHr"></div>
                <form action="" class="sendMessageReport">
                    <input type="text" class="inputMessageReport" placeholder="Écrire un message...">
                    <div class="buttonsReport">
                        <div>
                            <input class="redButtonReport radioReport" type="radio" id="redCheckbox" name="radioButton" value="redCheckbox">
                            <input type="radio" class="greenButtonReport radioReport" id="greenCheckbox" name="radioButton">
                        </div>
                        <button class="buttonSendReport">Envoyer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>