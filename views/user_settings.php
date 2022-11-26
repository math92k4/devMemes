<?php
require_once __DIR__.'/../_x.php';

_validate_session();
if ( !$_SESSION || $_SESSION['user_alias'] !== $user_alias ) {
    header('Location: /');
}
$spa = true;
$page_title = $user_alias;
require_once __DIR__.'/templates/header.php';
require_once __DIR__.'/templates/main_nav.php';
?>

<div id="content">
    <main>
        <form id="update-info-form" class="settings-form">
            <legend>Edit info</legend>
            <div id="image">
                <label for="user-image"><?php require __DIR__.'/../public/images/pen.svg' ?></label>
                <img src="/public/images/uploads/<?php out($_SESSION['user_image']) ?>" >
            </div>
            <input type="file" name="image" id="user-image" onchange="infoValidation()" hidden>
            <div class="wrapper">
                <label for="alias">Alias</label>
                <input type="text" name="alias" minlength="2" required placeholder="Alias" data-current="<?php out($_SESSION['user_alias']) ?>" oninput="infoValidation()" value="<?php out($_SESSION['user_alias']) ?>" pattern="^[a-zA-Z0123456789-]+">
            </div>
            <div class="wrapper">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required placeholder="Email" data-current="<?php out($_SESSION['user_email']) ?>" oninput="infoValidation()" value="<?php out($_SESSION['user_email']) ?>" pattern='^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))' >
            </div>
            <div class="button-container">
                <button class="submitter invalid" onclick="updateUserInfo()">Update info</button>
            </div>
        </form>

        <form id="update-password-form" class="settings-form">
            <legend>Change password</legend>
            <div class="wrapper">
                <label for="old-password">Old password</label>
                <input type="password" id="old-password" name="old_password" minlength="8" required placeholder="Old password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}" >
            </div>
            <div class="wrapper">
                <label for="new-password">New password</label>
                <input type="password" id="new-password" name="new_password" minlength="8" required placeholder="New password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}" >
                <p class="requirements">Minimum 8 characters, 1 capital, 1 lowercase and 1 special character. </p>
            </div>
            <div class="button-container">
                <button class="submitter" onclick="updateUserPassword()">Update password</button>
            </div>
        </form>
    
        <button class="delete-user-btn" onclick="showModal('.delete-user-modal')">Delete user</button>

        <div class="modal delete-user-modal">
            <div class="modal-hider" onclick="hideModal('.delete-user-modal')"></div>
            <div>
                <h2>Are you sure?</h2>
                <div class="btn-container">
                    <button class="danger" onclick="deleteUser()">Delete user</button>
                    <button onclick="hideModal('.delete-user-modal')">Cancel</button>
                </div>
            </div>
        </div>

    </main>
    <?php require_once __DIR__.'/templates/sidebar.php'; ?>
</div>

<?php
$_SESSION ? require_once __DIR__.'/templates/create_post_modal.php' : '';
require_once __DIR__.'/templates/footer.php';