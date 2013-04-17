<?php

//! Base abstract class for PHP resources
abstract class AbstractPhpResource extends AbstractResource
{
    //! Constructs the object
    function __construct($configContainer = NULL)
    {
	parent::__construct($configContainer);
    }
    //! Generates the resource.
    public final function generate()
    {
	$this->execute();
	$this->output();
    }
    //! This method should perform business-logic actions and should be overriden.
    abstract protected function execute();
    //! This method should output content to the client and should be overriden.
    abstract protected function output();
}

?>
