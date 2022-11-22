<?php

require_once __DIR__.'/classes/db_conn.php';


function _respond($message='', $status=200) {
    http_response_code($status);
    header('Content-Type: application/json');
    $res = is_array($message) ? $message : ['info' => $message];
    echo json_encode($res);
    exit();
}

// Cleans up the $_SESSION global, and compares it against DB
function _validate_session() {
    // Should contain * or nothing
    if (!isset($_SESSION['user_id'])    ||
        !isset($_SESSION['user_alias']) ||
        !isset($_SESSION['user_email']) ||
        !isset($_SESSION['user_image']) ||
        !isset($_SESSION['session_id'])
    ) {
        $_SESSION = array();
        return;
    }

    // Validate session with DB
    try {
        $db = new PreDO();
        $q = $db->prepare('SELECT * FROM sessions WHERE fk_user_id = :user_id AND session_id = :session_id');
        $q->bindValue(':user_id', $_SESSION['user_id']);
        $q->bindValue(':session_id', $_SESSION['session_id']);
        $q->execute();
        $count = $q->rowCount();
        if ( $count === 0 ) $_SESSION = array();

    // Beter safe than sorry    
    } catch (Exeption $ex) {
        $_SESSION = array();
    }
}