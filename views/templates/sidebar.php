<div>
    <aside>
        <article id="trending-memers">
            <h2>Trending memers</h2>
            <ul>
                <li>
                    <a href="#">
                        <img src="" alt="">
                        <p class="alias">Alias</p>
                        <p class="name">Name Nameson</p>
                    </a>
                    <form action="/follow" method="POST">
                        <button>Follow</button>
                    </form>
                </li>
            </ul>
        </article>
    </aside>
    <footer>
        <a href="https://github.com/math92k4/devMemes" target="_blank">GitHub</a>
        <?php if ($_SESSION): ?>
        <a href="/sign-out">Sign out</a>
        <?php endif; ?>
    </footer>
</div>