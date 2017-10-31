<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Controllers/RootController.php';
require __DIR__ . '/Controllers/NamespaceController.php';

define('CONTROLLERS_PATH', __DIR__ . '/Controllers');
define('ROOT_CLASS', CONTROLLERS_PATH . '/RootController.php');
define('NAMESPACE_CLASS',  CONTROLLERS_PATH . '/NamespaceController.php');
