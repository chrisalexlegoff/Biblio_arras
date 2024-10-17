<?php ob_start() ?>
<div class="d-flex flex-column justify-content-center">
    <form class="m-auto w-50" method="post" action="<?= SITE_URL ?>profil/m/<?= $utilisateur->getIdentifiant() ?>">
        <fieldset>
            <!-- Champ Identifiant -->
            <div class="form-group">
                <label for="identifiant" class="form-label mt-4">Identifiant : </label>
                <input type="text" name="identifiant" class="form-control" id="identifiant" 
                       value="<?= htmlspecialchars($utilisateur->getIdentifiant()) ?>" required>
            </div>
            
            <!-- Champ Email -->
            <div class="form-group">
                <label for="email" class="form-label mt-4">Email : </label>
                <input type="email" name="email" class="form-control" id="email" 
                       value="<?= htmlspecialchars($utilisateur->getEmail()) ?>" required>
            </div>
            
            <!-- Champ Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label mt-4">Mot de passe (laisser vide si inchangé) : </label>
                <input type="password" name="password" class="form-control" id="password" 
                       placeholder="Votre nouveau mot de passe" autocomplete="off">
            </div>
            
            <!-- Champ de confirmation du mot de passe -->
            <div class="form-group">
                <label for="password_check" class="form-label mt-4">Confirmer le mot de passe : </label>
                <input type="password" name="password_check" class="form-control" id="password_check" 
                       placeholder="Répétez votre nouveau mot de passe" autocomplete="off">
            </div>
            
            <!-- CSRF Token (nécessaire pour la sécurité) -->
            <?= $csrfToken ?>
            
            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary mt-4">Mettre à jour</button>
        </fieldset>
    </form>
</div>

<?php
$titre = "Modification Profil";
$content = ob_get_clean();
require_once 'template.php';
?>
