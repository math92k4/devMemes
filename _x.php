<?php
require_once __DIR__.'/classes/connection.php';


// ##############################
// ##############################
// RESPONSE
function _respond($message='', $status=200, $as_bool = false) {
    http_response_code($status);
    header('Content-Type: application/json');
    $res = is_array($message) ? $message : ['info' => $message];
    echo json_encode($res);
    exit();
}


// ##############################
// ##############################
// VALIDATION CONSTS
define('_ALIAS_REGEX', '/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð0123456789 -]+$/u');
define('_ALIAS_MIN_LENGTH', 2);
define('_ALIAS_MAX_LENGTH', 50);

define('_PASSWORD_REGEX', '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/');
define('_PASSWORD_MIN_LENGTH', 8);
define('_PASSWORD_MAX_LENGTH', 32);

define('_EMAIL_REGEX', '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/');
define('_EMAIL_MIN_LENGTH', 6);
define('_EMAIL_MAX_LENGTH', 50);

define('_ID_REGEX', '/^[1-9][0-9]*$/');

define('_TEXT_MIN_LENGTH', 1);
define('_TEXT_MAX_LENGTH', 200);

define('_TAGS_REGEX', '/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð0123456789]+$/u');
define('_TAGS_MIN_LENGTH', 1);
define('_TAGS_MAX_LENGTH', 50);

define('_IMG_FORMATS', ['image/png', 'image/jpeg']);
define('_IMG_TARGET_DIR', 'public/images/uploads/');
define('_PROTECTED_IMGS', ['anom_cat.jpg']);


// ##############################
// ##############################
// VALIDATION FUNCTION - API
// - isset
// - clean up
// - validate
// - return
function _validate_alias($alias) {
    if ( !isset($alias) ) _respond('Please provide an alias', 400);
    $alias = trim($alias);
    $err_message = 'Invalid alias';
    if ( !preg_match(_ALIAS_REGEX, $alias) ) _respond($err_message, 400);
    if ( strlen($alias) < _ALIAS_MIN_LENGTH ) _respond($err_message, 400);
    if ( strlen($alias) > _ALIAS_MAX_LENGTH ) _respond($err_message, 400);
    return $alias;
}

function _validate_password($password) {
    if ( !isset($password) ) _respond('Please provide a password', 400);
    $err_message = 'Invalid password';
    if ( !preg_match(_PASSWORD_REGEX, $password) ) _respond($err_message, 400);
    if ( strlen($password) < _PASSWORD_MIN_LENGTH ) _respond($err_message, 400);
    if ( strlen($password) > _PASSWORD_MAX_LENGTH ) _respond($err_message, 400);
    return $password;
}

function _validate_email($email) {
    if ( !isset($email) ) _respond('Please provide an email', 400);
    $email = trim($email);
    $err_message = 'Invalid email';
    if ( !preg_match(_EMAIL_REGEX, $email) ) _respond($err_message, 400);
    if ( strlen($email) < _EMAIL_MIN_LENGTH ) _respond($err_message, 400);
    if ( strlen($email) > _EMAIL_MAX_LENGTH ) _respond($err_message, 400);
    return $email;
}

function _validate_id($id) {
    if ( !isset($id) ) _respond('Please provide an id', 400);
    $id = trim($id);
    if ( !preg_match(_ID_REGEX, $id) ) _respond('No content', 204);
    return $id; // Returns same id - just to be consistent
}

function _validate_text($text) {
    if ( !isset($text) ) _resond('Please provide a text', 400);
    $text = trim($text);
    $err_message = 'Invalid text';
    if ( strlen($text) < _TEXT_MIN_LENGTH ) _resond($err_message, 400);
    if ( strlen($text) > _TEXT_MAX_LENGTH ) _resond($err_message, 400);
    return $text;
}

