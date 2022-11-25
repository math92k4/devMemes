<?php
require_once __DIR__.'/../_x.php';

// Session not set - redir frontpage
_validate_session();
if ( !$_SESSION ) {
    header('Location: /');
    exit();
}

// Remove session from db
try {
    $db = new DB();
    $q = $db->prepare('DELETE FROM sessions WHERE fk_user_id = :user_id AND session_id = :session_id');
    $q->bindValue(':user_id', $_SESSION['user_id']);
    $q->bindValue(':session_id', $_SESSION['session_id']);
    $q->execute();
} catch (Exception $ex) {
    // Exception shouldt stop the sign-out
    // TODO  Maybe log error
}

//Empty session
session_destroy();

header('Location: /');




