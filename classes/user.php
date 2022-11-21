<?php
require_once __DIR__.'/client_err.php';
require_once __DIR__.'/db_conn.php';

class User {
    private $email;
    private $password;
    private $alias;
    private $id;


    // CONSTS FOR VALIDATION
    private const ALIAS_REGEX = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð0123456789 ,.'-]+$/u";
    private const ALIAS_MIN_LENGTH = 2;
    private const ALIAS_MAX_LENGTH = 50;

    private const PASSWORD_REGEX = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
    private const PASSWORD_MIN_LENGTH = 8;
    private const PASSWORD_MAX_LENGTH = 32;

    private const EMAIL_REGEX = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
    private const EMAIL_MIN_LENGTH = 6;
    private const EMAIL_MAX_LENGTH = 50;

    private const ID_REGEX = '/^[1-9][0-9]*$/';


    // DATA VALIDATION
    private function err($message) : void {
        throw new ClientErr($message);
    }

    private function validate_alias($alias) : string {
        if ( !isset($alias) ) return self::err('Please provide an alias');
        $alias = trim($alias);
        $err_message = 'Invalid alias';
        if ( !preg_match(self::ALIAS_REGEX, $alias) ) self::err($err_message);
        if ( strlen($alias) < self::ALIAS_MIN_LENGTH ) self::err($err_message);
        if ( strlen($alias) > self::ALIAS_MAX_LENGTH ) self::err($err_message);
        return $alias;
    }

    private function validate_password($password) : string {
        if ( !isset($password) ) return self::err('Please provide a password');
        $err_message = 'Invalid password';
        if ( !preg_match(self::PASSWORD_REGEX, $password) ) self::err($err_message);
        if ( strlen($password) < self::PASSWORD_MIN_LENGTH ) self::err($err_message);
        if ( strlen($password) > self::PASSWORD_MAX_LENGTH ) self::err($err_message);
        return $password;
    }

    private function validate_email($email) : string {
        if ( !isset($email) ) return self::err('Please provide a password');
        $email = trim($email);
        $err_message = 'Invalid email';
        if ( !preg_match(self::EMAIL_REGEX, $email) ) self::err($err_message);
        if ( strlen($email) < self::EMAIL_MIN_LENGTH ) self::err($err_message);
        if ( strlen($email) > self::EMAIL_MAX_LENGTH ) self::err($err_message);
        return $email;
    }

    private function validate_user_id($id) : void {
        if ( !preg_match(self::ID_REGEX, $id) ) self::err('No content', 204);
    }


    // COMBINED SETTERS AND GETTERS
    public function email($email = '') : string {
        if ( !$email ) return $this->email;
        
        $valid_email = self::validate_email($email);
        $this->email = $valid_email;
        return $this->email;
    }

    public function password($password = '') : string {
        if ( !$password ) return $this->password;

        $valid_password = self::validate_password($password);
        $hashed_password = password_hash($valid_password, PASSWORD_DEFAULT);
        $this->password = $hashed_password;
        return $this->password;
    }

    public function alias($alias = '') : string {
        if  ( !$alias ) return $this->alias;

        $valid_alias = self::validate_alias($alias);
        $this->alias = $valid_alias;
        return $this->alias;
    }

    public function id($id = '') : string {
        if ( !$id ) return $this->id;

        self::validate_user_id($id);
        $this->id = $id;
        return $this->id;
    }


    // POST USER TO DB
    public function create() :array {
        $this->alias = self::validate_alias($_POST['alias']);
        $this->email = self::validate_email($_POST['email']);
        $password = self::validate_password($_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $password;

        $db = new PreDO();
        $q = $db->prepare('CALL INSERT_user (:alias, :email, :password)');
        $q->bindValue(':alias', $this->alias);
        $q->bindValue(':email', $this->email);
        $q->bindValue(':password', $this->password);
        $q->execute();
        $res = $q->fetch();
        return $res;
    }

    // SELECT USER BY ID
    public function get_by_id() {
    }

    // LOGIN / Create session
    public function sign_in() {
        $this->email = self::validate_email($_POST['email']);
        $this->password = self::validate_password($_POST['password']);

        $db = new PreDO();
        $q = $db->prepare(' SELECT user_password FROM user WHERE user_email = :email LIMIT 1');
        $q->bindValue(':email', $this->email);
        $q->execute();
        $res = $q->fetch();
        return $res;
    }
}