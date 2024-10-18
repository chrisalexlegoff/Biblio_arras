<?php ob_start(); ?>
<?php require '../app/Views/showAlert.php'; ?>

<div class="d-flex flex-column justify-content-center">
    <form method="POST" action="<?= SITE_URL ?>livres/av" enctype="multipart/form-data">
        <div class="form-group my-4">
            <label for="titre">Titre : </label>
            <input type="text" class="form-control" id="titre" name="titre"
                value="<?= isset($_SESSION['old_values']['titre']) ? htmlspecialchars($_SESSION['old_values']['titre']) : '' ?>">
            <?php if (isset($_SESSION['erreurs']['titre'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['erreurs']['titre'] as $erreur): ?>
                        <p><?= htmlspecialchars($erreur) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group my-4">
            <label for="nbre-de-pages">Nombre de pages : </label>
            <input type="number" class="form-control" id="nbre-de-pages" name="nbre-de-pages"
                value="<?= isset($_SESSION['old_values']['nbre-de-pages']) ? htmlspecialchars($_SESSION['old_values']['nbre-de-pages']) : '' ?>">
            <?php if (isset($_SESSION['erreurs']['nbre-de-pages'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['erreurs']['nbre-de-pages'] as $erreur): ?>
                        <p><?= htmlspecialchars($erreur) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group my-4">
            <label for="text-alternatif">Texte alternatif : </label>
            <textarea class="form-control" id="text-alternatif" name="text-alternatif"><?= isset($_SESSION['old_values']['text-alternatif']) ? htmlspecialchars($_SESSION['old_values']['text-alternatif']) : '' ?></textarea>
            <?php if (isset($_SESSION['erreurs']['text-alternatif'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['erreurs']['text-alternatif'] as $erreur): ?>
                        <p><?= htmlspecialchars($erreur) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <img src="" id="image-preview" alt="">
        <div class="form-group my-4">
            <label for="image">Image : </label>
            <input type="file" class="form-control-file" id="image" name="image">
            <?php if (isset($_SESSION['erreurs']['image'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['erreurs']['image'] as $erreur): ?>
                        <p><?= htmlspecialchars($erreur) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?= $csrfToken ?>
        <button class="btn btn-info">Créer livre</button>
    </form>
</div>

<?php
$titre = "Ajout livre";
$content = ob_get_clean();
require_once 'template.php';
