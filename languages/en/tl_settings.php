<?php

/**
 * PHP version 5
 * @copyright  sr-tag Webentwicklung 2016
 * @author     Sven Rhinow
 * @package    FormImageCaptcha
 * @license    LGPL
 *
 */
$GLOBALS['TL_LANG']['tl_settings']['nic_width'] = array('Captcha width','Specify the width of the captcha. Default is 91 pixels.');
$GLOBALS['TL_LANG']['tl_settings']['nic_height'] = array('Captcha height','Specify the height of the captcha. Default is 31 pixels.');

$GLOBALS['TL_LANG']['tl_settings']['nic_length'] = array('Number of characters','Specify how many characters the captcha will consist of. Default is 4. If the character set is set to computing task, this value will be ignored.');
$GLOBALS['TL_LANG']['tl_settings']['nic_charset'] = array('Character set','Select the type of characters (digits, letters and special characters) that will be included in the captcha.');
$GLOBALS['TL_LANG']['tl_settings']['nic_fontsize'] = array('Font size','Enter the font size. Default is 20.');
$GLOBALS['TL_LANG']['tl_settings']['nic_charspace'] = array('Character spacing','Select the spacing between the characters. Default is 18.');

$GLOBALS['TL_LANG']['tl_settings']['nic_angle'] = array('Radius','If the characters are to be tilted, select the radius here. 0 = no tilt.');
$GLOBALS['TL_LANG']['tl_settings']['nic_padding'] = array('Edge distance','Choose the required distance from the upper-left and the bottom of the font to the edge of the image. The right margin is derived from the font size, spacing and number of characters.');

$GLOBALS['TL_LANG']['tl_settings']['nic_fontcolor'] = array('Font color','Enter the font color as a hexadecimal value, default is ffffff.');
$GLOBALS['TL_LANG']['tl_settings']['nic_linecolor'] = array('Line color','Enter the color of the lines, default is eeeeee.');
$GLOBALS['TL_LANG']['tl_settings']['nic_bgcolor'] = array('Background color','Enter the background color as a hexadecimal code, default is 000000.');
$GLOBALS['TL_LANG']['tl_settings']['nic_font'] = array('Font');

$GLOBALS['TL_LANG']['tl_settings']['imagecaptcha_legend'] = 'FormImageCaptcha settings';
