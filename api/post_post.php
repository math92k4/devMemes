<?php
require_once __DIR__.'/../classes/post.php';
require_once __DIR__.'/../_x.php';
$_POST['text'] = 'Hello world';

$post = new Post();
if ( !$post->create() ) _respond_json('Cridentials not met', 400);
echo $post->text();