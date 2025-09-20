<?php
declare(strict_types=1);

namespace Nullstate\Controllers;

final class DebugController
{
    public function store(): void
    {
        // i made this just to make sure the CSRF token was working
        echo "CSRF passed ✅";
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    public function flash(): void
    {
        $type = $_POST['type'] ?? 'info';
        $message = $_POST['message'] ?? 'This is a default message';
        \Nullstate\Core\Flash::set($type, $message);
        header('Location: /');
        exit;
    }
}