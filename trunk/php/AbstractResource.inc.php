<?php

//! Base class for any resource
abstract class AbstractResource
{
    private $_uri;
    private $_sourceDir;
    private $_indexFileNames;
    private $_get;
    private $_post;
    private $_cookie;

    //! Constructs the object
    /*!
	\param $configContainer container with configuration values. Supported configuration parameters:
	- 'cookie' used to substitute request's cookie container;
	- 'get' - used to substitute request's get container;
	- 'indexFileNames' - array of index filenames;
	- 'post' - used to substitute request's post container;
	- 'sourceDir' - where to find out resource files;
	- 'uri' - used to substitute request's uri.
    */
    public function __construct($configContainer = NULL)
    {
	$this->setUri(Container::value($configContainer, 'uri', Request::uri()));
	$this->setSourceDir(Container::value($configContainer, 'sourceDir', '.'));
    	$this->setIndexFileNames(Container::value($configContainer, 'indexFileNames', $this->defaultIndexFileNames()));
    	$this->setGet(Container::value($configContainer, 'get', Request::get()));
    	$this->setPostContainer(Container::value($configContainer, 'post', Request::post()));
    	$this->setCookie(Container::value($configContainer, 'cookie', Request::cookie()));
    }
    //! Override this method for your behaviour.
    abstract public function generate();
    //! Returns request URI
    public final function uri()
    {
	return $this->_uri;
    }
    //! Sets request URI. It could be also set using 'uri' configuration parameter of the ctor.
    public final function setUri($newRequestUri)
    {
	$this->_uri = $newRequestUri;
    }
    //! Returns the directory where to find documents to send to the client.
    public final function sourceDir()
    {
	return $this->_sourceDir;
    }
    //! Sets the directory where to find documents to send to the client. Current script's directory is the default value. It could be also set using 'sourceDir' configuration parameter of the ctor.
    public final function setSourceDir($newSourceDir)
    {
	$this->_sourceDir = $newSourceDir;
    }
    //! Returns an array of filenames which should be treated as index documents
    public final function indexFileNames()
    {
	return $this->_indexFileNames;
    }
    //! Sets an array of filenames which should be treated as index documents. It could be also set using 'indexFileNames' configuration parameter of the ctor.
    public final function setIndexFileNames($newValue)
    {
	if (is_array($newValue)) {
	    $this->_indexFileNames = $newValue;
	} else {
	    throw new Exception('\'indexFileNames\' option should be an array.');
	}
    }
    //! Return filtered integer value or defaultValue on filter failure
    public final function filterInteger($value, $defaultValue = NULL)
    {
	if (filter_var($value, FILTER_VALIDATE_INT) !== FALSE) {
	    return (int)$value;
	} else {
	    return (int)$defaultValue;
	}
    }
    //! Returns request's GET param value or GET container if no param name provided
    /*!
	\param $paramName parameter name.
	\param $defaultValue default value if no parameter found.
	\return GET param value or GET container if no param name provided
    */
    public final function get($paramName = NULL, $defaultValue = NULL)
    {
	if (is_string($paramName)) {
	    return Container::value($this->_get, $paramName, $defaultValue);
	} else {
	    return $this->_get;
	}
    }
    //! Sets request's GET container. It could be also set using 'get' configuration parameter of the ctor.
    public final function setGet($newValue)
    {
	if (Container::isContainer($newValue)) {
	    $this->_get = $newValue;
	} else {
	    throw new Exception('\'get\' option should be a container.');
	}
    }
    //! Sets request's GET param value.
    /*!
	\param $name param name
	\param $value param value
	\return void
    */
    public final function setGetValue($name, $value)
    {
	Container::setValue($this->_get, $name, $value);
    }
    //! Returns request's POST param value or POST container if no param name provided
    /*!
	\param $paramName parameter name.
	\param $defaultValue default value if no parameter found.
	\return POST param value or POST container if no param name provided
    */
    public final function post($paramName = NULL, $defaultValue = NULL)
    {
	if (is_string($paramName)) {
	    return Container::value($this->_post, $paramName, $defaultValue);
	} else {
	    return $this->_post;
	}
    }
    //! Sets request's POST container.  It could be also set using 'post' configuration parameter of the ctor.
    public final function setPostContainer($newValue)
    {
	if (Container::isContainer($newValue)) {
	    $this->_post = $newValue;
	} else {
	    throw new Exception('\'post\' option should be a container.');
	}
    }
    //! Sets request's POST param value.
    /*!
	\param $name param name
	\param $value param value
	\return void
    */
    public final function setPostValue($name, $value)
    {
	Container::setValue($this->_post, $name, $value);
    }
    //! Returns request's COOKIE param value or COOKIE container if no param name provided
    /*!
	\param $paramName parameter name.
	\param $defaultValue default value if no parameter found.
	\return COOKIE param value or COOKIE container if no param name provided
    */
    public final function cookie($paramName = NULL, $defaultValue = NULL)
    {
	if (is_string($paramName)) {
	    return Container::value($this->_cookie, $paramName, $defaultValue);
	} else {
	    return $this->_cookie;
	}
    }
    //! Sets request's COOKIE container.  It could be also set using 'cookie' configuration parameter of the ctor.
    public final function setCookie($newValue)
    {
	if (Container::isContainer($newValue)) {
	    $this->_cookie = $newValue;
	} else {
	    throw new Exception('\'cookie\' option should be a container.');
	}
    }
    //! Sets request's COOKIE value.
    /*!
	\param $name cookie name
	\param $value cookie value
	\return void
    */
    public final function setCookieValue($name, $value)
    {
	Container::setValue($this->_cookie, $name, $value);
    }
    //! Returns default index filenames array
    protected function defaultIndexFileNames()
    {
	return array('index.html');
    }
    //! Composes URL
    /*!
    	\param $path path part of the URL (could contain query part)
	\param $query query part of the URL (string or container)
	\param $extra URL extra parts associative container. Following keys are supported:
	    - 'scheme' - scheme part of the URL
	    - 'host' - host part of the URL
	    - 'port' - port part of the URL
	\return new composed URL
    */
    protected final function composeUrl($path, $query = NULL, $extra = NULL)
    {
	if (!is_string($path) || ($path == '') || ($path{0} != '/')) {
	    throw new Exception('Invalid URL path: \'' . $path . '\'');
	}
	$result = (is_array($extra) && is_string($extra['scheme']) && ($extra['scheme'] != '')) ? $extra['scheme'] : ((isset($_SERVER['HTTPS'])) ? 'https' : 'http' ) . '://';
	$result .= (is_array($extra) && is_string($extra['host']) && ($extra['host'] != '')) ? $extra['host'] : $_SERVER['SERVER_NAME'];
	if (is_array($extra) && array_key_exists('port', $extra) && ((int) $extra['port'] > 0)) {
	    $result .= ':' . $extra['port'];
	} elseif ($_SERVER['SERVER_PORT'] != '80') {
	    $result .= ':' . $_SERVER['SERVER_PORT'];
	}
	$result .= parse_url($path, PHP_URL_PATH);
	$queryPart = parse_url($path, PHP_URL_QUERY);
	if (is_string($query)) {
	    $queryPart .= (($queryPart == '') ? '' : '&') . $query;
	} elseif (is_array($query)) {
	    $queryPart .= (($queryPart == '') ? '' : '&') . http_build_query($query);
	}
	if ($queryPart != '') {
	    $result .= ('?' . $queryPart);
	}
	return $result;
    }
    //! Composes HTML for select control
    /*!
    	\param $attributes <select> tag attributes
    	\param $dataSet array of containers with data
    	\param $keyName name of the key in data row
    	\param $valueName name of the value data row
    	\param $selectedKey key which values has to be selected
	\return HTML for select control
    */
    protected final function composeSelectHtml($attributes, &$dataSet = NULL, $keyName = '', $valueName = '', $selectedKey = -1)
    {
	$result = '<select';
	foreach ($attributes as $attributeName => $attributeValue) {
	    $result .= ' ' . $attributeName . '="' . $attributeValue . '"';
	}
	$result .= '>';
	if(Container::isContainer($dataSet)) {
	    foreach ($dataSet as $dataRow) {
		$dataRowKey = Container::value($dataRow, $keyName);
		$dataRowValue = Container::value($dataRow, $valueName);
		$result .= '<option value="' . htmlspecialchars($dataRowKey) . '"' . (($dataRowKey == $selectedKey) ? ' selected' : '') . '>' . htmlspecialchars(Container::value($dataRow, $valueName)) . '</option>';
	    }
	}
	$result .= '</select>';
	return $result;
    }
    //! Inspects value to be an integer (Obsoleted! Use Types class!)
    /*!
	\param $value value to inspect
	\return TRUE if the value is integer or FALSE otherwise
    */
    protected final function isInteger($value)
    {
	return (preg_match('/^[+-]?\d+$/', trim($value)) == 1);
    }
    //! Inspects value to be an empty string (Obsoleted! Use Types class!)
    /*!
	\param $value value to inspect
	\return TRUE if the value is empty string or FALSE otherwise
    */
    protected final function isEmptyString($value)
    {
	return !isset($value) || (trim($value) == '');
    }
    //! Inspects value to be a string containing valid W3C date (Obsoleted! Use Types class!)
    /*!
	\param $value value to inspect in W3C format (example: 2005-08-15)
	\return TRUE if the value is a string containing valid date or FALSE otherwise

	NOTE! This method does not work correct at the moment! It should be amended in future!
    */
    protected final function isDate($value)
    {
	if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', trim($value), $matches) != 1) {
	    return FALSE;
	}
    	return checkdate($matches[2], $matches[3], $matches[1]);
    }
}

?>
