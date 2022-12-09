<?php
require_once __DIR__.'/../classes/admin.php';
require_once __DIR__.'/../classes/user.php';


if ( isset($_POST['email']) && isset($_POST['password']) ) {
    $admin = new Admin();
    $is_valid = $admin->verifyCridentials($_POST['email'], $_POST['password']);
    if ($is_valid) {
        $_SESSION['admin'] = $_POST['email'];
        header('Location: /admin');
        exit();
    }
}

require_once __DIR__.'/header.php';
?>

<h1>Admin panel</h1>

<form action="/admin/sign-in" method="POST">
    <h2>Sign in</h2>
    <?php echo isset($is_valid) && !$is_valid ? '<p>Wrong email or password</p>' : '' ?>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <button>Sign in</button>
</form>

<?php
require_once __DIR__.'/footer.php';