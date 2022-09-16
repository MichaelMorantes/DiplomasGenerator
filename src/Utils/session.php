<?php

class session
{
    private static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $val) {
        self::init();

        $_SESSION[$key] = $val;
    }

    public static function get($key, $default = null) {
        self::init();

        if (!array_key_exists($key, $_SESSION)) {
            return $default;
        }

        return $_SESSION[$key];
    }

    public static function drop($key) {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }

    public static function kill() {
        self::init();

        session_unset();
        session_destroy();
    }
}