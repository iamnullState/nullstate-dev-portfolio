<?php
namespace Nullstate\Http\Middleware;

final class Csrf {
    public static function ensure(): void {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_issued_at'] = time();
        }
    }
    public static function token(): string {
        return $_SESSION['csrf_token'] ?? '';
    }
    public static function verifyPost(): void {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') return;
        $sent = $_POST['_token'] ?? '';
        $sess = $_SESSION['csrf_token'] ?? '';
        if (!hash_equals($sess, $sent)) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
    }
}