<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LivresRepository;
use App\Service\Utils;
use App\Service\ValidationDonnees;

class LivreController
{
    private LivresRepository $repositoryLivres;
    private ValidationDonnees $validationDonnees;

    public function __construct()
    {
        $this->repositoryLivres = new LivresRepository();
        $this->repositoryLivres->chargementLivresBdd();
        $this->validationDonnees = new ValidationDonnees();
    }

    public function afficherLivres()
    {
        $livresTab = $this->repositoryLivres->getLivres();
        $pasDeLivre = (count($livresTab) > 0) ? false : true;
        require "../app/Views/livres.php";
    }

    public function afficherUnLivre($idLivre)
    {
        $livre = $this->repositoryLivres->getLivreById($idLivre);
        ($livre !== null) ? require "../app/Views/afficherlivre.php" : require "../app/Views/error404.php";
    }

    public function ajouterLivre()
    {
        // $_SESSION['datas'] = (!empty($_POST)) ? $_POST : [];
        require '../app/Views/ajouterLivre.php';
    }

    public function validationAjoutLivre()
    {

        $_SESSION['datas'] = (!empty($_POST)) ? $_POST : [];

        $erreurs = $this->validationDonnees->valider([
            // 'titre' => ['min:3', 'required']
            'titre' => ['match:/^[A-Z][a-zA-Z\- ]{3,25}$/'],
            'nbre-de-pages' => ['match:/^\d{1,10}$/'],
            'text-alternatif' => ['match:/^[a-zA-Z.\-\'\"\s]{10,150}$/']
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'][] = $erreurs;
            header('location: ' . SITE_URL . 'livres/a');
            exit;
        }
        $image = $_FILES['image'];
        $repertoire = "images/";
        $nomImage = Utils::ajoutImage($image, $repertoire);
        // $_POST['titre']  = htmlspecialchars()

        $this->repositoryLivres->ajouterLivreBdd($_POST['titre'], (int)$_POST['nbre-de-pages'], $_POST['text-alternatif'], $nomImage);
        // unset($_SESSION['datas']);
        header('location: ' . SITE_URL . 'livres');
    }

    public function modifierLivre($idLivre)
    {
        $livre = $this->repositoryLivres->getLivreById($idLivre);
        require '../app/Views/modifierLivre.php';
    }

    public function validationModifierLivre()
    {
        $erreurs = $this->validationDonnees->valider([
            // 'titre' => ['min:3', 'required']
            'titre' => ['match:/^[A-Z][a-zA-Z\- ]{3,25}$/'],
            'nbre-de-pages' => ['match:/^\d{1,10}$/'],
            'text-alternatif' => ['match:/^[a-zA-Z.\-\'\"\s]{10,150}$/']
        ], $_POST);

        if (is_array($erreurs) && count($erreurs) > 0) {
            $_SESSION['erreurs'][] = $erreurs;
            header('location: ' . SITE_URL . 'livres/a');
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
        header('location: ' . SITE_URL . 'livres');
    }

    public function supprimerLivre($idLivre)
    {
        $nomImage = $this->repositoryLivres->getLivreById($idLivre)->getUrlImage();
        $filename = "images/$nomImage";
        if (file_exists($filename)) {
            unlink($filename);

        }
        $this->repositoryLivres->supprimerLivreBdd($idLivre);
        header('location: ' . SITE_URL . 'livres');
    }
}
