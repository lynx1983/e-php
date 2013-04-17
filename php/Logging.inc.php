<?php

//! Logging facility class
/*!
    TODO Use write lock while friting to log-file.
    TODO Open log-file only once - at the first log operation.
*/
class Logging
{
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTIFY = 'notify';

    public static function log($level, $str)
    {
	$fileName = Configuration::logFilename($level);
	$lines = explode('\n', $str);
	if (!$handle = fopen($fileName, 'a+')) {
	    throw new Exception('File "' . $fileName . '" has not been opened!');
	}
	fwrite($handle, date('Y-m-d H:i:s') . ': ' . $lines[0] . "\n");
	for ($i = 1; $i < count($lines); $i++) {
	    fwrite($handle, date('Y-m-d H:i:s') . '> ' . $lines[$i] . "\n");
	}
	fclose($handle);
    }
}

?>
