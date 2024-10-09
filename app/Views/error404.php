<?php ob_start() ?>


<p><?= $message ?>&nbsp;</p>
<p>Contacter l'administrateur : <a href="mailto:contact@monsite.fr">ici</a></p>

<?php
$titre = "Page introuvable";
$content = ob_get_clean();
require_once 'template.php';
