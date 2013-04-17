<?php

//! Unified interface for working with PHP-containers: arrays and objects
class Container
{
    //! Returns value corresponding to specified key of the container or default value if no key found or container is not a container.
    /*!
	\param &$container reference the the container
	\param $keyName key name
	\param $defaultValue default value
	\return value corresponding to specified key of the container or default value if no key found or container is not a container
    */
    static function value(&$container, $keyName, $defaultValue = NULL)
    {
	if (is_object($container) && property_exists($container, $keyName)) {
	    return $container->$keyName;
	} elseif (is_array($container) && array_key_exists($keyName, $container)) {
	    return $container[$keyName];
	} else {
	    return $defaultValue;
	}
    }
    //! Inspects key to exists in container
    /*!
	\param &$container reference the the container
	\param $keyName key name
	\return TRUE if the value exists in the container
    */
    static function hasValue(&$container, $keyName)
    {
	return (is_object($container) && property_exists($container, $keyName)) || (is_array($container) && array_key_exists($keyName, $container));
    }
    //! Sets value corresponding to specified key in container
    /*!
	\param &$container reference the the container
	\param $keyName key name
	\param $newValue new value to set
	\return void
    */
    static function setValue(&$container, $keyName, $newValue)
    {
	if (is_object($container)) {
	    $container->$keyName = $newValue;
	} elseif (is_array($container)) {
	    $container[$keyName] = $newValue;
	} else {
	    throw new Exception('Container must be an object or an array');
	}
    }
    //! Inspects container to ba a container
    /*!
	\param &$container reference the the container
	\return TRUE if container is a container
    */
    static function isContainer(&$container)
    {
	return (is_object($container) || is_array($container));
    }
    //! Selects data with specified keys to array
    /*!
	\param &$container reference the the container
	\param $keys keys array
	\return array with selected key/value pairs
    */
    static function select(&$container, $keys) 
    {
	$result = array();
	foreach($keys as $key) {
	    if(Container::hasValue($container, $key)) {
		$result[$key] = Container::value($container, $key);
	    }
	}
	return $result;
    }
}

?>
