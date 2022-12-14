<div>
    <aside>
        <article id="trending-memers">
            <h2>Trending memers</h2>
            <?php require_once __DIR__.'/popular_users.php' ?>
        </article>
    </aside>
    <footer>
        <a href="https://github.com/math92k4/devMemes" target="_blank">GitHub</a>
        <?php if ( $_SESSION ): ?>
        <a href="/sign-out">Sign out</a>
        <?php endif; ?>
    </footer>
</div>