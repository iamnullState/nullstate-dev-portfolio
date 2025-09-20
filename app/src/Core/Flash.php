<?php
namespace Nullstate\Core;

final class Flash
{
    public static function set(string $type, string $message): void {
        $_SESSION['flash_alert'] = ['type'=>$type, 'message'=>$message];
    }

    public static function get(): ?array {
        if (!isset($_SESSION['flash_alert'])) return null;
        $alert = $_SESSION['flash_alert'];
        unset($_SESSION['flash_alert']);
        return $alert;
    }
}