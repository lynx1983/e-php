<?php

//! Datatype-related helper functions class
class Types
{
    //! Inspects value to be an integer
    /*!
	\param $value value to inspect
	\return TRUE if the value is an integer or FALSE otherwise
    */
    static public final function isInteger($value)
    {
	return (preg_match('/^[+-]?\d+$/', trim($value)) == 1);
    }
    //! Inspects value to be a positive integer
    /*!
	\param $value value to inspect
	\return TRUE if the value is a positive integer or FALSE otherwise
    */
    static public final function isPositiveInteger($value)
    {
	return self::isInteger($value) && ($value > 0);
    }
    //! Inspects value to be a non-negative integer
    /*!
	\param $value value to inspect
	\return TRUE if the value is a non-negative integer or FALSE otherwise
    */
    static public final function isNonNegativeInteger($value)
    {
	return self::isInteger($value) && ($value >= 0);
    }
    //! Inspects value to be an empty string
    /*!
	\param $value value to inspect
	\return TRUE if the value is empty string or FALSE otherwise
    */
    static public final function isEmptyString($value)
    {
	return !isset($value) || (trim($value) == '');
    }
    //! Inspects value to be a string containing valid W3C date
    /*!
	\param $value value to inspect in W3C format (example: 2005-08-15)
	\return TRUE if the value is a string containing valid date or FALSE otherwise

	NOTE! This method does not work correct at the moment! It should be amended in future!
    */
    static public final function isDate($value)
    {
	if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', trim($value), $matches) != 1) {
	    return FALSE;
	}
    	return checkdate($matches[2], $matches[3], $matches[1]);
    }
}

?>
