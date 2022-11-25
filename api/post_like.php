<?php
require_once __DIR__.'/../_x.php';
require_once __DIR__.'/../classes/post.php';

_validate_session();
if ( !$_SESSION ) _respond('Unauthorized attempt', 401);

try {
    $post = new Post();
    $post->like();
    _respond('Post deleted', 200);

} catch (ClientErr $err) {
    _respond($err->text(), $err->code());

} catch (Exception $ex) {
    //TODO look for dublicate entry fail
    _respond($ex, 500);
}