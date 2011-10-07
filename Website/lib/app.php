<?php

define('PAGINATION', 20);

require_once 'setup.php';

$view = array();

fAuthorization::setLoginPage('/login');

// Home

function home() {
    $user = current_user();
	if (!empty($user)) {
	    $title = sprintf("%s's Dashboard", $user->getName());
	}
    view('title', $title);
    fAuthorization::requireLoggedIn();
    render('home');
}

get('/home', 'home', 'home');

// Index

function index() {
	$usr = current_user();
    if (!empty($usr)) {
        redirect('profile', array('id' => $usr->getId()));
    }
	redirect('game');
}

get('/', 'index', 'index');

// Signup

function signup() {

    render('signup');
}
# get('/signup', 'signup', 'signup');

// Game

function game() {
    render('game');
}

get('/game', 'game', 'game');

// Login Page

function login() {
	view('error', 'You need to login to view this page.');
	render('error');
}
get('/login', 'login', 'login');

// Login Action

function post_login() {
    $email    = $_POST['users-email'];
    $password = $_POST['users-password'];

    if ($user = User::auth($email, $password)) {
        fAuthorization::setUserAuthLevel($user->getType());
        current_user($user);
        if (fRequest::get('redirect')) {
            fURL::redirect(fRequest::get('redirect'));
        } else {
            redirect('home');
        }
    } else {
        view('error', 'Invalid username or password');
        render('error');
    }
}

post('/login', 'login', 'post_login');

// New user

function post_user() {
    $user = new User();
    $user->populate();
    $user->setPassword(
        password_salt($user->getPassword())
    );
    $user->store();
    if ($user) {
        current_user($user);
        redirect('profile', array('id' => $user->getId()));
    } else {
        view('error', 'Could not create user');
        render('error');
    }
}
# post('/user', 'newuser', 'post_user');

// Logout

function logout() {
    fAuthorization::destroyUserInfo();
	fSession::set('userid', NULL);

	redirect('index');
}

get('/logout', 'logout', 'logout');

// Problem statement

function problem() {
	render('problem');
}

get('/problem', 'problem', 'problem');

// Profile

function show_profile() {
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
	} else {
		view('error', 'No profile ID given.');
		render('error');
		return;
	}

	try {
		$user = new User($id);

		view('fullname', $user->getName());
		view('email', $user->getEmail());
		view('score', $user->getScore());
		view('rank', $user->getRank());

		$since_id = @$_GET['since'];
		view('matches', $user->getMatches($since_id));

		render('profile');
	} catch(Exception $e) {
		view('error', $e->getMessage());
		render('error');
	}
}
get('/profile/:id', 'profile', 'show_profile');


// Show matches

function show_matches() {

	if (isset($_GET['bot'])) {
		if (intval($_GET['bot'])) {
			view('matches', Match::getMatches());
		}
	}

	view('matches', Match::getMatches());
	render('matches');
}

get('/matches', 'matches', 'show_matches');

// Leaderboard

function scoreboard() {
	if (isset($_GET['page'])) {
		$page = intval($_GET['page']);
	} else {
		$page = 1;
	}

	$offset = ($page - 1) * PAGINATION;
	$users = User::getHighScorers($offset, PAGINATION);

	view('scoreboard_users', $users);
	render('scoreboard');
}

get('/scoreboard', 'scoreboard', 'scoreboard');

// Match viewer

function show_viewer() {
	// TODO: Show game viewer
}
get('/match/:id', 'match', 'show_viewer');

// Tutorials

function tutorials() {
	render('tutorials');
}
get('/tutorials', 'tutorials', 'tutorials');

// Upload page

function upload() {
	if (current_user()) {
		render('upload');
	} else {
		view('error', 'You need to be logged in to upload.');
		render('error');
	}
}

get('/upload', 'upload', 'upload' );

// FAQ

function faq() {
	render('faq');
}

get('/faq', 'faq', 'faq');

// New Bot

function newbot() {

	$uploader = new fUpload();

	$uploader->setMIMETypes(
		array(
			'application/zip', 'application/x-zip', 'application/x-zip-compressed', 'application/x-compress', 'application/x-compressed', 'multipart/x-zip', # zip
	'application/gzip', 'application/x-gzip', 'application/x-gunzip', 'application/gzipped', 'application/gzip-compressed', 'application/x-compressed', 'application/x-compress', 'gzip/document'),
  	  	'That file format is not supported.'
	);

	$uploader->setMaxSize('2m');

	try {
		$file = $uploader->move(INSTDIR . '/botfiles', 'bot_file');

		$user = current_user();
		if ($user) {
			$bot = new Bot();
			$bot->setFilesize($file->getSize());
			$bot->setFiletype($file->getExtension());
			$bot->setFilepath($file->getPath());
			$bot->setUserId($user->getId());

			$bot->store();
			view('message', 'Bot uploaded successfully!');
			view('bots', $user->getBots());
			render('bots');
		}

	} catch (Exception $e) {
		view('error', $e->getMessage());
		render('error');
	}
}

post('/bots', 'newbot', 'newbot');

// Show bots

function show_bots() {

	$user = current_user();

	if ($user) {
		view('bots', $user->getBots());
		render('bots');
	}

	redirect('login');
}

get('/bots', 'bots', 'show_bots');


// Not found page
function not_found () {
    header('HTTP/1.1 404 Not Found');
    render('404');
}

run_app('not_found');
