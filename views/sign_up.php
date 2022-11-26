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
    <a class="sign-in" href="/sign-in">Sign in</a>
    <div class="bg-gradient">
        <img class="bg-image" src="/public/images/bg.jpg" alt="Cute little meme dog">
    </div>
    <div class="sign-form-container">
        <h1>devmemes</h1>
        <form class="sign-form" action="/create-user" method="POST">
            <input type="text" name="alias" minlength="2" required placeholder="Alias" pattern="^[a-zA-Z0123456789-]+">
            <input type="email" name="email" required placeholder="Email" pattern='^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))' >
            <input type="password" name="password" minlength="8" required placeholder="Password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}" >
            <p class="requirements">Minimum 8 characters, 1 capital, 1 lowercase and 1 special character. </p>
            <button class="submitter" onclick="formValidation( postUser )">Sign up</button>
        </form>
    </div>
</main>

<?php require_once __DIR__.'/templates/footer.php';
