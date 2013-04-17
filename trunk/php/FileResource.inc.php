<?php

//! Filesystem object resource
/*!
    The content of the file would be sent to the client during genertion of the resource. This is default behaviour for the apache web-server.
*/
class FileResource extends AbstractResource
{

    private $_sourceFileExtension;
    private $_uriHasExtension;

    //! Construct the object
    /*!
	\param $configuration reference to the deployment's configuration instance.
	\param $configContainer container with configuration values. Supported configuration parameters:
	- 'sourceFileExtension' - filesystem object's extension;
	- 'uriHasExtension' - TRUE if the request URI should have an extension.
    */
    function __construct($configContainer = NULL)
    {
	parent::__construct($configContainer);
	$this->setSourceFileExtension(Container::value($configContainer, 'sourceFileExtension'));	    // It replaces/adds uri's extension if not null
	$this->setUriHasExtension(Container::value($configContainer, 'uriHasExtension', true));
    }
    //! Generates the resourse
    public final function generate()
    {
	// Checkout parent directories access
	if (strstr($this->uri(), '..')) {
	    throw new NotFoundException($this->uri());
	}
	// Identifying file
	$sourceFileName = $this->sourceFileName();
	if (!is_readable($sourceFileName)) {
	    throw new NotFoundException($this->uri());
	}
	// Processing file
	$this->processFile($sourceFileName);
    }
    //! Identifies filesystem object's filename.
    protected final function sourceFileName()
    {
	$uri = $this->uri();
	$sourceFileName = $this->sourceDir() . $uri;
	if ($uri{strlen($uri) - 1} == '/') {
	    foreach ($this->indexFileNames() as $indexFileName) {
		if (is_readable($sourceFileName . $indexFileName)) {
		    return $sourceFileName . $indexFileName;
		}
	    }
	    throw new NotFoundException($uri);
	} else {
	    if (is_string($this->sourceFileExtension())) {
		if ($this->uriHasExtension()) {
		    $sourceFileName = FileName::changeExtension($sourceFileName, $this->sourceFileExtension());
		} else {
		    $sourceFileName .= ('.' . $this->sourceFileExtension());
		}
	    }
	    if (!is_readable($sourceFileName)) {
		throw new NotFoundException($uri);
	    }
	    return $sourceFileName;
	}
    }
    //! Outputs file to the client.
    protected function processFile($sourceFileName)
    {
	readfile($sourceFileName);
    }
    //! Returns filesystem object's extension that would replace URI's extension
    public final function sourceFileExtension()
    {
	return $this->_sourceFileExtension;
    }
    //! Sets filesystem object's extension. It could be also set using 'sourceFileExtension' configuration parameter of the ctor.
    public final function setSourceFileExtension($newValue)
    {
	if (isset($newValue) && !is_string($newValue)) {
	    throw new Exception('\'sourceFileExtension\' option should be a String');
	}
	$this->_sourceFileExtension = $newValue;
    }
    //! Returns TRUE if the request URI should have an extension 
    public final function uriHasExtension()
    {
	return $this->_uriHasExtension;
    }
    //! Sets 'URI has extension flag.
    public final function setUriHasExtension($newValue)
    {
	if (!is_bool($newValue)) {
	    throw new Exception('\'uriHasExtension\' option should be a Boolean');
	}
	$this->_uriHasExtension = $newValue;
    }
}

?>
