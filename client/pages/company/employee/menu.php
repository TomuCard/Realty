<?php 
    include "../../partials/sider.php";
?>
    <div class="global-containerCompany">
        <?php foreach($notifications as $notification): ?>
            <div class="notification_container">
                <p class='notif-flex'><?=$notification['notification_created_at'] ?></p>
                <p><?=$notification['notification_message'] ?></p>
                <a href='<?=$notification['notification_link'] ?>'>Valider le commentaire</a>
            </div>
        <?php endforeach; ?>
        <?php foreach($notifications as $notification): ?>
            <div class="notification_container">
                <p class='notif-flex'><?=$notification['notification_message_created_at'] ?></p>
                <p><?=$notification['notification_message_message'] ?></p>
                <a href='<?=$notification['notification_message_link'] ?>'>Valider le commentaire</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html> 