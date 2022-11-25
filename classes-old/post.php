<?php
require_once __DIR__.'/utils.php';
require_once __DIR__.'/image.php';

class Post extends Utils {

    private $text;
    private $image;
    private $user_id;
    private $id;
    private $array;


    // CONSTS FOR VALIDATION
    private const TEXT_MIN_LENGTH = 1;
    private const TEXT_MAX_LENGTH = 200;

    private const TAGS_REGEX = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð0123456789]+$/u";
    private const TAGS_MIN_LENGTH = 1;
    private const TAGS_MAX_LENGTH = 50;

    private const VALID_IMG_FORMATS = ['image/png', 'image/jpeg'];

    private const POST_ID_REGEX = '/^post:[a-zA-z0-9]{20}$/';

    private const ID_REGEX = '/^[1-9][0-9]*$/';


    // DATA VALIDATION
    private function validate_text($text) {
        if ( !isset($text) ) self::client_err('Please provide a text');
        $text = trim($text);
        $err_message = 'Invalid text';
        if ( strlen($text) < self::TEXT_MIN_LENGTH ) self::client_err($err_message);
        if ( strlen($text) > self::TEXT_MAX_LENGTH ) self::client_err($err_message);
        return $text;
    }

    private function validate_id($id) {
        if ( !isset($id) ) self::client_err('No content', 204);
        if ( !preg_match(self::ID_REGEX, $id) ) self::client_err('No content', 204);
        return $id;
    }


    //GETTERS
    public function array() {
        return $this->array;
    }


    //DB METHODS
    public function create() :void {
        // Secure that required globals are set (Some are optional)
        if ( !isset($_SESSION['user_id']) ) self::client_err('Unauthorized attempt', 401);
        if ( !isset($_POST['text']) && !isset($_FILES['image']) ) self::client_err('Please provide a text or image');

        // Validate and set values
        if ( isset($_POST['text']) ) $this->text = self::validate_text($_POST['text']);
        if ( isset($_FILES['image']) ) {
            $image = new Image($_FILES['image']);
            $this->image = $image->file_name();
        }
        $this->user_id = $_SESSION['user_id'];

        $db = new PreDO();
        $q = $db->prepare('CALL INSERT_post (:user_id, :text, :image)');
        $q->bindValue(':user_id', $this->user_id);
        $q->bindValue(':text', $this->text);
        $q->bindValue(':image', $this->image);
        $q->execute();
        $post_array = $q->fetch();
        $this->id = $post_array['post_id'];
        $this->array = [ $post_array ];
    }

    public function delete($id) {
        $this->id = self::validate_id($id);
        $this->user_id = $_SESSION['user_id'];
        $db = new PreDO();
        $q = $db->prepare('CALL DELETE_post (:post_id, :user_id)');
        $q->bindValue(':post_id', $this->id);
        $q->bindValue(':user_id', $this->user_id);
        $q->execute();
        $image_name = $q->fetch();
        if ( $q->rowCount() === 0 ) self::client_err("No content", 204);
    }

    public function like() {
        $this->id = self::validate_id($_POST['post_id']);
        $this->liker_id = $_SESSION['user_id'];
        $db = new PreDO();
        $q = $db->prepare('CALL INSERT_like (:post_id, :user_id)');
        $q->bindValue(':post_id', $this->id);
        $q->bindValue(':user_id', $this->liker_id);
        $q->execute();
        if ( $q->rowCount() === 0 ) self::client_err("No content", 204);
    }

    public function unlike() {
        $this->id = self::validate_id($_POST['post_id']);
        $this->liker_id = $_SESSION['user_id'];
        $db = new PreDO();
        $q = $db->prepare('CALL DELETE_like (:post_id, :user_id)');
        $q->bindValue(':post_id', $this->id);
        $q->bindValue(':user_id', $this->liker_id);
        $q->execute();
        if ( $q->rowCount() === 0 ) self::client_err("No content", 204);
    }

    public function get_ten_newest($offset = 0) :void {
        $db = new PreDO();
        $q = $db->prepare('CALL SELECT_post_chunk (:offset)');
        $q->bindValue(':offset', $offset);
        $q->execute();
        $this->array = $q->fetchAll();
    }
}