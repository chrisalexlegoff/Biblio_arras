<?php ob_start() ?>
<?php require '../app/Views/showErreurs.php'; ?>
<form method="POST" action="<?= SITE_URL ?>login/v">
  <fieldset>
    <div>
      <label for="email" class="form-label mt-4">adresse mail : </label>
      <input type="email" autofocus class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Entrer votre adresse mail">
    </div>
    <div>
      <label for="password" class="form-label mt-4">Mot de passe : </label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Entrer votre mot de passe" autocomplete="off">
    </div>
    <button type="submit" class="mt-4 btn btn-primary">Se connecter</button>
  </fieldset>
</form>
<?php
$titre = "Connexion";
$content = ob_get_clean();
require_once 'template.php';
