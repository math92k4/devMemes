<?php

require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/', 'views/index.php');

// get('/item/$item_id', 'views/item.php');

// get('/test/$word', function( $word ) { echo $word; });

// get('/$gender/shoes/$brand/$size', 'views/product');





// // API routes

// post('/item', 'apis/create_item.php');



// any('/404', 'views/404.php');
