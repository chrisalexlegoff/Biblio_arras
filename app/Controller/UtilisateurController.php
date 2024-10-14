<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Service\ValidationDonnees;

class UtilisateurController
{
    private UtilisateurRepository $utilisateurRepository;
    private ValidationDonnees $validationDonnees;

    public function __construct()
    {
        $this->utilisateurRepository = new UtilisateurRepository();
        $this->validationDonnees = new ValidationDonnees();
    }

    public function afficherConnexion()
    {
        require '../app/Views/afficherConnexion.php';
    }

    public function connexionValidation()
    {
        $erreurs = $this->validationDonnees->valider([
            'email' => ['required', 'match:/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'],
            'password' => ['required', 'match:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{12,}$/'],
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'][] = $erreurs;
            header('location: ' . SITE_URL . 'login');
            exit;
        }
        // recupération utilisateur
        $utilisateur = $this->utilisateurRepository->getUtilisateurByEmail($_POST['email']);
        // debug($utilisateur);
        // vérifier email password
        if ($utilisateur) {
            if (password_verify($_POST['password'], $utilisateur->getPassword())) {
                echo 'Connexion réussie';
            }
        } else {
            $_SESSION['erreurs'][] = [['email' => 'Email ou mot de passe incorrect']];
            header('location: ' . SITE_URL . 'login'); // on redirige vers la page d'ajout
            exit;
        }
    }
}
