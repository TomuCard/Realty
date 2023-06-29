<?php

include "../partials/userHeader.php";
session_start();
    if(!$_SESSION['id']){
        header('Location:http://localhost:3000/pages/userspace/login.php');
    }
    $user_id = $_SESSION['id'];
    $url='http://localhost:4000/apartment/get/rentalInProgress/' . $user_id;
    $json = file_get_contents($url);
    $apartment = json_decode($json, true);

    $urlMessages='http://localhost:4000/user/problemUserGetAll/' . $apartment['apartment_id'] . '/' . $user_id;
    $jsonMessages = file_get_contents($urlMessages);
    $messages = json_decode($jsonMessages, true);

?>
<body>
    <div class="msgLocationContainer">
        <div class="messageSlider">
            <p class="msgMenuTitle">Message</p> 
            <p class="msgApartmentName"><?=$apartment['apartment_adress']?></p>
            <p class="msgApartmentDescription"><?=$apartment['apartment_zip_code']?>, <?=$apartment['apartment_city']?></p>
    
        </div>
    </div>
            <div class="conversation">
                <?php foreach($messages as $message): ?>

                    <?php if ($user_id == $message['user_id']): ?>   
                        <div class="transmitter">
                            <p><?= $message['user_problem_created_at'] ?></p>
                            <p><?= $message['user_problem_description'] ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($user_id != $message['user_id'] && $message['user_statut'] == 'Logistique'): ?>    
                        <div class="receiver">
                            <p><?= $message['user_problem_created_at'] ?></p>
                            <p><?= $message['user_firstname'] ?>-<?= $message['user_lastname'] ?>:</p>
                            <p><?= $message['user_problem_description'] ?></p>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?> 

            </div>
        <form action="http://localhost:4000/user/problemUserAdd" method="POST" class="inputContainer">
            <input type="hidden" value="<?= $apartment['apartment_id'] ?>" name="apartment_id"/>
            <input type="hidden" value="<?= $user_id ?>" name="user_id"/>
            <input class="msgInput" placeholder="Écrire un message..." name="problem_description">
            <button class="sendButton">
                Envoyer
            </button>
        </form>
</body>
</html>