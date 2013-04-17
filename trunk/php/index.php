<?php

// 1. Include ../htaccess to the vitrual host configuration (see ../htaccess for details)
// 2. Make a same name symlink in a virtual host's document root to this file or copy & amend it if changes are needed

//! ePhp autoload constants class
class EPhp
{
    //! Path to PHP-files of e-php
    const EPHP_PHP_PATH = '../../../e-php/php';
    //! Path to PHP-files of the project
    const PROJECT_PHP_PATH = '../../../php';
    //! Path to deployment-specific PHP-files
    const DEPLOYMENT_PHP_PATH = '../php';
    //! Path to private PHP-files of the project
    const PROJECT_PRIVATE_PHP_PATH = '../../../php/private';
    //! Path to private deployment-specific PHP-files
    const DEPLOYMENT_PRIVATE_PHP_PATH = '../php/private';
}

// Setting up autoload
require_once(EPhp::EPHP_PHP_PATH . '/PathAutoload.inc.php');
if ((is_dir(EPhp::DEPLOYMENT_PRIVATE_PHP_PATH) && is_readable(EPhp::DEPLOYMENT_PRIVATE_PHP_PATH)) &&
    (is_dir(EPhp::PROJECT_PRIVATE_PHP_PATH) && is_readable(EPhp::PROJECT_PRIVATE_PHP_PATH))) {
    PathAutoload::setPaths(array(EPhp::DEPLOYMENT_PHP_PATH, EPhp::DEPLOYMENT_PRIVATE_PHP_PATH, EPhp::PROJECT_PHP_PATH, EPhp::PROJECT_PRIVATE_PHP_PATH, EPhp::EPHP_PHP_PATH));
} else {
    PathAutoload::setPaths(array(EPhp::DEPLOYMENT_PHP_PATH, EPhp::PROJECT_PHP_PATH, EPhp::EPHP_PHP_PATH));
}
PathAutoload::register();

// Translation method
function tr($str)
{
    $translatorClassName = Configuration::TRANSLATOR_CLASS_NAME;
    return $translatorClassName::translate($str);
}

// Generating the resource
try {
    $resource = Configuration::createOkResource();
    $resource->generate();
} catch (NotFoundException $e) {
    $resource = Configuration::createNotFoundResource();
    try {
	$resource->generate();
    } catch (NotFoundException $e) {
	$resource = DefaultConfiguration::createNotFoundResource();
	$resource->generate();
    }
}

?>
