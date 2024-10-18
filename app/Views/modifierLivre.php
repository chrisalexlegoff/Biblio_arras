<?php ob_start() ?>
<?php require '../app/Views/showAlert.php'; ?>

<div class="d-flex flex-column justify-content-center">
    <form method="POST" action="<?= SITE_URL ?>livres/mv" enctype="multipart/form-data">
        <div class="form-group my-4">
            <label for="titre">Titre : </label>
            <input type="text" value="<?= isset($_SESSION['old_values']['titre']) ? htmlspecialchars($_SESSION['old_values']['titre']) : htmlspecialchars($livre->getTitre()); ?>" class="form-control" id="titre" name="titre">
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
            <input type="number" value="<?= isset($_SESSION['old_values']['nbre-de-pages']) ? htmlspecialchars($_SESSION['old_values']['nbre-de-pages']) : htmlspecialchars($livre->getNbreDePages()); ?>" class="form-control" id="nbre-de-pages" name="nbre-de-pages">
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
            <textarea class="form-control" id="text-alternatif" name="text-alternatif"><?= isset($_SESSION['old_values']['text-alternatif']) ? htmlspecialchars($_SESSION['old_values']['text-alternatif']) : htmlspecialchars($livre->getTextAlternatif()); ?></textarea>
            <?php if (isset($_SESSION['erreurs']['text-alternatif'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['erreurs']['text-alternatif'] as $erreur): ?>
                        <p><?= htmlspecialchars($erreur) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <img id="image-preview" src="<?= SITE_URL ?>images/<?= htmlspecialchars($livre->getUrlImage()); ?>" alt="<?= htmlspecialchars($livre->getTextAlternatif()); ?>">
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
        <input type="hidden" name="id_livre" value="<?= htmlspecialchars($livre->getId()); ?>">
        <?= $csrfToken ?>
        <button class="btn btn-info">Modifier livre</button>
    </form>
</div>

<?php
$titre = "Modifier le livre " . htmlspecialchars($livre->getTitre());
$content = ob_get_clean();
require_once 'template.php';
