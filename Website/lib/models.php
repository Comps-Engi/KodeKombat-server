<?php

class User extends fActiveRecord {
    static function auth($username, $password) {
		try {
	        $user = new self(array('username' => $username));

	        return !empty($user) &&
    	        ($user->getPassword() == password_salt($password)) ? $user : NULL;
		} catch(fNotFoundException $e) {
			return false;
        }
    }

    function getScore() {
        return 0;
    }

    function getProfileUrl() {
        return url("profile", array('username' => $this->getUsername()));
    }
}

class Bot extends fActiveRecord {
}

class Match extends fActiveRecord {

	static function getMatches($player_one_id, $player_two_id=null, $since=null, $offset=0, $limit=20) {
		
	}

	function getWinner() {
		$winner_id = $this->getResult() == 0 ? $this->player_one_id : $this->player_two_id;
		$winner = new User($winner_id);
		return $winner;
	}

	function getLoser() {
		$loser_id = $this->getResult() == 1 ? $this->player_one_id : $this->player_two_id;
		$loser = new User($loser_id);
		return $loser;
	}

	function humanTime() {
		return $this->getTimestamp();
	}
}
