<?php
require_once __DIR__.'/surreal_conn.php';
require_once __DIR__.'/db_config.php';

class Post implements DbConfig {

    private $text;
    private $image;
    private $tags;


    // CONSTS FOR VALIDATION
    private const TEXT_MIN_LENGTH = 1;
    private const TEXT_MAX_LENGTH = 200;

    private const TAGS_REGEX = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð0123456789]+$/u";
    private const TAGS_MIN_LENGTH = 1;
    private const TAGS_MAX_LENGTH = 50;

    private const VALID_IMG_FORMATS = ['image/png', 'image/jpeg'];

    private const POST_ID_REGEX = '/^post:[a-zA-z0-9]{20}$/';


    // DATA VALIDATION
    private function validate_text($text) {
        $text = trim($text);
        if ( strlen($text) < self::TEXT_MIN_LENGTH ) return;
        if ( strlen($text) > self::TEXT_MAX_LENGTH ) return;
        return $text;
    }


    // COMBINED SETTERS AND GETTERS
    public function text($text = '') {
        if ( !$text ) return $this->text;

        $valid_text = self::validate_text($text);
        if ( !$valid_text ) return;
        $this->text = $valid_text;
        return $this->text;
    }


    // CREATE NEW POST IN DB
    public function create() {
        if ( !self::is_valid_text() ) return;

        $this->text = $_POST['text'];
        return true;
    }
    

}