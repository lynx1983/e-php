<?php

//! Class for autoloading class definitions from path array
class PathAutoload
{
    private static $_paths = array();
    //! Appends include path to the end of the include paths container
    static public final function appendPath($path)
    {
	if (!is_dir($path)) {
    	    throw new Exception(sprintf('Include path "%s" does not exists', $path));
	}
	self::$_paths[] = $path;
    }
    //! Prepends include path to the beginning of the include paths container
    public static final function prependPath($path)
    {
	if (!is_dir($path)) {
    	    throw new Exception(sprintf('Include path "%s" does not exists', $path));
	}
	array_unshift(self::$_paths, $path);
    }
    //! Sets include paths container
    public static final function setPaths($paths)
    {
	if (!is_array($paths)) {
	    throw new Exception('Include paths should be of Array type');
	}
	foreach ($paths as $path) {
	    if (!is_dir($path)) {
		throw new Exception(sprintf('Include path "%s" does not exists', $path));
	    }
	}
	self::$_paths = $paths;
    }
    //! Returns include paths container
    public static final function paths()
    {
	return self::$_paths;
    }
    //! Load class definition callback. Do not call directly!
    public static final function loadClass($className)
    {
	foreach (self::$_paths as $path) {
	    $includeFileName = $path . '/' . $className . '.inc.php';
	    if (is_readable($includeFileName)) {
		require_once($includeFileName);
		return;
	    }
	}
    }
    //! Registers autoload method in PHP
    public static final function register()
    {
	spl_autoload_register('PathAutoload::loadClass');
    }
    //! Unregisters autoload method in PHP
    public static final function unregister()
    {
	spl_autoload_unregister('PathAutoload::loadClass');
    }
}

?>
