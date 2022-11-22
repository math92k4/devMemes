<?php
require_once __DIR__.'/client_err.php';
require_once __DIR__.'/db_conn.php';

class Utils {

    public function client_err($message, $status_code = 400) : void {
        throw new ClientErr($message, $status_code);
    }

}