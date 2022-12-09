<?php
class Admin {
    private const ADMIN_EMAIL = 'admin@dm.com';
    private const ADMIN_PASSWORD = 'admin123';
    
    public function verifyCridentials($email, $password) :bool {
        if ($email != self::ADMIN_EMAIL) return false;
        if ($password != self::ADMIN_PASSWORD) return false;
        return true;
    }
}