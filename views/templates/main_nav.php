<header id="main-header">
    <nav>
        <ul>
            <li><a id="logo" href="/">dm</a></li>
            <li id="search-bar-container">
                <label for="search-bar"><?php require __DIR__.'/../../public/images/search.svg' ?></label>
                <input id="search-bar" type="text">
            </li>
        </ul>
        <ul>

            <?php if ( $_SESSION ): ?>
            <li>
                <a class="icon home" href="/">
                    <?php require __DIR__.'/../../public/images/home.svg' ?>
                </a>
            </li>
            <li>
                <a class="icon user" href="/user/<?= $_SESSION['user_alias'] ?>">
                    <?php require __DIR__.'/../../public/images/user.svg' ?>
                </a>
            </li>
            <li>
                <button onclick="showModal('.post-modal')" class="icon pen">
                    <?php require __DIR__.'/../../public/images/pen.svg' ?>
                </button>
            </li>

            <?php elseif ( isset($spa) ): ?>
            <li><a class="sign-in" href="/sign-in">Sign in</a></li>
            <li><a class="sign-up" href="/sign-up">Sign up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>