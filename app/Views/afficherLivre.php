<?php ob_start() ?>
<div class="livre-container">
    <div class="livre-image-container">
        <img class="livre-image" src="<?= SITE_URL ?>images/<?= $livre->getUrlImage() ?>" alt="<?= $livre->getTextAlternatif() ?>">
    </div>
    <div class="livre-details">
        <p><strong>Titre :</strong> <?= $livre->getTitre() ?></p>
        <p><strong>Nombre de pages :</strong> <?= $livre->getNbreDePages() ?></p>
        <p><strong>Uploader :</strong> <?= $livre->getUploader() ?></p>
    </div>
</div>
<?php
$titre = $livre->getTitre();
$content = ob_get_clean();
require_once 'template.php';
