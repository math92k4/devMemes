<?php
require_once __DIR__.'/../classes/user.php';
require_once __DIR__.'/../_x.php';

try {
    $user = new User();
    $user->create();
    $_SESSION = $user->session();
    _respond('User created', 200);

} catch (ClientErr $err) {
    _respond($err->text(), $err->code());

} catch (Exception $ex) {
    if (str_contains($ex, 'email')) _respond('Email already registered', 400);
    if (str_contains($ex, 'alias')) _respond('Alias already registered', 400);
    _respond('Server error', 500);
}