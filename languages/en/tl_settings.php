<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  sr-tag Webentwicklung 2011 
 * @author     Sven Rhinow 
 * @package    NumberImageCaptcha 
 * @license    LGPL 
 * 
 */
$GLOBALS['TL_LANG']['tl_settings']['fic_width'] = array('Captcha width','Specify the width of the captcha. Default is 91 pixels.');
$GLOBALS['TL_LANG']['tl_settings']['fic_height'] = array('Captcha height','Specify the height of the captcha. Default is 31 pixels.');
 
$GLOBALS['TL_LANG']['tl_settings']['fic_length'] = array('Number of characters','Specify how many characters the captcha will consist of. Default is 4. If the character set is set to computing task, this value will be ignored.');
$GLOBALS['TL_LANG']['tl_settings']['fic_charset'] = array('Character set','Select the type of characters (digits, letters and special characters) that will be included in the captcha.');
$GLOBALS['TL_LANG']['tl_settings']['fic_fontsize'] = array('Font size','Enter the font size. Default is 20.');
$GLOBALS['TL_LANG']['tl_settings']['fic_charspace'] = array('Character spacing','Select the spacing between the characters. Default is 18.');

$GLOBALS['TL_LANG']['tl_settings']['fic_angle'] = array('Radius','If the characters are to be tilted, select the radius here. 0 = no tilt.');
$GLOBALS['TL_LANG']['tl_settings']['fic_padding'] = array('Edge distance','Choose the required distance from the upper-left and the bottom of the font to the edge of the image. The right margin is derived from the font size, spacing and number of characters.');

$GLOBALS['TL_LANG']['tl_settings']['fic_fontcolor'] = array('Font color','Enter the font color as a hexadecimal value, default is ffffff.');
$GLOBALS['TL_LANG']['tl_settings']['fic_linecolor'] = array('Line color','Enter the color of the lines, default is eeeeee.');
$GLOBALS['TL_LANG']['tl_settings']['fic_bgcolor'] = array('Background color','Enter the background color as a hexadecimal code, default is 000000.');
$GLOBALS['TL_LANG']['tl_settings']['fic_font'] = array('Font');
 
$GLOBALS['TL_LANG']['tl_settings']['imagecaptcha_legend'] = 'NumberImageCaptcha settings';
?>
