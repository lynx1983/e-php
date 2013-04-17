<?php

//! Default resource for generating '404 Not Found' HTTP-response
class NotFoundResource extends AbstractResource
{
    //! Constructs the object
    public function __construct($configContainer = NULL)
    {
	parent::__construct($configContainer);
    }
    //! Generates the resource
    public function generate()
    {
	Response::setStatus('404', 'Not Found');
	echo('<html><title>404 Not Found</title><body><h1>Not Found</h1><p>The requested URL ' . $this->uri() . ' was not found on this server.</p></body></html>');
    }
}

?>
