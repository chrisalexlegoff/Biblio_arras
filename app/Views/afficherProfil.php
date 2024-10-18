<?php ob_start() ?>
<div class="d-flex flex-column justify-content-center">
    <?php require '../app/Views/showAlert.php'; ?>

    <form class="m-auto w-50" method="post" action="<?= SITE_URL ?>profil/m/<?= $utilisateur->getIdUtilisateur() ?>">
        <fieldset>
            <div class="form-group">
                <label for="identifiant" class="form-label mt-4">Identifiant : </label>
                <input type="text" name="identifiant" class="form-control" id="identifiant"
                    value="<?= isset($_SESSION['old_values']['identifiant']) ? htmlspecialchars($_SESSION['old_values']['identifiant']) : htmlspecialchars($utilisateur->getIdentifiant()) ?>" required>
                <?php if (isset($_SESSION['erreurs']['identifiant'])): ?>
                    <div class="text-danger">
                        <?php foreach ($_SESSION['erreurs']['identifiant'] as $erreur): ?>
                            <p><?= htmlspecialchars($erreur) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email" class="form-label mt-4">Email : </label>
                <input type="email" name="email" class="form-control" id="email"
                    value="<?= isset($_SESSION['old_values']['email']) ? htmlspecialchars($_SESSION['old_values']['email']) : htmlspecialchars($utilisateur->getEmail()) ?>" required>
                <?php if (isset($_SESSION['erreurs']['email'])): ?>
                    <div class="text-danger">
                        <?php foreach ($_SESSION['erreurs']['email'] as $erreur): ?>
                            <p><?= htmlspecialchars($erreur) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password" class="form-label mt-4">Mot de passe (laisser vide si inchangé) : </label>
                <input type="password" name="password" class="form-control" id="password"
                    placeholder="Votre nouveau mot de passe" autocomplete="off">
                <?php if (isset($_SESSION['erreurs']['password'])): ?>
                    <div class="text-danger">
                        <?php foreach ($_SESSION['erreurs']['password'] as $erreur): ?>
                            <p><?= htmlspecialchars($erreur) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password_check" class="form-label mt-4">Confirmer le mot de passe : </label>
                <input type="password" name="password_check" class="form-control" id="password_check"
                    placeholder="Répétez votre nouveau mot de passe" autocomplete="off">
                <?php if (isset($_SESSION['erreurs']['password_check'])): ?>
                    <div class="text-danger">
                        <?php foreach ($_SESSION['erreurs']['password_check'] as $erreur): ?>
                            <p><?= htmlspecialchars($erreur) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?= $csrfToken ?>
            <button type="submit" class="btn btn-primary mt-4">Mettre à jour</button>
        </fieldset>
    </form>
</div>

<?php
$titre = "Modification Profil";
$content = ob_get_clean();
require_once 'template.php';
