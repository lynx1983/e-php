<?php

//! HTTP-request utilities
class Request
{
    //! GET param name where mod_rewrite should put request's URI (DO NOT MODIFY!!!)
    const REQUEST_URI_PARAM_NAME = '__q';

    //! Returns request URI
    public static function uri()
    {
	return (array_key_exists(self::REQUEST_URI_PARAM_NAME, $_GET)) ? $_GET[self::REQUEST_URI_PARAM_NAME] : ereg_replace('/index.php$', $_SERVER['SCRIPT_NAME'], '/');
    }
    //! Returns request's GET param value or GET container if no param name provided
    /*!
	AbstractResource descendants should use their method instead!
	\param $paramName parameter name.
	\param $defaultValue default value if no parameter found.
	\return GET param value or GET container if no param name provided
    */
    public static function get($paramName = NULL, $defaultValue = NULL)
    {
	if (is_string($paramName)) {
	    return Container::value($_GET, $paramName, $defaultValue);
	} else {
	    $get = $_GET;
	    if (array_key_exists(self::REQUEST_URI_PARAM_NAME, $get)) {
		unset($get[self::REQUEST_URI_PARAM_NAME]);
	    }
	    return $get;
	}
    }
    //! Returns request's POST param value or POST container if no param name provided
    /*!
	AbstractResource descendants should use their method instead!
	\param $paramName parameter name.
	\param $defaultValue default value if no parameter found.
	\return POST param value or POST container if no param name provided
    */
    public static function post($paramName = NULL, $defaultValue = NULL)
    {
	if (is_string($paramName)) {
	    return Container::value($_POST, $paramName, $defaultValue);
	} else {
	    return $_POST;
	}
    }
    //! Returns request's COOKIE param value or COOKIE container if no param name provided
    /*!
	AbstractResource descendants should use their method instead!
	\param $paramName parameter name.
	\param $defaultValue default value if no parameter found.
	\return COOKIE param value or COOKIE container if no param name provided
    */
    public static function cookie($paramName = NULL, $defaultValue = NULL)
    {
	if (is_string($paramName)) {
	    return Container::value($_COOKIE, $paramName, $defaultValue);
	} else {
	    return $_COOKIE;
	}
    }
}

?>
