<article>
    <img src="/public/images/uploads/<?php out($post['user_image']) ?>">
    <div class="post">
        <div class="top-bar">
            <div>
                <a href="/user/<?php out($post['user_alias']) ?>" onclick="spa()">
                    <?php out($post['user_alias']) ?>
                </a>
                <form action="/follow">
                    <button>Follow</button>
                </form>
            </div>
            <details>
                <summary>···</summary>
                <p>test</p>
            </details>
            <div class="fold"></div>
        </div>
        <div class="post-content">

            <?php if ( $post['post_image'] ): ?>
            <img src="/public/images/uploads/<?php out($post['post_image']) ?>" >
            <?php endif; ?>

            <?php if ( $post['post_text'] ): ?>
            <p><?php out($post['post_text']) ?></p>
            <?php endif; ?>

        </div>
        <div class="bottom-bar">
            <p class="upvotes"><span>12</span> upvotes</p>
            <div class="actions">heart</div>
        </div>
    </div>
</article>