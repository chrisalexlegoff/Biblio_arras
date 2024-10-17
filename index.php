<?php

declare(strict_types=1);

session_start();
use App\Controller\LivreController;
use App\Controller\UtilisateurController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();
require __DIR__ . '/app/lib/init.php';
require __DIR__ . '/app/lib/functions.php';
?>
<?php
// echo password_hash('mon_password', PASSWORD_BCRYPT);
$livreController = new LivreController();
$utilisateurController = new UtilisateurController();
try {
    if (empty($_GET['page'])) {
        $livreController->getAllLivres();
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case 'livres':
                if (empty($url[1])) {
                    $livreController->afficherLivres();
                } elseif ($url[1] === 'l') {
                    $livreController->afficherUnLivre((int)$url[2]);
                } elseif ($url[1] === 'a') {
                    $livreController->ajouterLivre();
                } elseif ($url[1] === 'av') {
                    $livreController->validationAjoutLivre();
                } elseif ($url[1] === 'm') {
                    $livreController->modifierLivre((int)$url[2]);
                } elseif ($url[1] === 'mv') {
                    $livreController->validationModifierLivre();
                } elseif ($url[1] === 's') {
                    $livreController->supprimerLivre((int)$url[2]);
                } else {
                    throw new Exception("La page n'existe pas");
                }
                break;
            case 'connexion':
                if (empty($url[1])) {
                    $utilisateurController->afficherConnexion();
                } elseif ($url[1] === 'v') {
                    $utilisateurController->connexionValidation();
                }
                break;
            case 'profil':
                if (empty($url[1])) {
                    $utilisateurController->afficherProfil();
                } elseif ($url[1] === 'm') {
                    $utilisateurController->modificationProfil($url[2]);
                }
                break;
            case 'inscription':
                if (empty($url[1])) {
                    $utilisateurController->afficherInscription();
                } elseif ($url[1] === 'v') {
                    $utilisateurController->inscriptionValidation();
                }
                break;
            case 'gestion-membres':
                if (empty($url[1])) {
                    $utilisateurController->afficherGestionMembres();
                } elseif ($url[1] === 'm') {
                    $utilisateurController->modifierUtilisateurByAdmin((int)$url[2]);
                } elseif ($url[1] === 's') {
                    $utilisateurController->supprimerUtilisateurByAdmin((int)$url[2]);
                }
                    break;
            case 'deconnexion':
                $utilisateurController->logout();
                break;
            default:
                throw new Exception("La page n'existe pas");
                break;
        }
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    include '../app/Views/error404.php';
}
