<?php
require_once __DIR__.'/../_x.php';

// Validate session
_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);
$user_id = $_SESSION['user_id'];

// Validate data
$old_password = _validate_password($_POST['old_password']);
$new_password = _validate_password($_POST['new_password']);

// Nothing to update?
if ($old_password === $new_password) _respond('No content', 204);

// Connect to db
try {
    // Verify old password
    $db = new DB();
    $q = $db->prepare('SELECT user_password FROM users WHERE user_id = :user_id LIMIT 1');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $res = $q->fetch();
    $db_password = $res['user_password']; 

    // VERIFY PASSWD WITH DB-PASSWD
    if ( !password_verify($old_password, $db_password) ) { // Password not verified
        _respond('Password not correct', 400);
    }

    //Hash new password
    $hased_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in db
    $q = $db->prepare('CALL UPDATE_user_password (:password, :user_id)');
    $q->bindValue(':password', $hased_password);
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    _respond('Password updated', 200);

} catch (Exception $ex) {
    _respond($ex, 500);
}
