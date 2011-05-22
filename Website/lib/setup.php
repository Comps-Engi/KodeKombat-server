<?php

define('INSTDIR', dirname(dirname(__FILE__)));

require_once 'config.php';

session_start();

require_once INSTDIR . '/ext/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

function fluorish_autoload ($cls) {
    if ($cls[0] == 'f') {
        $file = INSTDIR . '/ext/fluorish/' . $cls . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

spl_autoload_register('fluorish_autoload');

fAuthorization::setAuthLevels(
    array(
        'admin' => 100,
        'user'  => 50,
        'guest' => 25
    )
);

require_once INSTDIR . '/ext/moor/Moor.php';

Moor::enableDebug();
if (isset($config['routeprefix'])) {
    Moor::setUrlPrefix($config['routeprefix']);
}
require_once 'util.php';

$db = new fDatabase('mysql',
    config('db'),
    config('db_user'),
    config('db_password'),
    config('db_host')
);

fORMDatabase::attach($db);

require_once 'models.php';
