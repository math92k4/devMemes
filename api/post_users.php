<?php
require_once __DIR__.'/../_x.php';

$alias = _validate_alias($_POST['alias']);
$email = _validate_email($_POST['email']);
$password = _validate_password($_POST['password']);
$password = password_hash($password, PASSWORD_DEFAULT);

try {
    $db = new DB();
    $q = $db->prepare('CALL INSERT_user (:alias, :email, :password)');
    $q->bindValue(':alias', $alias);
    $q->bindValue(':email', $email);
    $q->bindValue(':password', $password);
    $q->execute();
    $_SESSION = $q->fetch();
    _respond('User created', 200);

} catch (Exception $ex) {
    if (str_contains($ex, 'email')) _respond('Email already registered', 400);
    if (str_contains($ex, 'alias')) _respond('Alias already registered', 400);
    _respond('Server error', 500);
}