<?php
require_once __DIR__.'/../_x.php';

_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);

$user_id = $_SESSION['user_id'];
$text = isset($_POST['text']) ? _validate_text($_POST['text']) : null;
$image = isset($_FILES['image']) ? _validate_image($_FILES['image']) : null;

if ( !$image && !$text ) _respond('A post must at least contain a text or an image', 400);

try {
    $db = new DB();
    $q = $db->prepare('CALL INSERT_post (:user_id, :text, :image)');
    $q->bindValue(':user_id', $user_id);
    $q->bindValue(':text', $text);
    $q->bindValue(':image', $image);
    $q->execute();
    $post = $q->fetch();
    if ( !isset($_SERVER['HTTP_SPA']) ) _respond('Post created', 200);
    require __DIR__.'/../views/templates/post.php';

} catch (ClientErr $err) {
    _respond($err->text(), $err->code());

} catch (Exception $ex) {
    _respond('Server error', 500);
}