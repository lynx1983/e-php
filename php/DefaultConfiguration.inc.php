<?php

//! Base class for deployment's configuration
class DefaultConfiguration
{
    const LOGS_PATH = '../logs';
    const ERROR_LOG_FILENAME = 'error.log';
    const WARNING_LOG_FILENAME = 'warning.log';
    const NOTIFY_LOG_FILENAME = 'notify.log';
    const TRANSLATOR_CLASS_NAME = 'DummyTranslator';

    public static function logFilename($level)
    {
	if ($level == Logging::ERROR) {
	    return Configuration::LOGS_PATH . '/' . Configuration::ERROR_LOG_FILENAME;
	} elseif ($level == Logging::WARNING) {
	    return Configuration::LOGS_PATH . '/' . Configuration::WARNING_LOG_FILENAME;
	} elseif ($level == Logging::NOTIFY) {
	    return Configuration::LOGS_PATH . '/' . Configuration::NOTIFY_LOG_FILENAME;
	} else {
	    throw new Exception('Invalid log level: "' . $level . '"');
	}
    }

    //! Factory method to create AbstractResource descendant's instance for generating '200 OK' HTTP-response
    public static function createOkResource()
    {
	return new FileResource();
    }
    //! Factory method to create AbstractResource descendant's instance for generating '404 Not found' OK HTTP-response
    public static function createNotFoundResource()
    {
	return new NotFoundResource();
    }
}

?>
