<?php
require_once __DIR__.'/router.php';

// Website routes
get('/', 'views/index.php');
get('/sign-up', 'views/sign_up.php');
get('/sign-in', 'views/sign_in.php');
get('/sign-out', 'views/sign_out.php');
get('/user/$user_alias', 'views/user.php');
get('/user/$user_alias/settings', 'views/user_settings.php');


// Website redirs
get('/log-in', function() { header('Location: /sign-in'); });
get('/login', function() { header('Location: /sign-in'); });
get('/signin', function() { header('Location: /sign-in'); });

get('/register', function() { header('Location: /sign-up'); });
get('/signup', function() { header('Location: /sign-up'); });
get('/create-account', function() { header('Location: /sign-up'); });


// Admin routes
get('/admin', 'admin/index.php');
get('/admin/user-list/$page', 'admin/index.php');
get('/admin/sign-in', 'admin/sign_in.php');
post('/admin/sign-in', 'admin/sign_in.php');
get('/admin/sign-out', 'admin/sign_out.php');
get('/admin/users/$user_id/delete', 'admin/delete_user.php');

// APIs
post('/users', 'api/post_users.php');
post('/users/update/info', 'api/update_users_info.php');
post('/users/update/password', 'api/update_users_password.php');
delete('/users', 'api/delete_users.php');
post('/sessions', 'api/post_sessions.php');
delete('/posts/$post_id', 'api/delete_posts.php');
post('/posts', 'api/post_posts.php');
post('/likes', 'api/post_likes.php');
delete('/likes/$post_id', 'api/delete_likes.php');


// Error pages
get('/500', 'views/500.php');
any('/404', 'views/404.php');
