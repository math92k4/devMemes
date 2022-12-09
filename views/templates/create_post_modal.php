<div class="modal post-modal">
    <div class="modal-hider" onclick="hideModal('.post-modal')"></div>
    <form action="/posts" method="POST">
        <h2>Create post</h2>
        <input id="post-image" name="image" type="file" accept="image/png, image/jpeg" hidden onchange="postValidation(); loadPostImage();" required>
        <label class="file-label" for="post-image" minlength="1" maxlength="200" ><?php require __DIR__.'/../../public/images/camera.svg' ?></label>
        <textarea name="text" cols="4" rows="4" minlength="1" maxlength="200" placeholder="Type something" oninput="postValidation()" required></textarea>
        <div class="button-container">
            <button class="submitter" onclick="postPost()">Create post</button>
        </div>
    </form>
</div>