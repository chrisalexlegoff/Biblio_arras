<?= '<pre>';
// print_r($_SESSION);
// print_r($_POST);
// echo '</pre>';?>
<?php ob_start() ?>

<?php require '../app/Views/showErreurs.php'; ?>

<form method="POST" action="<?= SITE_URL ?>livres/mv" enctype="multipart/form-data">
    <div class="form-group my-4">
        <label for="titre">Titre : </label>
        <input type="text" value="<?= $livre->getTitre(); ?>" class="form-control" id="titre" name="titre">
    </div>
    <div class="form-group my-4">
        <label for="nbre-de-pages">Nombre de pages : </label>
        <input type="number" value="<?= $livre->getNbreDePages(); ?>" class="form-control" id="nbre-de-pages" name="nbre-de-pages">
    </div>
    <div class="form-group my-4">
        <label for="text-alternatif">Texte alternatif : </label>
        <textarea class="form-control" id="text-alternatif" name="text-alternatif"><?= $livre->getTextAlternatif(); ?></textarea>
    </div>
    <img id="image-preview" src="<?= SITE_URL ?>images/<?= $livre->getUrlImage(); ?>" alt="<?= $livre->getTextAlternatif(); ?>">
    <div class="form-group my-4">
        <label for="image">Image : </label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <input type="hidden" name="id_livre" value="<?= $livre->getId(); ?>">
    <button class="btn btn-info">Modifier livre</button>
</form>

<?php
$titre = "Modifier le livre " . $livre->getTitre();
$content = ob_get_clean();
require_once 'template.php';
