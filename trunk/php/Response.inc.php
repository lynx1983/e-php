<?php

//! HTTP-response utilities
class Response
{
    //! Sets status line of the HTTP-response
    /*!
	\param $statusCode status code
	\param $reasonPhrase reason phrase
	\return void
    */
    public static function setStatus($statusCode, $reasonPhrase)
    {
	header($_SERVER['SERVER_PROTOCOL'] . ' ' . $statusCode . ' ' . $reasonPhrase);
    }
    //! Redirects client to the specified URL and terminates execution
    /*!
	\param $url URL to redirect to
	\param $params parameters to appent to URL (TODO)
	\return void
    */
    public static function redirect($url, $params = NULL)
    {
	header('Location: ' . $url);
	exit(0);
    }

}

?>
