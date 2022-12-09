<?php
require_once __DIR__.'/../classes/admin.php';
require_once __DIR__.'/../classes/user.php';
require_once __DIR__.'/../classes/image.php';

// Validate admin session
if ( !isset($_SESSION['admin']) ){
    header('Location: /admin/sign-in');
    exit();
}

$user = new User();
$user_images = $user->allImages($user_id);
foreach($user_images as $user_image) {
    $image = new Image();
    $image->delete($user_image['image']);
}
$user->delete($user_id);
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();