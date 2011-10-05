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

	function getMatches($since_id=null) {
		return Match::getMatchesByUser($this->getId(), $since_id);
	}

    function getScore() {
        return 0;
    }

    function getProfileUrl() {
        return url("profile", array('username' => $this->getUsername()));
    }
}

class Bot extends fActiveRecord {

	function getUrl() {
		return url('matches') . '?bot=' . $this->id;
	}
}

class Match extends fActiveRecord {

	public $winner;
	public $loser;

	function __construct() {
		$args = func_get_args();
		call_user_func_array(array('parent', '__construct'), $args);
		$this->winner = $this->getWinner();
		$this->loser = $this->getLoser();
	}

	static function getMatches($since_id=null, $offset=0, $limit=20) {

		$args = array();

		if (!empty($since_id)) {
			$args['id>'] = intval($since_id);
		}

		$matches = fRecordSet::build('Match', $args, $offset, $limit);

		return $matches;
	}

	static function getMatchesByUser($user_id, $since_id=null, $limit=20) {

		$args = array('player_one_id=|player_two_id=' => array($user_id, $user_id));

		if (!empty($since_id)) {
			$args['id>'] = intval($since_id);
		}

		$matches = fRecordSet::build('Match', $args, 0, $limit);

		return $matches;
	}

	function getUrl() {
		return url('match', array('id' => $this->getId()));
	}

	function getWinner() {
		$winner_id = $this->getResult() === 0 ? $this->getPlayerOneId() : $this->getPlayerTwoId();

		try {
			$winner = new User(intval($winner_id));
		} catch (fNotFoundException $e) {
			return null;
		}

		return $winner;
	}

	function getLoser() {
		$loser_id = $this->getResult() === 1 ? $this->player_one_id : $this->player_two_id;
		try {
			$loser = new User(intval($loser_id));
		} catch (fNotFoundException $e) {
			return null;
		}
		return $loser;
	}

	function humanTime() {
		return $this->getTimestamp();
	}
}