function _validate_session() {
    // Cleans up the $_SESSION global, and compares it against DB
    // Should contain * or nothing
    if (!isset($_SESSION['user_id'])    ||
        !isset($_SESSION['user_alias']) ||
        !isset($_SESSION['user_email']) ||
        !isset($_SESSION['user_image']) ||
        !isset($_SESSION['session_id'])
    ) {
        session_destroy();
        return;
    }
    // Validate session with DB
    try {
        $db = new DB();
        $q = $db->prepare('SELECT * FROM sessions WHERE fk_user_id = :user_id AND session_id = :session_id');
        $q->bindValue(':user_id', $_SESSION['user_id']);
        $q->bindValue(':session_id', $_SESSION['session_id']);
        $q->execute();
        $count = $q->rowCount();
        if ( $count === 0 ) session_destroy();

    // Beter safe than sorry    
    } catch (Exeption $ex) {
        session_destroy();
    }
}

function _validate_image($image){
    if ( !isset($image) ) _respond('Plaese provide an image', 400);
    if($image['error'] === UPLOAD_ERR_INI_SIZE) _respond('Image too large', 400);
    $item_image_temp_name = $image["tmp_name"]; // C:\xampp\tmp\php791.tmp || C:\xampp\tmp\php5245.tmp
    $target_file = _IMG_TARGET_DIR . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // just reads the extension of the file
    $image_mime = mime_content_type($image["tmp_name"]); // reads the mime inside the file
    if( ! in_array($image_mime, _IMG_FORMATS) ) _respond('File format not allowed', 400);
    $random_image_name = bin2hex(random_bytes(16));
    switch($image_mime){
        case 'image/png':
            $random_image_name .= '.png';   
        break;
        case 'image/jpeg':
            $random_image_name .= '.jpeg';
        break;
    }
    if(!move_uploaded_file($image["tmp_name"], _IMG_TARGET_DIR . $random_image_name )){
        _respond('Image not uploaded', 500);
    }
    return $random_image_name;
}


// ##############################
// ##############################
// DB SELECTERS - for views
function _get_newest_posts($offset = 0) {
    // Set user id from session or set invalid
    isset($_SESSION['user_id']) ? $user_id = $_SESSION['user_id'] : $user_id = '';

    try {
        $db = new DB();
        $q = $db->prepare('CALL SELECT_newest_posts (:offset, :user_id)');
        $q->bindValue(':offset', $offset);
        $q->bindValue(':user_id', $user_id);
        $q->execute();
        return $q->fetchAll();

    } catch (Exception $ex) {
        header('Location: /500');
        exit();
    }
}

function _get_popular_posts($offset = 0 ) {
    try {
        $db = new DB();
        $q = $db->prepare('CALL SELECT_popular_posts (:offset)');
        $q->bindValue(':offset', $offset);
        $q->execute();
        return $q->fetchAll();

    } catch (Exception $ex) {
        header('Location: /500');
        exit();
    }
}

function _get_popular_users() {
    try {
        $db = new DB();
        $q = $db->prepare('CALL SELECT_popular_users');
        $q->execute();
        return $q->fetchAll();

    } catch (Exception $ex) {
        header('Location: /500');
        exit();
    }
}

function _get_user_by_alias($alias) {
    // Validate alias
    if ( !preg_match(_ALIAS_REGEX, $alias) ) return [];
    if ( strlen($alias) < _ALIAS_MIN_LENGTH ) return [];
    if ( strlen($alias) > _ALIAS_MAX_LENGTH ) return [];

    try {
        $db = new DB();
        $q = $db->prepare('CALL SELECT_user_by_alias (:alias)');
        $q->bindValue(':alias', $alias);
        $q->execute();
        return $q->fetch();

    } catch (Exception $ex) {
        header('Location: /500');
        exit();
    }
}

function _get_posts_by_alias($alias, $offset = 0) {
    // Validate alias
    if ( !preg_match(_ALIAS_REGEX, $alias) ) return [];
    if ( strlen($alias) < _ALIAS_MIN_LENGTH ) return [];
    if ( strlen($alias) > _ALIAS_MAX_LENGTH ) return [];

    try {
        $db = new DB();
        $q = $db->prepare('CALL SELECT_posts_by_alias (:alias, :offset)');
        $q->bindValue(':alias', $alias);
        $q->bindValue(':offset', $offset);
        $q->execute();
        return $q->fetchAll();

    } catch (Exception $ex) {
        // header('Location: /500');
        echo $ex;
        exit();
    }


}

// ##############################
// ##############################
// DB SELECTERS - for views
function _delete_image($image) {
    unlink(_IMG_TARGET_DIR . $image);
}