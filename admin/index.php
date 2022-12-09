<?php
require_once __DIR__.'/../classes/admin.php';
require_once __DIR__.'/../classes/user.php';

// Validate admin session
if ( !isset($_SESSION['admin']) ){
    header('Location: /admin/sign-in');
    exit();
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$user = new User();
// For displaying users
$offset = $current_page - 1;
$users = $user->listAll($offset);
// To determine page-amounts
$usersCount = $user->countAll();
$page_amount = ceil($usersCount / 25); // max 25 pr page

require_once __DIR__.'/header.php';
?>
<a href="/admin/sign-out">Sign out</a>
<h1>Admin panel</h1>

<section>
    <h2>User list</h2>
    <?php if ( $usersCount != 0 ): ?>
        <table>
            <tr>
                <th>Alias</th>
                <th>Email</th>
                <th></th>
            </tr>
            <?php foreach($users as $user):?>
            <tr>
                <td><?php out($user['user_alias']) ?></td>
                <td><?php out($user['user_email']) ?></td>
                <td>
                    <a href="/admin/users/<?= $user['user_id'] ?>/delete">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php
        if( $current_page != 1 ) {
            $prev_page = htmlspecialchars($current_page -1);
            echo '<a href="/admin/users-list/'. $prev_page .'">Next<?</a>';

        } elseif ( $current_page != $page_amount ) {
            $next_page = htmlspecialchars($current_page +1);
            echo '<a href="/admin/users-list/'. $next_page .'">Next<?</a>';
        }
        ?>
    <?php
    else:
        echo '<p>No users in the system</p>';
    endif;
    ?>
</section>

<?php
require_once __DIR__.'/footer.php';