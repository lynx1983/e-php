<?php

//! Not found exception
class NotFoundException extends Exception
{
    private $_uri;
    //! Constructs the object
    /*!
	\param $uri URI that is not found on the server
    */
    public function __construct($uri)
    {
	$this->_uri = $uri;
	parent::__construct($uri . ' is not found on server', 0);
    }
    //! Returns URI that is not found on the server
    public function uri()
    {
	return $this->_uri;
    }
}

?>
