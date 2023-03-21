<?php
require_once __DIR__ . '/vendor/autoload.php';
function loader($className) {
        if (file_exists(__DIR__ . '/' . $className . '.php')) require_once __DIR__ . '/' . $className . '.php';
}

spl_autoload_register('loader');

