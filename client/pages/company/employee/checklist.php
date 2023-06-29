<?php
include "../../partials/sider.php";

$params = $_POST['params'];

$urlSearch = 'http://localhost:4000/user/search/' . $params;
$jsonSearch = file_get_contents($urlSearch);
$searchResults = json_decode($jsonSearch, true);
?>

<div class="global-containerCompany">
    <form action='http://localhost:3000/pages/company/employee/checklist.php' method='POST' class="search-bar">
        <input type="text" placeholder="Rechercher..." name='params'>
        <button class="search-button">Envoyer</button>
    </form>

    <div class="checklist">
        <!-- <h2 class="checklistTitle">Chambre</h2> -->
        <div class="slider">
            <p> Résultat pour : <?= $params ?> </p>
            <?php if($params): ?>
                <?php foreach($searchResults as $searchResult) : ?>
                    <div class="item">
                        <div class="user-image">
                            <img src="../../../images/iconProfile.svg" alt="Image 1">
                        </div>
                        
                        <div class="user-name">
                            <span><?= $searchResult['user_firstname'] ?> <?= $searchResult['user_lastname'] ?></span>
                            <span><?= $searchResult['user_statut']?></span>
                        </div>
                        <form action="http://localhost:4000/user/updateStatus" method="POST">
                            <input type="hidden" name="user_id" value="<?= $searchResult['user_id'] ?>">
                            <select name="statut">
                                <option value="Choix du statut">
                                    Choix du statut
                                </option>
                                <option value="Client">
                                    Client
                                </option>
                                <option value="Logistique">
                                    Logistique
                                </option>
                                <option value="Menage">
                                    Menage
                                </option>
                            </select>
                            <button class="modify-button">Modifier</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if(!$params): ?>
                <p class="user-name">Aucun résultat pour le moment</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
