<?php

require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

get('/', 'views/index.php');
get('/sign-up', 'views/sign_up.php');
get('/sign-in', 'views/sign_in.php');

// get('/item/$item_id', 'views/item.php');

// get('/test/$word', function( $word ) { echo $word; });

// get('/$gender/shoes/$brand/$size', 'views/product');

post('/users', 'api/post_user.php');
post('/posts', 'api/post_post.php');
post('/sessions', 'api/post_session.php');



// // API routes

// post('/item', 'apis/create_item.php');



// any('/404', 'views/404.php');
