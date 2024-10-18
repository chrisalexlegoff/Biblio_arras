<?php ob_start() ?>
<?php require '../app/Views/showErreurs.php'; ?>
<?php require '../app/Views/showAlert.php'; ?>
<?php if (!$pasDutilisateur) : ?>
    <div class="d-flex flex-column justify-content-center">
        <?php require '../app/Views/showAlert.php'; ?>
        <table class="table test-center">
            <tr class="table-dark">
                <th>Id</th>
                <th>Identifiant</th>
                <th>email</th>
                <th>role</th>
                <th>valide</th>
                <th colspan="2">Actions</th>
            </tr>
            <?php
            foreach ($utilisateurs as $utilisateur) : ?>
                <tr>
                    <td class="align-middle"><?= $utilisateur->getIdUtilisateur(); ?></td>
                    <td class="align-middle"><?= $utilisateur->getIdentifiant(); ?></td>
                    <td class="align-middle"><?= $utilisateur->getEmail(); ?></td>
                    <form method="post" action="<?= SITE_URL ?>gestion-membres/m/<?= $utilisateur->getIdUtilisateur() ?>">
                        <input type="hidden" name='identifiant' value=<?= $utilisateur->getIdentifiant() ?>>
                        <td class="align-middle">
                            <!-- Liste déroulante pour le rôle -->
                            <select name="role" class="form-select">
                                <option value="ROLE_USER" <?= $utilisateur->getRole() == 'ROLE_USER' ? 'selected' : ''; ?>>Utilisateur</option>
                                <option value="ROLE_ADMIN" <?= $utilisateur->getRole() == 'ROLE_ADMIN' ? 'selected' : ''; ?>>Administrateur</option>
                            </select>
                        </td>

                        <td class="align-middle">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="isValide_<?= $utilisateur->getIdUtilisateur(); ?>" name="isValide" <?= $utilisateur->getIsValide() ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="isValide_<?= $utilisateur->getIdUtilisateur(); ?>">
                                    <?= $utilisateur->getIsValide() ? 'Validé' : 'Non validé'; ?>
                                </label>
                            </div>
                        </td>

                        <td class="align-middle">
                            <button class="btn btn-warning">Modifier</button>
                        </td>
                    </form>
                    <td class="align-middle">
                        <form method="post"
                            action="<?= SITE_URL ?>gestion-membres/s/<?= $utilisateur->getIdUtilisateur(); ?>"
                            onSubmit="return confirm('Voulez-vous vraiment supprimer l'utilisateur : <?= $utilisateur->getIdentifiant(); ?> ?');">
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <div class="d-flex flex-column">
            <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
                <div class="alert alert-primary">Pas encore de membres</div>
            </div>
        <?php endif; ?>
        </div>
        <?php
        $titre = "Gestion utilisateurs";
        $content = ob_get_clean();
        require_once 'template.php';
        ?>