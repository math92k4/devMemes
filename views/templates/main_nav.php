<header id="main-header">
    <nav>
        <ul>
            <li><a id="logo" href="/">dm</a></li>
            <li id="search-bar-container"><input id="search-bar" type="text"></li>
        </ul>
        <ul>
            <?php if ( $session ): ?>
            <li>Home</li>
            <li>Profile</li>
            <li>User</li>
            <?php elseif ( isset($spa) && $spa ): ?>
            <li><a class="sign-in" href="/sign-in" onclick="spa()">Sign in</a></li>
            <li><a class="sign-up" href="/sign-up" onclick="spa()">Sign up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>