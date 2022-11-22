<div class="modal post-modal">
    <div class="modal-hider"></div>
    <form action="/posts" method="POST">
        <h2>Create post</h2>
        <label class="file-label" for="post-image"><?php require __DIR__.'/../../public/images/camera.svg' ?></label>
        <input id="post-image" name="image" type="file" accept="image/png, image/jpeg" hidden required>
        <textarea name="text" cols="4" rows="4" maxlength="200" placeholder="Type something" required></textarea>
        <div class="button-container">
            <button onclick="formValidation( postPost )">Create post</button>
        </div>
    </form>
</div>