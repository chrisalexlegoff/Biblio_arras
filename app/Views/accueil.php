<?php ob_start() ?>

<div class="livres-container">
    <?php foreach ($livresAll as $livre) : ?>
        <div class="livre-card">
            <h3 class="livre-title"><?= $livre->getTitre() ?></h3>
            <img class="livre-image" src="<?= SITE_URL ?>images/<?= $livre->getUrlImage(); ?>" alt="Image du livre">
            <div class="livre-body">
                <p>Uploader : <?= $livre->getUploader(); ?></p>
                <a class="livre-link" href="<?= SITE_URL ?>livres/l/<?= $livre->getId(); ?>">En savoir plus ...</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
$titre = "Accueil";
$content = ob_get_clean();
require_once 'template.php';
