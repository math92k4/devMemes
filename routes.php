<?php

require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

get('/', 'views/index.php');
get('/sign-up', 'views/sign_up.php');
get('/sign-in', 'views/sign_in.php');
get('/sign-out', 'views/sign_out.php');
get('/user/$user_alias', 'views/user.php');
get('/user/$user_alias/settings', 'views/user_settings.php');

// get('/item/$item_id', 'views/item.php');

// get('/test/$word', function( $word ) { echo $word; });

// get('/$gender/shoes/$brand/$size', 'views/product');

// API
post('/users', 'api/post_users.php');
post('/posts', 'api/post_posts.php');
post('/sessions', 'api/post_sessions.php');



// // API routes

// post('/item', 'apis/create_item.php');



any('/404', 'views/404.php');
