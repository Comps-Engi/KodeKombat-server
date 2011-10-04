<?php
require_once 'setup.php';

$view = array();

fAuthorization::setLoginPage('/login');

get('/home', 'home', function () {
    $user = current_user();
	if (!empty($user)) {
	    $title = sprintf("%s's Dashboard", $user->getUsername());
	}
    view('title', $title);
    fAuthorization::requireLoggedIn();
    render('home');
});

get('/', 'index', function() {
	$usr = current_user();
    if (!empty($usr)) {
        redirect('profile', array('username' => $usr->getUsername()));
    }
	redirect('game');
});

get('/signup', 'signup', function() {

    render('signup');
});

get('/game', 'game', function() {
    render('game');
});

get('/login', 'login', function() {
	view('error', 'You need to login to view this page.');
	render('error');
});

post('/login', 'login', function() {
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
});

post('/user', 'newuser', function() {
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
});

get('/logout', 'logout', function() {
    fAuthorization::destroyUserInfo();
	fSession::set('userid', NULL);

	redirect('index');
});

get('/profile/:username', 'profile', function () {
    // TODO: Show user's profile
	$user = new User(array('username' => $_GET['username']));

	view('username', $user->getUsername());
	view('fullname', $user->getName());
	view('email', $user->getEmail());
	view('score', $user->getScore());

	$since_id = @$_GET['since'];
	view('matches', $user->getMatches($since_id));

	render('profile');
});

get('/bots', 'listbots', function () {
    // TODO: Show bot
});

get('/matches', 'matches', function () {

	if (isset($_GET['bot'])) {
		if (intval($_GET['bot'])) {
			view('matches', Match::getMatches());
		}
	}

	view('matches', Match::getMatches());
	render('matches');
});

get('/match/:id', 'match', function() {
	// TODO: Show game viewer
});

get('/tutorials', 'tutorials', function() {
	render('tutorials');
});

get('/upload', 'upload', function() {
	if (current_user()) {
		render('upload');
	} else {
		view('error', 'You need to be logged in to upload.');
		render('error');
	}
});

post('/bot', 'newbot', function () {
    // TODO: Upload a bot
});

function not_found () {
    header('HTTP/1.1 404 Not Found');
    render('404');
}

run_app('not_found');
