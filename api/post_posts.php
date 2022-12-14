<?php
require_once __DIR__.'/../_x.php';

// Validate session
_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);

// Validate data
$user_id = $_SESSION['user_id'];
$text = isset($_POST['text']) && $_POST['text'] ? _validate_text($_POST['text']) : null;
$image = isset($_FILES['image']) ? _validate_image($_FILES['image']) : null;
// No data to insert?
if ( !$image && !$text ) _respond('A post must at least contain a text or an image', 400);

// Connect to db
try {
    $db = new DB();
    $q = $db->prepare('CALL INSERT_post (:user_id, :text, :image)');
    $q->bindValue(':user_id', $user_id);
    $q->bindValue(':text', $text);
    $q->bindValue(':image', $image);
    $q->execute();
    $post = $q->fetch();
    if ( !_is_spa ) _respond('Post created', 200);
    require __DIR__.'/../views/templates/post.php';

} catch (Exception $ex) {
    _respond('Server error', 500);
}