<?php
require_once __DIR__.'/../_x.php';
require_once __DIR__.'/../classes/post.php';

_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);

try {
    $post = new Post();
    $post->create();
    if ( !isset($_SERVER['HTTP_SPA']) ) _respond('Post created', 200);
    $post = $post->array()[0];
    require __DIR__.'/../views/templates/post.php';

} catch (ClientErr $err) {
    _respond($err->text(), $err->code());

} catch (Exception $ex) {
    if (str_contains($ex, 'email')) _respond('Email already registered', 400);
    if (str_contains($ex, 'alias')) _respond('Alias already registered', 400);
    _respond($ex, 500);
}