<?php ob_start() ?>


<p>Le contenu n'est plus disponible</p>
<p>Contacter l'administrateur : <a href="mailto:contact@monsite.fr">ici</a></p>

<?php
$titre = "Page introuvable";
$content = ob_get_clean();
require_once 'template.php';
