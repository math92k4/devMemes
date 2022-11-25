<?php
require_once __DIR__.'/../_x.php';

_validate_session();
$spa = true;
$page_title = $user_alias;
require_once __DIR__.'/templates/header.php';
require_once __DIR__.'/templates/main_nav.php';
?>

<div id="content">
    <main>
        <?php
        $user = _get_user_by_alias($user_alias);
        if ($user) {
            require_once __DIR__.'/templates/user_profile.php';
            echo '<div class="posts-container">';
                $posts = _get_posts_by_alias($user_alias);
                foreach($posts as $post) {
                    require __DIR__.'/templates/post.php';
                }
            echo '</div>';
        } else {
        echo '<h2>Whoops... This user do not exist.</h2>';
        }
        ?>
    </main>
    <?php require_once __DIR__.'/templates/sidebar.php'; ?>
</div>

<?php $_SESSION ? require_once __DIR__.'/templates/create_post_modal.php' : '' ?>

<?php require_once __DIR__.'/templates/footer.php';