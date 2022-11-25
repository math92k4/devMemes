<?php
require_once __DIR__.'/../_x.php';

// _validate_session();
$spa = true;
require_once __DIR__.'/templates/header.php';
require_once __DIR__.'/templates/main_nav.php';
?>

<div id="content">
    <main>
        <div class="posts-container">
        <?php
        $posts = _get_newest_posts();
        foreach($posts as $post) {
            require __DIR__.'/templates/post.php';
        }
        ?>
        </div>
    </main>
    <?php require_once __DIR__.'/templates/sidebar.php'; ?>
</div>

<?php $_SESSION ? require_once __DIR__.'/templates/create_post_modal.php' : '' ?>

<?php require_once __DIR__.'/templates/footer.php';