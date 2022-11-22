<?php
require_once __DIR__.'/utils.php';

class Image {

    private $file_name;

    public function __construct($image) {
        if ( !isset($image) ) self::client_err('No image uploaded');
        $this->file_name = self::validate_image($image);
    }

    public function file_name() {
        return $this->file_name;
    }

    private function validate_image($image) :string {
        // Validate
        if($image['error'] === UPLOAD_ERR_INI_SIZE) self::client_err('Image too large');
        $item_image_temp_name = $image["tmp_name"]; // C:\xampp\tmp\php791.tmp || C:\xampp\tmp\php5245.tmp
        $target_dir = "images/";
        $target_file = $target_dir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // just reads the extension of the file
        $image_mime = mime_content_type($image["tmp_name"]); // reads the mime inside the file
        $accepted_image_formats = ['image/png', 'image/jpeg'];
        if( ! in_array($image_mime, $accepted_image_formats) ) self::client_err('Image not allowed');

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
        if (move_uploaded_file($image["tmp_name"], "public/images/uploads/$random_image_name")) {
            return $random_image_name;
        }

        // Image not uploaded
        throw new Exeption('Could not upload image');
    }
}