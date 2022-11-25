<section class="user-profile">
    <img src="/public/images/uploads/<?php out($user['user_image']) ?>">
    <div>
        <h2><?php out($user['user_alias']) ?></h2>
        <form>
            <input type="text" name="user_id" value="<?php out($user['user_id']) ?>" hidden >
            <button onclick="postFollow()">Follow</button>
        </form>
    </div>
</section>