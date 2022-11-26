<?php
require_once __DIR__.'/../_x.php';

_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);
$user_id = $_SESSION['user_id'];

try {

    // Get all user_image's
    $db = new DB();
    $q = $db->prepare('SELECT user_image FROM users WHERE user_id = :user_id LIMIT 1');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $user_image = $q->fetch()['user_image'];

    // Get all post_image's
    $q = $db->prepare('SELECT post_image FROM posts WHERE fk_user_id = :user_id');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $post_images = $q->fetch();

    // Delete user
    $q = $db->prepare('DELETE FROM users WHERE user_id = :user_id');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    if ($q->rowCount() === 0) _respond('No content', 204);

    // Delete images
    _delete_image($user_image);
    foreach($post_images as $image) {
        _delete_image($image);
    }

    // Succes
    _respond('User delete', 200);

} catch (Exception $ex) {
    _respond('Server error', 500);
}