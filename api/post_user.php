<?php
require_once __DIR__.'/../classes/user.php';
require_once __DIR__.'/../_x.php';

try {
    $user = new User();
    $res = $user->create();
    $_SESSION['session'] = $res;
    _respond_json('User created', 200);

} catch (ClientErr $err) {
    _respond_json($err->text(), $err->code());

} catch (Exception $ex) {
    if (str_contains($ex, 'email')) _respond_json('Email already registered', 400);
    if (str_contains($ex, 'alias')) _respond_json('Alias already registered', 400);
    _respond_json($ex, 500);
}