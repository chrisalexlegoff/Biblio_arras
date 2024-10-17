<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Utilisateur;
use PDO;
use App\Service\AbstractConnexion;

class UtilisateurRepository extends AbstractConnexion
{
    private Utilisateur $utilisateur;

    public function getUtilisateurByEmail(string $email)
    {
        $req = "SELECT * FROM utilisateur WHERE email = ?";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->execute([$email]);
        $utilisateurTab = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->CloseCursor();
        if (!$utilisateurTab) {
            return false;
        } else {
            $utilisateur = new Utilisateur($utilisateurTab['id_utilisateur'], $utilisateurTab['identifiant'], $utilisateurTab['password'], $utilisateurTab['email'], $utilisateurTab['role'], !$utilisateurTab['is_valide'] ? false : true);
            $this->setUtilisateur($utilisateur);
            return $this->getUtilisateur();
        }
    }

    public function modifierUtilisateurBdd($idUtilisateur) {
        $req = "UPDATE utilisateur SET identifiant = :identifiant, email = :email";
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $req .= ", password = :password";
        }
        $req .= " WHERE id_utilisateur = :id_utilisateur;";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":id_utilisateur", $idUtilisateur, PDO::PARAM_INT);
        $stmt->bindValue(":identifiant", $_POST['identifiant'], PDO::PARAM_STR);
        $stmt->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
        if (!empty($_POST['password'])) {
            $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        }
        $resultat = $stmt->execute();
        $stmt->CloseCursor();
        if (!$resultat) {
            return false;
        } 
        $utilisateur = $this->getUtilisateurByEmail($_POST['email']);
        return $utilisateur;
    }

    public function setUtilisateurBdd() {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $req = "INSERT INTO utilisateur (identifiant, password, email) VALUES(:identifiant, :password, :email);";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":identifiant", $_POST['identifiant'], PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->CloseCursor();
        if (!$resultat) {
            return false;
        } 
        return true;
    }

    public function getAllUtilisateurs(): array {
        $utilisateurs = [];
        $req = $this->getConnexionBdd()->prepare("SELECT * FROM utilisateur WHERE role != 'ROLE_ADMIN'");
        $req->execute();
        $utilisateur = $req->fetchALL(PDO::FETCH_ASSOC);
        $req->closeCursor();
        foreach ($utilisateur as $utilisateur) {
            $utilisateurEnCours = new Utilisateur($utilisateur['id_utilisateur'], $utilisateur['identifiant'], $utilisateur['password'], $utilisateur['email'], $utilisateur['role'], !$utilisateur['is_valide'] ? false : true);
            $utilisateurs[] = $utilisateurEnCours;
        }
        return $utilisateurs;
    }

    public function supprimerUtilisateurByAdminInBdd($idUtilisateur) {
        $req = "UPDATE livre SET id_utilisateur = NULL WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":id_utilisateur", $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->CloseCursor();
        $req = "DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":id_utilisateur", $idUtilisateur, PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->CloseCursor();
        if (!$resultat) {
            return false;
        } 
        return true;
    }

    public function modifierUtilisateurByAdminInBdd($idUtilisateur) {
        $isValide = isset($_POST['isValide']) ? 1 : 0;
        $req = "UPDATE utilisateur SET role = :role, is_valide = :is_valide WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":id_utilisateur", $idUtilisateur, PDO::PARAM_INT);
        $stmt->bindValue(":is_valide", $isValide, PDO::PARAM_INT);
        $stmt->bindValue(":role", $_POST['role'], PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        $resultat = $stmt->execute();
        $stmt->CloseCursor();
        if (!$resultat) {
            return false;
        } 
        return true;
    }

    /**
     * Get the value of utilisateur
     *
     * @return Utilisateur
     */
    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * Set the value of utilisateur
     *
     * @param Utilisateur $utilisateur
     *
     * @return self
     */
    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}
