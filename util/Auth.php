<?php

class Auth
{
    public static function handleLogin()
    {
        @session_start();
        // Verifica si la clave 'loggedIn' está definida en $_SESSION
        $logged = isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn'] : false;

        if ($logged == false)
        {
            // Si no está logueado, destruye la sesión y redirige
            session_destroy();
            header('location: ../');
            exit;
        }

    }
}
