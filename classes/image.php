<?php
class Image {
    private const DIR_PATH = 'public/images/uploads/';
    private const PROTECTED_IMAGES = ['anom_cat.jpg'];

    public function delete($image) :void {
        if ( in_array($image, self::PROTECTED_IMAGES) ) return;
        unlink(self::DIR_PATH . $image);
    }
}