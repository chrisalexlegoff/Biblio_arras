<?php ob_start() ?>

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
            <td class="align-middle"><img src="images/<?= $livre->getUrlImage(); ?>" style="height: 60px;" ; alt="texte-alternatif"></td>
            <td class="align-middle">
                <a href="<?= SITE_URL ?>livres/l/<?= $livre->getId() ?>"><?= $livre->getTitre() ?></a>
            </td>
            <td class="align-middle"><?= $livre->getNbreDePages(); ?></td>
            <td class="align-middle"><a href="#" class="btn btn-warning">Modifier</a> </td>
            <td class="align-middle"><a href="#" class="btn btn-danger">Supprimer</a> </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="#" class="btn btn-success d-block w-100">Ajouter</a>

<?php

$titre = "Livres";
$content = ob_get_clean();
require_once 'template.php';
