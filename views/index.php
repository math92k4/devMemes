<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/style.css">
    <title>Document</title>
</head>
<body>

    <header id="main-header">
        <nav>
            <ul>
                <li><a id="logo" href="/">dm</a></li>
                <li id="search-bar-container"><input id="search-bar" type="text"></li>
            </ul>
            <ul>
                <li>Home</li>
                <li>Profile</li>
                <li>User</li>
            </ul>
        </nav>
    </header>

    <div id="content">
        <main>
            <article>
                <img src="" alt="">
                <div class="post">
                    <div class="top-bar">
                        <div>
                            <h2>Alias</h2>
                            <form action="/follow">
                                <button>Follow</button>
                            </form>
                        </div>
                        <details>
                            <summary>···</summary>
                            <p>Test</p>
                        </details>
                        <div class="fold"></div>
                    </div>
                    <div class="post-content">
                        <p>Test</p>
                    </div>
                    <div class="bottom-bar">
                        <p class="upvotes"><span>12</span> upvotes</p>
                        <div class="actions">heart</div>
                    </div>
                </div>
            </article>


        </main>

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
            <footer><a href="https://github.com/math92k4/devMemes" target="_blank">GitHub</a></footer>
        </div>
    </div>
    
</body>
</html>