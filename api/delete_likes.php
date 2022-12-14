<?php
require_once __DIR__.'/../_x.php';

_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);
$user_id = $_SESSION['user_id'];
$post_id = _validate_id($post_id);

try {
    $db = new DB();
    $q = $db->prepare('CALL DELETE_like (:post_id, :user_id)');
    $q->bindValue(':post_id', $post_id);
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    if ($q->rowCount() === 0) _respond('No content', 204);
    _respond('Like deleted', 200);
    

} catch (Exception $ex) {
    _respond('Server error', 500);
}

