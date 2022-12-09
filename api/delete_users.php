<?php
require_once __DIR__.'/../_x.php';

_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);
$user_id = $_SESSION['user_id'];

try {

    // Get all user_image's
    $db = new DB();
    $q = $db->prepare('CALL SELECT_images_by_user_id (:user_id)');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $images = $q->fetchAll();

    // Delete user
    $q = $db->prepare('DELETE FROM users WHERE user_id = :user_id');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    if ($q->rowCount() === 0) _respond('No content', 204);

} catch (Exception $ex) {
    _respond('Server error', 500);
}

// Delete images
foreach($images as $image) {
    _delete_image($image['image']);
}

// Succes
_respond('User delete', 200);