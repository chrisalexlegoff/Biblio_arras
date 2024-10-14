<?php

declare(strict_types=1);

namespace App\Service;

class ValidationDonnees
{
    private array $erreurs = [];

    public function valider(array $regles, array $datas)
    {
        // echo '<pre>';
        // print_r($regles);
        // echo '</pre>';
        foreach ($regles as $key => $regleTab) {
            if (array_key_exists($key, $datas)) {
                foreach ($regleTab as $regle) {
                    switch ($regle) {
                        case 'required':
                            $this->required($key, $datas[$key]);
                            break;
                        case substr($regle, 0, 5) === 'match':
                            $this->match($key, $datas[$key], $regle);
                            break;
                        case substr($regle, 0, 3) === 'min':
                            $this->min($key, $datas[$key], $regle);
                            break;
                    }
                }
            }
        }
        return $this->getErreurs();
    }

    public function required(string $name, string|int|bool $data)
    {
        $value = trim($data);
        if (!isset($value) || empty($value) || is_null($value)) {
            $this->erreurs[$name][] = "Le champ {$name} est requis!";
        }
    }

    private function min(string $name, string $value, string $regle): void
    {
        // preg_match_all('/(\d+)/', $regle, $matches);
        // $limit = $matches[0][0]; // => 3
        $limit =  (int)substr($regle, 3);

        if (strlen($value) < $limit) {
            $this->erreurs[$name][] = "Le champ {$name} doit contenir un minimum de {$limit} caractères";
        }
    }

    public function match(string $name, string|int|bool $data, string $regle)
    {
        $pattern = substr($regle, 6);
        if (!preg_match($pattern, $data)) {
            switch ($name) {
                case 'password':
                    $this->erreurs[$name][] = "Le mot de passe doit contenir minimum 12 caracteres, minimum 1 caractere special, une majuscule et 1 chiffre";
                    break;
                case 'email':
                    $this->erreurs[$name][] = "L' adresse email n'est pas valide";
                    break;
                case 'titre':
                    $this->erreurs[$name][] = "Le champ {$name} doit commencer par une lettre majuscule, contenir minimum 3 lettres et maximum 20 lettres, espaces et '-'(tiret du 6) autorisés";
                    break;
                case 'nbre-de-pages':
                    $this->erreurs[$name][] = "Le champ {$name} doit contenir uniquement des chiffres, [min: 1 - max: 10]";
                    break;
                case 'text-alternatif':
                    $this->erreurs[$name][] = "Le champ {$name} doit commencer par une lettre majuscule, contenir minimum 10 caractères et maximum 15à caracteres, espaces, '-'(tiret du 6), simple-quotes, double-quotes et point autorisés";
                    break;
            }
        }

    }

    /**
     * Get the value of erreurs
     *
     * @return array
     */
    public function getErreurs(): array
    {
        return $this->erreurs;
    }
}
