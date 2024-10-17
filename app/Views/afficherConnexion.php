<?php ob_start() ?>
<?php require '../app/Views/showErreurs.php'; ?>
<?php require '../app/Views/showAlert.php'; ?>
<div class="d-flex flex-column justify-content-center">
    <form class="m-auto w-50" method="post" action="<?= SITE_URL ?>connexion/v">
        <fieldset>
            <legend>Connexion</legend>
            <div class="form-group">
                <label for="email" class="form-label mt-4">Email : </label>
                <input type="email" autofocus name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Votre adressse mail">
                <small id="emailHelp" class="form-text text-muted">Saisissez l'adresse mail choisie à l'inscription.</small>
            </div>
            <div class="form-group">
                <label for="password" class="form-label mt-4">Mot de passe : </label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Votre mot de passe" autocomplete="off">
            </div>
            <?= $csrfToken ?>
            <button type="submit" class="btn btn-primary mt-2">Se connecter</button>
        </fieldset>
    </form>
</div>
<?php
$titre = "Connexion";
$content = ob_get_clean();
require_once 'template.php';
