<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Utils;
use App\Service\ValidationDonnees;
use App\Repository\LivresRepository;
use App\Controller\UtilisateurController;
use App\Service\Csrf;

class LivreController
{
    private LivresRepository $repositoryLivres;
    private ValidationDonnees $validationDonnees;
    private UtilisateurController $utilisateurController;

    public function __construct()
    {
        $this->repositoryLivres = new LivresRepository();
        $this->validationDonnees = new ValidationDonnees();
        $this->utilisateurController = new UtilisateurController();
        $isAdmin = $this->utilisateurController->isRoleAdmin();
        $isUser = $this->utilisateurController->isRoleUser();
        if ($isAdmin) {
            $this->repositoryLivres->chargementLivresBdd();
        } elseif ($isUser) {
            $this->repositoryLivres->getLivresByIdUtilisateur($_SESSION['utilisateur']['id_utilisateur']);
        }
    }

    public function afficherLivres()
    {
        $this->utilisateurController->redirectLogin();
        $livresTab = $this->repositoryLivres->getLivres();
        $pasDeLivre = (count($livresTab) > 0) ? false : true;
        if (empty($_SESSION['alert'])) $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Bienvenue " . $_SESSION['utilisateur']['identifiant']
        ];
        require "../app/Views/livres.php";
    }

    public function afficherUnLivre($idLivre)
    {
        $livre = $this->repositoryLivres->getLivreById($idLivre);
        if ($livre !== null) {
            require "../app/Views/afficherlivre.php";
            exit;
        }
        $message = "Le livre avec l'ID : $idLivre n'existe pas";
        require "../app/Views/error404.php";
    }

    public function ajouterLivre()
    {
        $this->utilisateurController->redirectLogin();
        $csrfToken = Csrf::token();
        require '../app/Views/ajouterLivre.php';
    }

    public function validationAjoutLivre()
    {
        Csrf::check();
        $this->utilisateurController->redirectLogin();
        unset($_SESSION['erreurs']);
        unset($_SESSION['old_values']);
        $erreurs = $this->validationDonnees->valider([
            'titre' => ['match:/^[A-Z][a-zA-Z\- ]{3,25}$/'],
            'nbre-de-pages' => ['match:/^\d{1,10}$/'],
            'text-alternatif' => ['match:/^[a-zA-Z.\-\'\"\s]{10,150}$/']
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'livres/a');
            exit;
        }

        $image = $_FILES['image'];
        $repertoire = "images/";
        $nomImage = Utils::ajoutImage($image, $repertoire);

        if (isset($_SESSION['erreurs']) && count($_SESSION['erreurs']) > 0) {
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'livres/a');
            exit;
        }

        $this->repositoryLivres->ajouterLivreBdd($_POST['titre'], (int)$_POST['nbre-de-pages'], $_POST['text-alternatif'], $nomImage);
        $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Le livre $_POST[titre] a été ajouté avec succès!"
        ];
        header('location: ' . SITE_URL . 'livres');
    }

    public function modifierLivre($idLivre)
    {
        $this->utilisateurController->redirectLogin();
        $livre = $this->repositoryLivres->getLivreById($idLivre);
        $csrfToken = Csrf::token();
        require '../app/Views/modifierLivre.php';
    }

    public function validationModifierLivre()
    {
        Csrf::check();
        unset($_SESSION['erreurs']);
        unset($_SESSION['old_values']);
        $erreurs = $this->validationDonnees->valider([
            'titre' => ['match:/^[A-Z][a-zA-Z\- ]{3,25}$/'],
            'nbre-de-pages' => ['match:/^\d{1,10}$/'],
            'text-alternatif' => ['match:/^[a-zA-Z.\-\'\"\s]{10,150}$/']
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['old_values'] = $_POST;
            header('location: ' . SITE_URL . 'livres/m/' . (int)$_POST['id_livre']);
            exit;
        }

        $idLivre = (int)$_POST['id_livre'];
        $imageActuelle = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage();
        $imageUpload = $_FILES['image'];
        $cheminImage = "images/$imageActuelle";
        if ($imageUpload['size'] > 0) {
            if (file_exists($cheminImage)) {
                unlink($cheminImage);
            }
            $imageActuelle = Utils::ajoutImage($imageUpload, "images/");
        }
        $this->repositoryLivres->modificationLivreBdd($_POST['titre'], (int)$_POST['nbre-de-pages'], $_POST['text-alternatif'], $imageActuelle, $idLivre);
        $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Le livre $_POST[titre] a été modifié avec succès!"
        ];
        header('location: ' . SITE_URL . 'livres');
    }

    public function supprimerLivre($idLivre)
    {
        $this->utilisateurController->redirectLogin();
        $livre = $this->repositoryLivres->getLivreById($idLivre);
        $nomImage = $livre->getUrlImage();
        $filename = "images/$nomImage";
        if (file_exists($filename)) {
            unlink($filename);
        }
        $this->repositoryLivres->supprimerLivreBdd($idLivre);
        $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Le livre " . $livre->getTitre() . " a été supprimé avec succès!"
        ];
        header('location: ' . SITE_URL . 'livres');
    }

    public function getAllLivres()
    {
        if (!$this->utilisateurController->isRoleAdmin() || !$this->utilisateurController->isRoleUser()) {
            $this->repositoryLivres->setLivres([]);
            $livresAll = $this->repositoryLivres->chargementLivresBdd();
        } else {
            $livresAll = $this->repositoryLivres->getLivres();
        }
        require '../app/Views/accueil.php';
    }
}
