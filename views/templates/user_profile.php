<section class="user-profile">
    <img src="/public/images/uploads/<?php out($user['user_image']) ?>">
    <div>
        <h2><?php out($user['user_alias']) ?></h2>

        <?php if ( $_SESSION && $_SESSION['user_id'] === $user['user_id'] ): ?>
            <a
            href="/user/<?php out($_SESSION['user_alias']) ?>/settings"
            onclick="spa('/user/<?php out($_SESSION['user_alias']) ?>/settings'); return false"
            data-title="Settings | devmemes"
            >
                Edit
            </a>
        <?php endif; ?>

    </div>
</section>