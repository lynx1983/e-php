<?php

//! Filename utilities
class FileName
{
    //! Changes file extenstion
    public static function changeExtension($fileName, $newExtension)
    {
	$pos = strlen($fileName) - 1;
	while ($pos >= 0) {
	    if ($fileName{$pos} == '/') {
		break;
	    }
	    if ($fileName{$pos} == '.') {
		return substr_replace($fileName, $newExtension, $pos + 1);
	    }
	    $pos--;
	}
	return $fileName . '.' . $newExtension;
    }
    //! Adds trailing slash to the path if needed
    public static function addTrailingSlash($fileName)
    {
	return ($fileName{strlen($fileName) - 1} == '/') ? $fileName : $fileName . '/';
    }

}

?>
