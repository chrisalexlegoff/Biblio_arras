<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class Utils
{
    public static function ajoutImage($image, $repertoire)
    {
        if ($image['size'] === 0) {
            throw new Exception('Vous devez uploader une image');
        }

        if (!file_exists($repertoire)) {
            mkdir($repertoire, 0777);
        }

        $filename = uniqid() . "-" . $image['name'];
        $target = $repertoire . $filename;

        if (!getimagesize($image['tmp_name'])) {
            throw new Exception('Vous devez uploader une image');
        }

        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $extensionsTab = ['png', 'webp', 'jpg'];

        if (!in_array($extension, $extensionsTab)) {
            throw new Exception("Extension non autorisée => ['png', 'webp', 'jpg']");
        }

        if ($image['size'] > 4000000) { // 4MO
            throw new Exception("Fichier trop volumineux : max 4MO");
        }

        if (!move_uploaded_file($image['tmp_name'], $target)) {
            throw new Exception("Le transfert de l'image à échoué");
        } else {
            return $filename;
        }
    }
}
