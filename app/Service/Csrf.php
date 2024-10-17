<?php

declare(strict_types=1);

namespace App\Service;

class Csrf
{
    private const SESSION_NAME = 'biblio_csrf_token';
    private const FIELD_NAME = 'biblio_csrf_check';

    private static function setSession()
    {
        if (!isset($_SESSION[self::SESSION_NAME])) {
            $_SESSION[self::SESSION_NAME] = bin2hex(random_bytes(32));
        }
    }

    public static function unsetSession()
    {
        if (isset($_SESSION[self::SESSION_NAME])) {
            unset($_SESSION[self::SESSION_NAME]);
        }
    }

    public static function check()
    {
        self::setSession();
        if (!isset($_POST[self::FIELD_NAME]) || $_POST[self::FIELD_NAME] !== $_SESSION[self::SESSION_NAME]) {
            self::unsetSession();
            header('HTTP/1.1 403 Forbidden');
            exit('<h1>Forbidden</h1>');
        }
        self::unsetSession();
    }

    public static function token($input = true)
    {
        self::setSession();
        if ($input) {
            $txt = '';
            $txt .= '<input type="hidden" name="';
            $txt .= self::FIELD_NAME;
            $txt .= '" value="';
            $txt .= $_SESSION[self::SESSION_NAME];
            $txt .= '" />';
            return $txt;
        }
    }
}
