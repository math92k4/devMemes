<?php
require_once __DIR__.'/../_x.php';

$users = _get_popular_users();

if (!_is_spa()) _respond($users, 200);
require __DIR__.'/../views/templates/popular_users.php';