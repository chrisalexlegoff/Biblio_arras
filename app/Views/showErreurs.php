<?php

if (isset($_SESSION['erreurs'])) {
    foreach ($_SESSION['erreurs'] as $erreursTab) {
        foreach ($erreursTab as $erreurs) {
            $divErreur = "<div class='alert alert-danger w-100 m-auto' style='max-width: 781px'><ul>";
            foreach ($erreurs as $erreur) {
                $divErreur .= "<li>$erreur</li>";
            }
            $divErreur .= '</ul></div>';
            unset($_SESSION['erreurs']);
            echo $divErreur;
        }
    }
}
