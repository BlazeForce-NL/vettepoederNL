<?php
declare(strict_types=1);
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'wp_generator');
add_action('send_headers', static function (): void { if (!headers_sent()) { header('X-Content-Type-Options: nosniff'); header('X-Frame-Options: SAMEORIGIN'); header('Referrer-Policy: strict-origin-when-cross-origin'); header('Permissions-Policy: camera=(), microphone=(), geolocation=()'); } });
add_filter('login_errors', static fn (): string => 'Inloggen is niet gelukt. Controleer je gegevens.');
