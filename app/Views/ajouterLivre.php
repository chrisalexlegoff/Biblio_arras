<?php ob_start();?>
<?php print_r($_POST) ?>
<?php require '../app/Views/showErreurs.php'; ?>

<form method="POST" action="<?= SITE_URL ?>livres/av" enctype="multipart/form-data">
    <div class="form-group my-4">
        <label for="titre">Titre : </label>
        <input type="text" value="<?=  (array_key_exists('titre', $_SESSION['datas'])) ? $_SESSION['datas']['titre'] : "" ?>" class="form-control" id="titre" name="titre">
    </div>
    <div class="form-group my-4">
        <label for="nbre-de-pages">Nombre de pages : </label>
        <input type="number" value="<?=  (array_key_exists('nbre-de-pages', $_SESSION['datas'])) ? $_SESSION['datas']['nbre-de-pages'] : "" ?>" class="form-control" id="nbre-de-pages" name="nbre-de-pages">
    </div>
    <div class="form-group my-4">
        <label for="text-alternatif">Texte alternatif : </label>
        <textarea class="form-control" value="<?=  (array_key_exists('text-alternatif', $_SESSION['datas'])) ? $_SESSION['datas']['text-alternatif'] : "" ?>" id="text-alternatif" name="text-alternatif"></textarea>
    </div>
    <img src="" id="image-preview"  alt="">
    <div class="form-group my-4">
        <label for="image">Image : </label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <button class="btn btn-info">Créer livre</button>
</form>

<?php
$titre = "Ajout livre";
$content = ob_get_clean();
require_once 'template.php';
