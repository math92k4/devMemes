<?php
require_once __DIR__.'/../_x.php';

$email = _validate_email($_POST['email']);
$password = _validate_password($_POST['password']);

try {
    // GET ID AND PASSWORD FROM DB - by email
    $db = new DB();
    $q = $db->prepare('SELECT user_password, user_id FROM users WHERE user_email = :email LIMIT 1');
    $q->bindValue(':email', $email);
    $q->execute();
    $res = $q->fetch(); 
    if ( !$res ) _respond ('Email or password not correct', 400); // Email not matching

    // VERIFY PASSWD WITH DB-PASSWD
    $db_password = $res['user_password']; 
    if ( !password_verify($password, $db_password) ) { // Password not verified
        _respond('Email or password not correct', 400);
    }

    // MATCH FOUND - CREATE SESSION
    $user_id = $res['user_id'];
    $q = $db->prepare('CALL INSERT_session (:user_id)');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $_SESSION = $q->fetch(); // db procedure returns the sesseion array

    _respond('Session created', 200);

} catch (Exception $ex) {
    _respond('Server error', 500);
}