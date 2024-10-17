<?php ob_start() ?>

<div class="d-flex flex-column justify-content-center"> 
<p><?= $message ?>&nbsp;</p>
<p>Contacter l'administrateur : <a href="mailto:contact@monsite.fr">ici</a></p>
</div>
<?php
$titre = "Page introuvable";
$content = ob_get_clean();
require_once 'template.php';
