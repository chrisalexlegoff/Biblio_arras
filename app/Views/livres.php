<?php

use App\Models\Livre as ModelsLivre;

$l1 = new ModelsLivre(1, "In My Head", 567, "images/in-my-head.png", "Image de couverture du livre in my head");
$l2 = new ModelsLivre(2, "Le dev fou", 5676, "/images/le_dev_fou.png", "Image de couverture du livre le dev fou");
$l3 = new ModelsLivre(3, "Mon futur site web", 57, "/images/mon-futur-site-web.png", "Image de couverture du livre mon futur site web");

$livres = [$l1, $l2, $l3];

?>

<?php ob_start() ?>

<table class="table test-center">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions</th>
    </tr>
    <tr>
        <td class="align-middle"><img src="images/in-my-head.png" style="height: 60px;" ; alt="texte-alternatif"></td>
        <td class="align-middle">In my Head</td>
        <td class="align-middle">345</td>
        <td class="align-middle"><a href="#" class="btn btn-warning">Modifier</a> </td>
        <td class="align-middle"><a href="#" class="btn btn-danger">Supprimer</a> </td>
    </tr>
    <tr>
        <td class="align-middle"><img src="images/le_dev_fou.png" style="height: 60px;" ; alt="texte-alternatif"></td>
        <td class="align-middle">Le dev fou</td>
        <td class="align-middle">8999</td>
        <td class="align-middle"><a href="#" class="btn btn-warning">Modifier</a> </td>
        <td class="align-middle"><a href="#" class="btn btn-danger">Supprimer</a> </td>
    </tr>
</table>
<a href="#" class="btn btn-success d-block w-100">Ajouter</a>

<?php

$titre = "Livres";
$content = ob_get_clean();
require_once 'template.php';
