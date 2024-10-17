<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;
use App\Models\Livre;
use App\Service\AbstractConnexion;

class LivresRepository extends AbstractConnexion
{
    /**
     * Tableau de livres
     *
     * @var array
     */
    private array $livres = [];

    public function ajouterLivre(object $nouveauLivre)
    {
        $this->livres[] = $nouveauLivre;
    }

    public function chargementLivresBdd()
    {
        // protection injection SQL
        $req = $this->getConnexionBdd()->prepare("SELECT id_livre, titre, nbre_de_pages, url_image, text_alternatif, l.id_utilisateur, identifiant FROM livre l LEFT JOIN utilisateur u ON l.id_utilisateur = u.id_utilisateur;");
        $req->execute();
        $livresImportes = $req->fetchALL(PDO::FETCH_ASSOC);
        $req->closeCursor();
        foreach ($livresImportes as $livre) {
            $newLivre = new Livre($livre['id_livre'], $livre['titre'], $livre['nbre_de_pages'], $livre['url_image'], $livre['text_alternatif'], $livre['id_utilisateur'], $livre['identifiant'] !== null ? $livre['identifiant'] : "Pas d'uploader");
            $this->ajouterLivre($newLivre);
        }
        return $this->getLivres();
    }

    public function getLivresByIdUtilisateur($idUtilisateur)
    {
        // protection injection SQL
        $req = $this->getConnexionBdd()->prepare("SELECT * FROM livre WHERE id_utilisateur = ?");
        $req->execute([$idUtilisateur]);
        $livresImportes = $req->fetchALL(PDO::FETCH_ASSOC);
        $req->closeCursor();
        foreach ($livresImportes as $livre) {
            $newLivre = new Livre($livre['id_livre'], $livre['titre'], $livre['nbre_de_pages'], $livre['url_image'], $livre['text_alternatif'], $livre['id_utilisateur'], $_SESSION['utilisateur']['identifiant']);
            $this->ajouterLivre($newLivre);
        }
        return $this->getLivres();
    }

    public function getLivreById($idLivre)
    {
        $req = $this->getConnexionBdd()->prepare("SELECT l.id_livre, l.titre, l.nbre_de_pages, l.url_image, l.text_alternatif, l.id_utilisateur, u.identifiant FROM livre l LEFT JOIN utilisateur u ON l.id_utilisateur = u.id_utilisateur WHERE l.id_livre = ?");
        $req->execute([$idLivre]);
        $livresImportes = $req->fetchALL(PDO::FETCH_ASSOC);
        $req->closeCursor();
        foreach ($livresImportes as $livre) {
            $livre = new Livre($livre['id_livre'], $livre['titre'], $livre['nbre_de_pages'], $livre['url_image'], $livre['text_alternatif'], $livre['id_utilisateur'], $livre['identifiant'] !== null ? $livre['identifiant'] : "Pas d'uploader");
            return $livre;
        }
    }

    public function ajouterLivreBdd(string $titre, int $nbreDePages, string $textAlternatif, string $nomImage)
    {
        // protection injection sql
        $idUtilisateur = $_SESSION['utilisateur']['id_utilisateur'];
        $req = "INSERT INTO livre (titre, nbre_de_pages, url_image ,text_alternatif, id_utilisateur) VALUES 
                (:titre, :nbre_de_pages, :url_image, :text_alternatif, :id_utilisateur)";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbre_de_pages", $nbreDePages, PDO::PARAM_INT);
        $stmt->bindValue(":url_image", $nomImage, PDO::PARAM_STR);
        $stmt->bindValue(":text_alternatif", $textAlternatif, PDO::PARAM_STR);
        $stmt->bindValue(":id_utilisateur", $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function modificationLivreBdd(string $titre, int $nbreDePages, string $textAlternatif, string $nomImage, int $idLivre)
    {
        $idUtilisateur = $_SESSION['utilisateur']['role'] !== 'ROLE_ADMIN' ? $_SESSION['utilisateur']['id_utilisateur'] : $this->getLivreById($idLivre)->getIdUtilisateur();
        // protection injection sql
        $req = "UPDATE livre SET titre = :titre, nbre_de_pages = :nbre_de_pages, text_alternatif = :text_alternatif, url_image = :url_image, id_utilisateur = :id_utilisateur WHERE id_livre = :id_livre";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":id_livre", $idLivre, PDO::PARAM_INT);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbre_de_pages", $nbreDePages, PDO::PARAM_INT);
        $stmt->bindValue(":url_image", $nomImage, PDO::PARAM_STR);
        $stmt->bindValue(":text_alternatif", $textAlternatif, PDO::PARAM_STR);
        $stmt->bindValue(":id_utilisateur", $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }


    public function supprimerLivreBdd($idLivre)
    {
        $req = "DELETE FROM livre WHERE id_livre = :id_livre";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":id_livre", $idLivre, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * Get All livres
     *
     * @return array
     */
    public function getLivres(): array
    {
        return $this->livres;
    }

    /**
     * Set the value of livres
     *
     * @param array $livres
     *
     * @return self
     */
    public function setLivres(array $livres): self
    {
        $this->livres = $livres;
        return $this;
    }
}
