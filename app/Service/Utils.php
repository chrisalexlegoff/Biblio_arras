<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class Utils
{
    public static function ajoutImage($image, $repertoire)
    {
        if ($image['size'] === 0) {
            return $_SESSION['erreurs']['image'][] = 'Vous devez uploader une image';
        }

        if (!file_exists($repertoire)) {
            mkdir($repertoire, 0777);
        }

        if (empty($image['tmp_name'])) {
            return $_SESSION['erreurs']['image'][] = 'Vous devez uploader une image';
        }

        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $extensionsTab = ['png', 'webp', 'jpg'];

        if (!in_array($extension, $extensionsTab)) {
            return $_SESSION['erreurs']['image'][] = "Extension non autorisée => ['png', 'webp', 'jpg']";
        }

        if ($image['size'] > 4000000) { // 4MO
            return $_SESSION['erreurs']['image'][] = "Fichier trop volumineux : max 4MO";
        }


        $filename = uniqid() . "-" . $image['name'];
        $target = $repertoire . $filename;


        if (!move_uploaded_file($image['tmp_name'], $target)) {
            return $_SESSION['erreurs']['image'][] = "Le transfert de l'image à échoué";
        } else {
            return $filename;
        }
    }
}
