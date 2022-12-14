<ul>
    <?php foreach(_get_popular_users() as $user): ?>
    <li>
        <a
        href="/user/<?php out($user['user_alias']) ?>"
        onclick="spa('/user/<?php out($user['user_alias']) ?>'); return false"
        data-title="<?php out($user['user_alias']) ?> | devmemes"
        >
            <div>
                <img src="/public/images/uploads/<?php out($user['user_image']) ?>" alt="image of <?php out($user['user_alias']) ?>">
                <div>
                    <p class="alias"><?php out($user['user_alias']) ?></p>
                    <p class="name"><?php out($user['total_likes']) ?> likes</p>
                </div>
            </div>
            <p>Visit</p>
        </a>
    </li>
    <?php endforeach; ?>
</ul>