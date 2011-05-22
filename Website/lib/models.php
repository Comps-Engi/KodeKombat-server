<?php

class User extends fActiveRecord {
    static function auth($username, $password) {
        return fRecordSet::build(
            array(
                'username' => $username,
                'password' => password_salt($password)
            )
        );
    }
}

class Bot extends fActiveRecord {}
class Match extends fActiveRecord {}
