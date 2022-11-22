<?php
require_once __DIR__.'/../_x.php';
require_once __DIR__.'/../classes/post.php';
_validate_session();
$spa = true;

require_once __DIR__.'/templates/header.php';
require_once __DIR__.'/templates/main_nav.php';
?>

<div id="content">
    <main class="posts-container">

        <?php
        try {
        $post = new Post();
        $post->get_ten_newest();

        } catch (Exception $ex) {
            echo $ex;
        }
        foreach($post->array() as $post) {
            require __DIR__.'/templates/post.php';
        }
        ?>

    </main>
    <?php require_once __DIR__.'/templates/sidebar.php'; ?>
</div>

<?php $_SESSION ? require_once __DIR__.'/templates/create_post_modal.php' : '' ?>

<?php require_once __DIR__.'/templates/footer.php';