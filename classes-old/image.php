<?php
require_once __DIR__.'/utils.php';

class Image {

    private $file_name;

    private const TARGET_DIR = "public/images/uploads/";
    private const ACCEPTEPT_IMAGE_FORMATS = ['image/png', 'image/jpeg'];

    private const FILE_NAME_REGEX = 'TODO';

    public function __construct($image = false) {
        if ( !$image ) return;
        $this->file_name = self::upload($image);
    }

    public function file_name() : string {
        return $this->file_name;
    }
    public function set_file_name($file_name) :void {
        $this->file_name = $file_name;
    }

    public function delete() :string {
        if ( !isset($this->file_name) ) return false;
        // unlink( self::TARGET_DIR . $file_name );
        return true;
    }

    private function upload($image) :string {
        // Validate
        if($image['error'] === UPLOAD_ERR_INI_SIZE) self::client_err('Image too large');
        $item_image_temp_name = $image["tmp_name"]; // C:\xampp\tmp\php791.tmp || C:\xampp\tmp\php5245.tmp
        $target_file = self::TARGET_DIR . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // just reads the extension of the file
        $image_mime = mime_content_type($image["tmp_name"]); // reads the mime inside the file
        if( ! in_array($image_mime, self::ACCEPTEPT_IMAGE_FORMATS) ) self::client_err('Image not allowed');
        // Rnd image name
        $random_image_name = bin2hex(random_bytes(16));
        switch($image_mime){
            case 'image/png':
                $random_image_name .= '.png';
            break;
            case 'image/jpeg':
                $random_image_name .= '.jpeg';
            break;
        }
        // Succes
        if (move_uploaded_file($image["tmp_name"], self::TARGET_DIR . $random_image_name)) {
            return $random_image_name;
        }
        // Image not uploaded
        throw new Exeption('Could not upload image');
    }
}