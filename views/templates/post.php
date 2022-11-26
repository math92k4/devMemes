<article id="post-<?php out($post['post_id']) ?>">
    <img src="/public/images/uploads/<?php out($post['user_image']) ?>">
    <div class="post">

        <div class="top-bar">
            <div>
                <a class="alias" href="/user/<?php out($post['user_alias']) ?>" onclick="spa()">
                    <?php out($post['user_alias']) ?>
                </a>
            </div>
            
            <?php if ( $_SESSION && $_SESSION['user_id'] === $post['user_id'] ): ?>
            <details>
                <summary>···</summary>
                <button onclick="deletePost(<?php out($post['post_id']) ?>)">delete</button>
            </details>
            <?php endif; ?>

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
            <p class="likes"><span><?php out($post['post_likes']) ?></span> likes</p>
            <?php if ( $_SESSION && $_SESSION['user_id'] !== $post['user_id'] ): ?>
            <div class="actions">
                <form>
                    <input type="text" name="post_id" value="<?php out($post['post_id']) ?>" hidden>
                    <?php if ($post['is_liking']): ?>
                    <button onclick="deleteLike()">Unlike</button>
                    <?php else: ?>
                    <button onclick="postLike()">Like</button>
                    <?php endif; ?>
                </form>     
            </div>
            <?php endif; ?>
        </div>
    </div>
</article>