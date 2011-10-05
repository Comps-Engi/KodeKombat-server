<?php
require_once 'setup.php';

$view = array();

fAuthorization::setLoginPage('/login');

// Home

function home() {
    $user = current_user();
	if (!empty($user)) {
	    $title = sprintf("%s's Dashboard", $user->getUsername());
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
        redirect('profile', array('username' => $usr->getUsername()));
    }
	redirect('game');
}

get('/', 'index', 'index');

// Signup

function signup() {

    render('signup');
}
get('/signup', 'signup', 'signup');

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
    $uname    = $_POST['users-username'];
    $password = $_POST['users-password'];

    if ($user = User::auth($uname, $password)) {
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
        redirect('profile', array('username' => $user->getUsername()));
    } else {
        view('error', 'Could not create user');
        render('error');
    }
}
post('/user', 'newuser', 'post_user');

// Logout

function logout() {
    fAuthorization::destroyUserInfo();
	fSession::set('userid', NULL);

	redirect('index');
}

get('/logout', 'logout', 'logout');

// Profile

function show_profile() {
	$user = new User(array('username' => $_GET['username']));

	view('username', $user->getUsername());
	view('fullname', $user->getName());
	view('email', $user->getEmail());
	view('score', $user->getScore());

	$since_id = @$_GET['since'];
	view('matches', $user->getMatches($since_id));

	render('profile');
}
get('/profile/:username', 'profile', 'show_profile');


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

// New Bot

function newbot() {
	// TODO: Upload a bot
}

post('/bot', 'newbot', 'newbot');


// Not found page
function not_found () {
    header('HTTP/1.1 404 Not Found');
    render('404');
}

run_app('not_found');
