<?php

//! Base abstract class for PHP-templates-based PHP-resources
abstract class AbstractTemplatedPhpResource extends AbstractPhpResource
{
    private $_templatesDir;
    private $_templateFileName;

    //! Constructs the object
    /*!
	\param $configContainer container with configuration values. Supported configuration parameters:
	- 'templatesDir' - directory where to find PHP-templates;
	- 'templateFileName' - PHP-template filename.
    */
    function __construct($configContainer = NULL)
    {
	parent::__construct($configContainer);
	$this->setTemplatesDir(Container::value($configContainer, 'templatesDir', '../templates'));
	$this->setTemplateFileName(Container::value($configContainer, 'templateFileName'));
    }
    //! Performa business-logic actions.
    protected function execute()
    {}
    //! Evaluates PHP-template file.
    protected function output()
    {
	require(FileName::addTrailingSlash($this->templatesDir()) . $this->templateFileName());
    }
    //! Returns the directory where to find PHP-templates.
    public function templatesDir()
    {
	return $this->_templatesDir;
    }
    //! Sets the directory where to find PHP-templates.
    public function setTemplatesDir($newValue)
    {
	$this->_templatesDir = $newValue;
    }
    //! Returns PHP-template filename
    public function templateFileName()
    {
	return $this->_templateFileName;
    }
    //! Sets PHP-template filename
    public function setTemplateFileName($newValue)
    {
	if (isset($newValue) && !is_string($newValue)) {
	    throw new Exception('\'templateFileName\' option should be a String');
	}
	$this->_templateFileName = $newValue;
    }
}

?>
