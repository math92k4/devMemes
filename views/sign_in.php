<?php
if ( $_SESSION ) {
    header('Location: /');
    exit();
}

$page_title = 'Sign up | devmemes';
$body_cls = 'sign-page';
require_once __DIR__.'/templates/header.php'; 
?>

<main>
    <?php require_once __DIR__.'/templates/main_nav.php' ?>
    <a class="sign-up" href="/sign-up">Sign up</a>
    <div class="bg-gradient">
        <img class="bg-image" src="/public/images/bg.jpg" alt="Cute little meme dog">
    </div>
    <div class="sign-form-container">
        <h1>devmemes</h1>
        <form class="sign-form" action="/session" method="POST">
            <input type="email" name="email" required placeholder="Email">
            <input type="password" name="password" required placeholder="Password">
            <button onclick="formValidation( postSession )">Sign in</button>
        </form>
    </div>
</main>

<?php require_once __DIR__.'/templates/footer.php';
