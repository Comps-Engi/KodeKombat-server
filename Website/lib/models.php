<?php

class User extends fActiveRecord {
    static function auth($username, $password) {
        $user = new self(array('username' => $username));

        return !empty($user) &&
            ($user->getPassword() == password_salt($password)) ? $user : NULL;
    }
}

class Bot extends fActiveRecord {}
class Match extends fActiveRecord {}
