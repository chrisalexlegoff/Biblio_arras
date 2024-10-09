<?php ob_start() ?>

<?php if (!$pasDeLivre) : ?>

    <table class="table test-center">
        <tr class="table-dark">
            <th>Image</th>
            <th>Titre</th>
            <th>Nombre de pages</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php
        // $livresTab = $repositoryLivres->getLivres();

        foreach ($livresTab as $livre) : ?>
            <tr>
                <td class="align-middle"><img src="<?= SITE_URL ?>images/<?= $livre->getUrlImage(); ?>" style="height: 60px;" ; alt="texte-alternatif"></td>
                <td class="align-middle">
                    <a href="<?= SITE_URL ?>livres/l/<?= $livre->getId() ?>"><?= $livre->getTitre() ?></a>
                </td>
                <td class="align-middle"><?= $livre->getNbreDePages(); ?></td>
                <td class="align-middle"><a href="#" class="btn btn-warning">Modifier</a> </td>

                <td class="align-middle">
                    <form method="post" action="<?= SITE_URL ?>livres/s/<?= $livre->getId(); ?>"
                        onSubmit="return confirm('Voulez-vous vraiment supprimer le livre <?= $livre->getTitre(); ?> ?');">
                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>
    <a href="<?= SITE_URL ?>livres/a" class="btn btn-success d-block w-100">Ajouter</a>
<?php else : ?>
    <div class="d-flex flex-column">
        <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
            <div class="card-header">Votre espace</div>
            <div class="card-body">
                <h4 class="card-title">Désolé</h4>
                <p class="card-text">Il semble que vous n'ayez pas encore uploader de livre dans votre espace.</p>
                <p class="card-text">Pour y remédier, utilisez le bouton ci-dessous...</p>
            </div>
        </div>
        <a href="<?= SITE_URL ?>livres/a" class="btn btn-success d-block w-100">Ajouter</a>
    </div>
<?php endif; ?>
<?php
$titre = "Livres";
$content = ob_get_clean();
require_once 'template.php';
