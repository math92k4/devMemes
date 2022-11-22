<?php
require_once __DIR__.'/../_x.php';
require_once __DIR__.'/../classes/user.php';

try {
    $user = new User();
    $user->sign_in();
    $_SESSION = $user->session();
    _respond('Session created', 200);

} catch (ClientErr $err) {
    _respond($err->text(), $err->code());

} catch (Exception $ex) {
    if (str_contains($ex, 'email')) _respond('Email already registered', 400);
    if (str_contains($ex, 'alias')) _respond('Alias already registered', 400);
    _respond('Server error', 500);
}