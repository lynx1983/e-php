<?php

//! PHP-script resource
/*!
    Use this resource just for executing PHP-scripts. This is default behaviour for the apache web-server.
*/
class PhpScriptResource extends FileResource 
{
    //! Constructs the object
    function __construct($configContainer = NULL)
    {
	parent::__construct($configContainer);
    }
    //! Evaluates and outputs file to the client
    protected function processFile($sourceFileName)
    {
	require($sourceFileName);
    }
    //! Returns index filenames array
    protected function defaultIndexFileNames()
    {
	return array('index.phtml', 'index.html');
    }
}

?>
