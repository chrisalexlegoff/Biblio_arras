<?php ob_start() ?>
<div class="d-flex flex-column justify-content-center">
    <div class="row w-100">
        <div class="col-6">
            <img style='max-width:100%;' src="<?= SITE_URL ?>images/<?= $livre->getUrlImage() ?>" alt="<?= $livre->getTextAlternatif() ?>">
        </div>
        <div class="col-6">
            <p>Titre : <?= $livre->getTitre() ?></p>
            <p>Nombre de pages : <?= $livre->getNbreDePages() ?></p>
            <p>Uploader : <?= $livre->getUploader() ?></p>
        </div>
    </div>
</div>
<?php
$titre = $livre->getTitre();
$content = ob_get_clean();
require_once 'template.php';
