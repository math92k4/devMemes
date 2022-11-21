<?php
print_r($_SESSION['session']);
require_once __DIR__.'/templates/header.php';
require_once __DIR__.'/templates/main_nav.php';
?>

<div id="content">
    <main class="posts-container">
        <?php
        $posts = [1,2,3,4];
        foreach($posts as $post) {
            require __DIR__.'/templates/post.php';
        }
        ?>
    </main>
    <?php require_once __DIR__.'/templates/sidebar.php'; ?>
</div>

<?php require_once __DIR__.'/templates/footer.php';