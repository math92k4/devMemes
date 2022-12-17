<?php
require_once __DIR__.'/../_x.php';

_validate_session();
$spa = true; //This is a spa page
$page_title = $user_alias;
if (!_is_spa()):
require_once __DIR__.'/templates/header.php';
require_once __DIR__.'/templates/main_nav.php';
?>

<div id="content">
    <div id="spa">
<?php endif; ?>
        <main
        data-can_append_post="<?php echo $_SESSION && $_SESSION['user_alias'] === $user_alias ? 1 : '' ?>"
        data-page_title="<?php out($page_title) ?> | devmemes"
        >
            <?php
            $user = _get_user_by_alias($user_alias);
            if ($user) {
                require_once __DIR__.'/templates/user_profile.php';

                $posts = _get_posts_by_alias($user_alias);
                require_once __DIR__.'/templates/posts_container.php';
            } else {
            echo '<h2>Whoops... This user do not exist.</h2>';
            }
            ?>
            <div
            id="loader"
            data-endpoint="/posts/by-alias/<?php out($user_alias) ?>"
            data-offset="15"
            <?= isset($posts) && count($posts) < 15 ? 'data-all_loaded="1"' : '' ?>
            ></div>
        </main>
<?php if (!_is_spa()): ?>
    </div>
    <?php require_once __DIR__.'/templates/sidebar.php'; ?>
</div>

<?php 
$_SESSION ? require_once __DIR__.'/templates/create_post_modal.php' : '';
require_once __DIR__.'/templates/footer.php';
endif;