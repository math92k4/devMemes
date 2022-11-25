<?php
require_once __DIR__.'connection.php';

class User {
    public function signUp ($alias, $email, $password) {
        $db = new DB();
        $q = $db->prepare('CALL INSERT_user (:alias, :email, :password)');
        $q->bindValue(':alias', $this->alias);
        $q->bindValue(':email', $this->email);
        $q->bindValue(':password', $this->password);
        $q->execute();
        return $q->fetch();
    }

    public function signIn ($email, $password) {
        $db = new DB();
        $q = $db->prepare('SELECT user_password, user_id FROM users WHERE user_email = :email LIMIT 1');
        $q->bindValue(':email', $email);
        $q->execute();
        $res = $q->fetch();
        $user_id = $res['user_id']; 
        $hashed_password = $res['user_password'];
        if ( !password_verify($password, $hashed_password) ) return;

        $q->prepare('CALL INSERT_session (:user_id)');
        $q->bindValue(':user_id', $user_id);
        $q->execute();
        return $q->fetch();
    }

    public function delete ($id) {
        $db = new DB();
        $q = $db->prepare('DELETE FROM users WHERE id =');
    }

    public function byAlias ($alias) {
        $db = new DB();
        $q = $db->prepare('SELECT * FROM user_view WHERE user_alias = :alias');
        $q->bindValue(':alias', $alias);
        $q->execute();
        return $q->fetch();
    }

    public function getTenNewest () {
    } 
}