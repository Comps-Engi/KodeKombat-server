<?php

require_once 'setup.php';

$view = array();

get('/', 'index', function() {
    if (fAuthorization::checkLoggedIn()) {
        redirect('profile');
    }
    render('index');
});

post('/login', 'login', function() {
    $uname    = $_POST['users-username'];
    $password = $_POST['users-password'];

    if ($user = User::auth($uname, $password)) {
        fAuthorization::setAccessLevel($user->level);
        fURL::redirect(fRequest::get('redirect'));
    } else {
        $view['error'] = "Invalid username or password.";
        render('index');
    }
});

post('/user', 'newuser', function() {
    $user = User::populate();
    $user->setPassword(
        password_salt($user->getPassword())
    );
    $user->store();
});

get('/logout', 'logout', function() {
    fAuthorization::destroyUserInfo();
});

get('/profile', 'profile', function () {
    // TODO: Show user's profile
});

get('/trial', 'trial', function () {
    // TODO: Handle match
});

get('/bots', 'listbots', function () {
    // TODO: Show bot
});

get('/bot/:id', 'showbot', function () {
    // TODO: Show a bot
});

post('/bot', 'newbot', function () {
    // TODO: Upload a bot
});
