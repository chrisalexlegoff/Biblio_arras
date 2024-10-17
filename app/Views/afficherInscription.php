<?php ob_start() ?>
<?php require '../app/Views/showErreurs.php'; ?>
<?php require '../app/Views/showAlert.php'; ?>
<div class="d-flex flex-column justify-content-center">
    <form class="m-auto w-50" method="post" action="<?= SITE_URL ?>inscription/v">
        <fieldset>
            <legend>Inscription</legend>
            <div class="form-group">
                <label for="identifiant" class="form-label mt-4">Identifiant : </label>
                <input type="text" autofocus name="identifiant" class="form-control" id="identifiant" aria-describedby="identifiantHelp" placeholder="Votre adressse mail">
            </div>
            <div class="form-group">
                <label for="email" class="form-label mt-4">Email : </label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Votre adressse mail">
            </div>
            <div class="form-group">
                <label for="password" class="form-label mt-4">Mot de passe : </label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Votre mot de passe" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password_check" class="form-label mt-4">Mot de passe : </label>
                <input type="password" name="password_check" class="form-control" id="password_check" placeholder="Répéter votre mot de passe" autocomplete="off">
            </div>
            <?= $csrfToken ?>
            <button type="submit" class="btn btn-primary mt-2">Se connecter</button>
        </fieldset>
    </form>
</div>
<?php
$titre = "Inscription";
$content = ob_get_clean();
require_once 'template.php';

