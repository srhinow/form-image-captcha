<?php

/**
 * PHP version 5
 * @copyright  sr-tag Webentwicklung 2016
 * @author     Sven Rhinow 
 * @package    NumberImageCaptcha
 * @license    LGPL 
 * @filesource
 */


/**
 * -------------------------------------------------------------------------
 * BACK END FORM FIELDS
 * -------------------------------------------------------------------------
 * Use function array_insert() to modify an existing FFL array.
 */
 array_insert($GLOBALS['TL_FFL'], 12, array
(
    'imagecaptcha' => 'NumberImageCaptcha')
);
