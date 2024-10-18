<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Service\Csrf;
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

    public function afficherInscription()
    {
        if ($this->isRoleAdmin() || $this->isRoleUser()) {
            header('location: ' . SITE_URL . 'livres');
        }
        $csrfToken = Csrf::token();
        require '../app/Views/afficherInscription.php';
    }

    public function afficherGestionMembres()
    {
        if (!$this->isRoleAdmin()) header('location: ' . SITE_URL . 'connexion');
        $utilisateurs = $this->utilisateurRepository->getAllUtilisateurs();
        $pasDutilisateur = (count($utilisateurs) > 0) ? false : true;
        if (empty($_SESSION['alert'])) $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Bienvenue " . $_SESSION['utilisateur']['identifiant']
        ];
        require "../app/Views/afficherGestionUtilisateurs.php";
    }

    public function modifierUtilisateurByAdmin($iDutilisateur)
    {
        $resultat = $this->utilisateurRepository->modifierUtilisateurByAdminInBdd($iDutilisateur);
        if ($resultat) {
            $_SESSION['alert'] = [
                "type" => "success",
                "message" => "L'utilisateur " . $_POST['identifiant'] . " a bien été modifié."
            ];
            header('location: ' . SITE_URL . 'gestion-membres');
        } else {
            $_SESSION['erreurs']['update-utilisateur'][] = 'Erreur de modification';
            header('location: ' . SITE_URL . 'gestion-membres');
            exit;
        }
    }

    public function supprimerUtilisateurByAdmin($iDutilisateur)
    {
        $resultat = $this->utilisateurRepository->supprimerUtilisateurByAdminInBdd($iDutilisateur);
        if ($resultat) {
            $_SESSION['alert'] = [
                "type" => "success",
                "message" => "L'utilisateur a bien été supprimé."
            ];
            header('location: ' . SITE_URL . 'gestion-membres');
        } else {
            $_SESSION['erreurs']['delete-utilisateur'][] = 'Erreur de suppression';
            header('location: ' . SITE_URL . 'gestion-membres');
            exit;
        }
    }

    public function afficherProfil()
    {
        $csrfToken = Csrf::token();
        $utilisateur = $this->utilisateurRepository->getUtilisateurByEmail($_SESSION['utilisateur']['email']);
        require '../app/Views/afficherProfil.php';
        if (array_key_exists('alert', $_SESSION)) unset($_SESSION['alert']);
    }

    public function modificationProfil($idUtilisateur)
    {
        Csrf::check();
        unset($_SESSION['erreurs']);
        unset($_SESSION['old_values']); // Reset des anciennes valeurs

        $erreurs = $this->validationDonnees->valider([
            'identifiant' => ['match:/^[a-zA-Z\-]+$/'],
            'email' => ['match:/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'],
            'password' => (!empty($_POST['password'])) ? ['match:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{12,}$/'] : [],
        ], $_POST);

        if ($_POST['password_check'] !== $_POST['password']) {
            $_SESSION['erreurs']['password_check'][] = 'Les 2 mots de passe ne correspondent pas!';
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'profil');
            exit;
        }

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'profil');
            exit;
        }

        $_POST['email'] = trim(htmlspecialchars($_POST['email']));
        $_POST['password'] = trim(htmlspecialchars($_POST['password']));
        $utilisateur = $this->utilisateurRepository->modifierUtilisateurBdd($idUtilisateur);

        if ($utilisateur) {
            $_SESSION['utilisateur']['email'] = $utilisateur->getEmail();
            $_SESSION['utilisateur']['identifiant'] = $utilisateur->getIdentifiant();
            $_SESSION['alert'] = [
                "type" => "success",
                "message" => "Votre profil a bien été modifié."
            ];
            header('location: ' . SITE_URL . 'profil');
        } else {
            $_SESSION['erreurs']['update-utilisateur'][] = 'Erreur de modification';
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'profil');
            exit;
        }
    }

    public function afficherConnexion()
    {
        if ($this->isRoleAdmin() || $this->isRoleUser()) {
            header('location: ' . SITE_URL . 'livres');
        }
        $csrfToken = Csrf::token();
        require '../app/Views/afficherConnexion.php';
        if (array_key_exists('alert', $_SESSION)) unset($_SESSION['alert']);
    }

    public function logout()
    {
        if (isset($_SESSION['utilisateur'])) {
            unset($_SESSION['utilisateur']);
        }
        header('location: ' . SITE_URL . '');
    }

    public function inscriptionValidation()
    {
        CSRF::check();
        unset($_SESSION['erreurs']);
        unset($_SESSION['old_values']); // Reset des anciennes valeurs

        $erreurs = $this->validationDonnees->valider([
            'identifiant' => ['match:/^[a-zA-Z\-]+$/'],
            'email' => ['match:/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'],
            'password' => ['match:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{12,}$/'],
        ], $_POST);

        if ($_POST['password_check'] !== $_POST['password']) {
            $_SESSION['erreurs']['password_check'][] = 'Les 2 mots de passe ne correspondent pas!';
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'inscription');
            exit;
        }

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'inscription');
            exit;
        }

        $_POST['email'] = trim(htmlspecialchars($_POST['email']));
        $_POST['password'] = trim(htmlspecialchars($_POST['password']));
        $resultat = $this->utilisateurRepository->setUtilisateurBdd();

        if ($resultat) {
            $_SESSION['alert'] = [
                "type" => "success",
                "message" => "Merci " . $_POST['identifiant'] . ", votre compte a été créé, en attente de validation ..."
            ];
            header('location: ' . SITE_URL . 'connexion');
        } else {
            $_SESSION['erreurs']['email'][] = 'Email ou mot de passe incorrect';
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'inscription');
            exit;
        }
    }

    public function connexionValidation()
    {
        CSRF::check();
        unset($_SESSION['erreurs']);
        unset($_SESSION['old_values']); // Reset des anciennes valeurs

        $erreurs = $this->validationDonnees->valider([
            'email' => ['match:/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'],
            'password' => ['match:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{12,}$/'],
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'connexion');
            exit;
        }

        $_POST['email'] = trim(htmlspecialchars($_POST['email']));
        $_POST['password'] = trim(htmlspecialchars($_POST['password']));
        $utilisateur = $this->utilisateurRepository->getUtilisateurByEmail($_POST['email']);

        if ($utilisateur) {
            if (password_verify($_POST['password'], $utilisateur->getPassword())) {
                $_SESSION['utilisateur']['id_utilisateur'] = $utilisateur->getIdUtilisateur();
                $_SESSION['utilisateur']['email'] = $utilisateur->getEmail();
                $_SESSION['utilisateur']['role'] = $utilisateur->getRole();
                $_SESSION['utilisateur']['identifiant'] = $utilisateur->getIdentifiant();
                $_SESSION['utilisateur']['is_valide'] = $utilisateur->getIsValide();
                if ($this->isRoleAdmin()) {
                    header('location: ' . SITE_URL . 'gestion-membres');
                } else {
                    header('location: ' . SITE_URL . 'livres');
                }
            } else {
                $_SESSION['erreurs']['connexion'][] = 'Email ou mot de passe incorrect';
                $_SESSION['old_values'] = $_POST;
                header('location: ' . SITE_URL . 'connexion');
                exit;
            }
        } else {
            $_SESSION['erreurs']['connexion'][] = 'Email ou mot de passe incorrect';
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'connexion');
            exit;
        }
    }

    public function isRoleUser(): bool
    {
        if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'ROLE_USER' && $_SESSION['utilisateur']['is_valide']) {
            return true;
        }
        if (isset($_SESSION['utilisateur']) && !$_SESSION['utilisateur']['is_valide']) $_SESSION['alert'] = [
            "type" => "warning",
            "message" => "Désolé " . $_SESSION['utilisateur']['identifiant'] . ", votre compte n'est pas activé, veuillez contacter l'administrateur"
        ];
        return false;
    }

    public function isRoleAdmin(): bool
    {
        if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'ROLE_ADMIN') {
            return true;
        }
        return false;
    }

    public function redirectLogin()
    {
        $isAdmin = $this->isRoleAdmin();
        $isUser = $this->isRoleUser();
        if (!$isAdmin && !$isUser) {
            header('location: ' . SITE_URL . 'connexion');
            exit;
        }
    }
}
