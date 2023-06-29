<?php

include "../../partials/sider.php";
$user_id = $_SESSION['id'];
if (isset($_GET['id'])){
    $apartment_id = $_GET['id'];
}

$urlMessages='http://localhost:4000/user/problemUserGetAll/logistic/' . $apartment_id . '/' . $user_id;
$jsonMessages = file_get_contents($urlMessages);
$messages = json_decode($jsonMessages, true);
$messageCount = 0;
?>
    <div class="global-containerCompany">
        <div class="containerReport">
    <!-- ------------------------------------------------------------------------------------------ -->
            <div class='flexPartContainer'>
                <div class='containainerEmitter'>
                    <h2 class="titleReport">appartements</h2>
                    <?php foreach($apartments as $apartment ): ?>
                    <a class='apartmentLinks' href="http://localhost:3000/pages/company/employee/employeemessage.php?id=<?= $apartment['apartment_id'] ?>" ><?= $apartment['name'] ?></a> 
                    <?php endforeach; ?>
                </div>
    
                <div class="employeeMessageContainer">
                    <?php if(isset($_GET['id'])) : ?>
                        <?php foreach($messages as $message ): ?>

                            <?php if ($user_id != $message['user_id'] && $message['user_statut'] == 'Client'): ?> 
                                <div class="messageReport redReport">
                                    <p><?= $message['user_problem_created_at'] ?></p>
                                    <p><?= $message['user_firstname'] ?>-<?= $message['user_lastname'] ?>:</p>
                                    <p><?= $message['user_problem_description'] ?></p> 
                                </div>
                            <?php endif ?> 

                            <?php if ($user_id == $message['user_id']): ?>
                                <div class="messageReport greenReport"> 
                                    <p><?= $message['user_problem_created_at'] ?></p>
                                    <p><?= $message['user_problem_description'] ?></p>
                                </div>
                            <?php endif ?> 
                        <?php endforeach; ?>    
                    <?php endif ?>
                </div>
            </div>
<!-- -------------------------------------------------------------------------------------------- -->
            <div class="reservationHr"></div>
            <form action="http://localhost:4000/user/response/problemUser" method="POST" class="sendMessageReport">
                <input type="hidden" value="<?= $apartment_id ?>" name="apartment_id"/>
                <input type="hidden" value="<?= $user_id ?>" name="user_id"/>
                <input type="text" class="inputMessageReport" placeholder="Écrire un message..." name="problem_description">
                <button class="buttonSendReport">Envoyer</button>
            </form>
        </div>
    </div>
</body>
</html>