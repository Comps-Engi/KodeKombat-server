<?php

class ServerException extends Exception {}

// Utilities
$_actions = array();

function config($key) {
    global $config;
    if (isset($config[$key])) {
        return $config[$key];
    } else {
        return false;
    }
}

function make_url($end) {
    $root = config('webroot');
    if (!$root) {
        throw new ServerException('Webroot not set');
    }
    return $root . $end;
}

function debug($line) {
    if (config('logfile')) {
        $fp = fopen(config('logfile'), 'a');
        fwrite($fp, "\n " . date('[Y-m-d H:i:s] ', time()) . $line);
        fclose($fp);
        return true;
    } else return false;
}

// Controllers
$_actions = array();

function get($route, $name, $callback) {
    global $_actions;
    $_actions[$name] = $route;

    if (fRequest::isGet()) {
        Moor::route($route, $callback);
    }
}

function post($route, $name, $callback) {
    global $_actions;
    $_actions[$name] = $route;

    if (fRequest::isPost()) {
        Moor::route($route, $callback);
    }
}

function run_app($notfound) {
    Moor::setNotFoundCallback($notfound)->run();
}

function url($action, $args) {
    global $_actions;

    if (isset($_actions[$action])) {
        $url = $_actions[$action];

        foreach ($args as $key => $val) {
            $url = str_replace(":$key", $val, $url);
        }
        return make_url($url);
    }
    return '';
}

function render($template) {
    global $view, $config;

    if (empty($view['title'])) {
        $view['title'] = ucfirst($template);
    }

    if (empty($view['current_user'])) {
        $view['current_user'] = current_user();
    }

    $view['config'] = $config;
    $loader = new Twig_Loader_Filesystem(INSTDIR . '/views');
    $twig = new Twig_Environment($loader, array(
      #'cache' => '/tmp/'
    ));

    $template = $twig->loadTemplate($template . '.html');
    $template->display($view);

    exit(0);
}

function redirect($action, $data=array()) {
    fURL::redirect(url($action, $data));
    exit(0);
}

function password_salt($str) {
    return md5($str);
}

function view($key, $val) {
    global $view;
    return $view[$key] = $val;
}

function current_user($user=null) {
    if ($user instanceof User) {
        fSession::set('userid', $user->id);
    }
    $id = fSession::get('userid', false);

    if ($id) {
        return new User(intval($id));
    }
    return false;
}
