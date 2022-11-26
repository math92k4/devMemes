<?php
require_once __DIR__.'/../_x.php';

_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);
$user_id = $_SESSION['user_id'];
$post_id = _validate_id($_POST['post_id']);

try {
    $db = new DB();
    $q = $db->prepare('CALL INSERT_like (:post_id, :user_id)');
    $q->bindValue(':post_id', $post_id);
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    _respond('Post deleted', 200);

} catch (ClientErr $err) {
    _respond($err->text(), $err->code());

} catch (Exception $ex) {
    if (str_contains($ex, 'Duplicate entry')) _respond('Like aldready registered', 400);
    _respond('Server error', 500);
}