<?php
ini_set('display_errors', 1);
include_once "../partials/navBarreProfile.php";
$user_id = $_SESSION['id'];
$apartment_id = $_GET['id'];
?>


<body class="bodyProfile">
    <div class="containerHistoryLocation">
        <div class="commentContainer">
            <p class="commentTitle">Faites-nous un retour sur votre expérience que vous avez eu avec notre service.</p>
            <form action="http://localhost:4000/comment/progress/add" method='POST'>
                <input type='hidden' value='<?= $user_id ?>' name='user_id'/>
                <input type='hidden' value='<?= $apartment_id ?>' name='apartment_id'/>
                <textarea name="comment" class="commentArea" placeholder="Écrire un commentaire"></textarea>
                <button type="submit" class="reviewButton">Envoyer votre retour</button>
            </form>
        </div>
    </div>
</body>