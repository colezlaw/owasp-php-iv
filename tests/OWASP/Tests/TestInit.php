<?php
/*
 * This file bootstraps the test environment.
 */
namespace OWASP\Tests;

error_reporting(E_ALL | E_STRICT);

// Define path to lib directory
defined('LIB_PATH') || define('LIB_PATH', realpath(dirname(__FILE__) . '/../../../lib/') );
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, array(
  realpath(LIB_PATH),
)));
require_once(LIB_PATH . '/Doctrine/Common/ClassLoader.php');
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine',LIB_PATH );
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('OWASP',LIB_PATH );
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('ValidatorAnnotations',LIB_PATH.'OWASP/Validators/Annotation' );
$classLoader->register();

// register silently failing autoloader
spl_autoload_register(function($class) {
  if (0 === strpos($class, 'OWASP\Tests\\')) {
    $path = LIB_PATH . '/' . strtr($class, '\\', '/').'.php';
    if (file_exists($path) && is_readable($path)) {
      require_once $path;

      return true;
    }
  }
});
