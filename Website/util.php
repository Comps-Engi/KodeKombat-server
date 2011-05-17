<?php

class ServerException extends Exception {}

// Utilities

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
    return $root .'/' . $end;
}

function redirect($end) {
    header('Location: ' . make_url($end));
    return true;
}

function db_conn() {
    global $_con;

    if (empty($_con)) {
        $_con = mysql_connect(
            config('db_host'),
            config('db_user'),
            config('db_password')
        );

        if (!$_con)
        {
            throw new ServerException('Could not connect to DB: ' .
                mysql_error()
            );
        }
        $res = mysql_select_db(config('db'), $_con);
    }
    return $_con;
}

function db_query() {
    $args = func_get_args();
    $qry = array_shift($args);

    $conn = db_conn();

    foreach ($args as &$arg) {
        if (is_string($arg))
            $arg = mysql_real_escape_string($arg, $conn);
        if (is_bool($arg))
            $arg = (int) $arg;
    }

    $eqry = call_user_func_array('sprintf',
        array_merge(array($qry), $args)
    );

    debug("Hitting DB: " . $eqry);
    $result = mysql_query($eqry, $conn);

    if (!$result) {
        throw new ServerException('Error in a query: ' .
                mysql_error()
            );
    }

    return $result;
}

function debug($line) {
    if (config('logfile')) {
        $fp = fopen(config('logfile'), 'a');
        fwrite($fp, "\n " . date('[Y-m-d H:i:s]', time()) . $line);
        fclose($fp);
        return true;
    } else return false;
}

