<?php
require_once __DIR__.'/../_x.php';

// Validate session
_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);
$user_id = $_SESSION['user_id'];

// Validate data
$alias = _validate_alias($_POST['alias']);
$email = _validate_email($_POST['email']);
$image = isset($_FILES['image']) ? _validate_image($_FILES['image']) : $_SESSION['user_image'];

// Don't update if the data isn't new
if ($alias == $_SESSION['user_alias'] && $email == $_SESSION['user_email'] && $image == $_SESSION['user_image']) {
    _respond('No content', 204);
}

// Connect to db
try {
    $db = new DB();

    // Get old image if new image (for deletion)
    if ($image !== $_SESSION['user_image']) {
        $q = $db->prepare('SELECT user_image FROM users WHERE user_id = :user_id');
        $q->bindValue(':user_id', $user_id);
        $q->execute();
        $old_image = $q->fetch()['user_image'];
    }

    // Update user-info
    $q = $db->prepare('CALL UPDATE_user_info (:alias, :email, :image, :user_id)');
    $q->bindValue(':alias', $alias);
    $q->bindValue(':email', $email);
    $q->bindValue(':image', $image);
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $_SESSION = $q->fetch();

    // Delete old image if set
    if (isset($old_image)) {
        _delete_image($old_image);
    }

    // SUcces
    _respond('User created', 200);

} catch (Exception $ex) {
    if (str_contains($ex, 'email')) _respond('Email already registered', 400);
    if (str_contains($ex, 'alias')) _respond('Alias already registered', 400);
    _respond('Server error', 500);
}



