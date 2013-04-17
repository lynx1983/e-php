<?php

//! This class is obsoleted! Use Types class!
class String
{
    static function isEmpty($str)
    {
	return !isset($str) || (trim($str) == '');
    }
}

?>
