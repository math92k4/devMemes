<?php
require_once __DIR__.'/../_x.php';

$posts = _get_posts_by_alias($alias, $offset);

if (!_is_spa()) _respond($posts, 200);
require __DIR__.'/../views/templates/posts_container.php';