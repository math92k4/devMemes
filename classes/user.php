<?php
require_once __DIR__.'/connection.php';

class User {

    private const OFFSET_REGEX = '/^[0-9][0-9]*$/';
    private const OFFSET_ERR_MESSAGE = 'Offset must be a >= 0 integer';

    private const USER_ID_REGEX = '/^[1-9][0-9]*$/';
    private const USER_ID_ERR_MESSAGE = 'User id must be a postive integer';

    private function validateUserId($user_id) :void {
        if (!preg_match(self::USER_ID_REGEX, $user_id)) {
            throw new Exception (self::OFFSET_ERR_MESSAGE);
        }
    }

    private function validateOffset($offset) :void {
        if (!preg_match(self::OFFSET_REGEX, $offset)) {
            throw new Exception (self::OFFSET_ERR_MESSAGE);
        }
    }

    public function delete($user_id) {
        self::validateUserId($user_id);
        $db = new DB();
        $q = $db->prepare('DELETE FROM users WHERE user_id = :user_id');
        $q->bindValue(':user_id', $user_id);
        $q->execute();
    }

    public function allImages($user_id) {
        self::validateUserId($user_id);
        $sql = <<<TEXT
        SELECT user_image AS image FROM users 
        WHERE user_id = :user_id
        UNION
        SELECT post_image AS image FROM posts 
        WHERE fk_user_id = :user_id
        AND post_image IS NOT NULL
        TEXT;

        $db = new DB();
        $q = $db->prepare($sql);
        $q->bindValue(':user_id', $user_id);
        $q->execute();
        $res = $q->fetchAll();
        return $res;
    }

    public function listAll($offset) :array {
        self::validateOffset($offset);
        $db = new DB();
        $q = $db->prepare('SELECT * FROM users_view LIMIT 25 OFFSET :offset');
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        $res = $q->fetchAll();
        return $res;
    }

    public function countAll() :int {
        $db = new DB();
        $q = $db->prepare('SELECT COUNT(*) AS total FROM users');
        $q->execute();
        $total = $q->fetch()['total'];
        return $total;
    }
}