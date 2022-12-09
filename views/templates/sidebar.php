<div>
    <aside>
        <article id="trending-memers">
            <h2>Trending memers</h2>
            <ul>

                <?php foreach(_get_popular_users() as $user): ?>
                <li>
                    <a href="/user/<?php out($user['user_alias']) ?>" >
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
        </article>
    </aside>
    <footer>
        <a href="https://github.com/math92k4/devMemes" target="_blank">GitHub</a>
        <?php if ( $_SESSION ): ?>
        <a href="/sign-out">Sign out</a>
        <?php endif; ?>
    </footer>
</div>