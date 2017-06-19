<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  sr-tag Webentwicklung 2016 
 * @author     Sven Rhinow 
 * @package    NumberImageCaptcha 
 * @license    LGPL 
 * 
 */
$GLOBALS['TL_LANG']['tl_settings']['nic_width'] = array('Breite vom Captcha','Geben Sie an, wie breit das Captcha sein soll. Vorbelegung ist 91 Pixel.');
$GLOBALS['TL_LANG']['tl_settings']['nic_height'] = array('Höhe vom Captcha','Geben Sie an, wie hoch das Captcha sein soll. Vorbelegung ist 31 Pixel.');
 
$GLOBALS['TL_LANG']['tl_settings']['nic_length'] = array('Zeichenanzahl','Geben Sie an, aus wievielen Zeichen das Captcha bestehen soll. Vorbelegung ist 4. Ist als Zeichensatz Rechenaufgabe gesetzt, wird diese Angabe ignoriert.');
$GLOBALS['TL_LANG']['tl_settings']['nic_charset'] = array('Zeichensatz','Wählen Sie, welche Art von Zeichen (Ziffern, Buchstaben und einige Sonderzeichen) im Captcha enthalten sein sollen.');
$GLOBALS['TL_LANG']['tl_settings']['nic_fontsize'] = array('Schriftgröße','Geben Sie die Schriftgröße an. Standard ist 20.');
$GLOBALS['TL_LANG']['tl_settings']['nic_charspace'] = array('Zeichenabstand','Wählen Sie, welchen Abstand die Zeichen zueinander haben sollen. Standard ist 18.');

$GLOBALS['TL_LANG']['tl_settings']['nic_angle'] = array('Radius','Wenn die Zeichen verdreht dargestellt werden sollen, wählen sie hier den Radius. 0 = wenn keine Drehung gewünscht ist.');
$GLOBALS['TL_LANG']['tl_settings']['nic_padding'] = array('Randabstand','Wählen Sie, wieviel Abstand zum linken oberen und unteren Rand der Schrift zum Bildrand bleiben soll. Der rechte Rand ergibt sich aus der Schriftgröße, Schriftabstand und Anzahl der Zeichen.');

$GLOBALS['TL_LANG']['tl_settings']['nic_fontcolor'] = array('Schriftfarbe','Geben Sie die Farbe der Schrift als Hexadezimalwert an, Standard ist ffffff.');
$GLOBALS['TL_LANG']['tl_settings']['nic_linecolor'] = array('Linienfarbe','Geben Sie die Farbe der Linien als Hexadezimalwert an, Standard ist eeeeee.');
$GLOBALS['TL_LANG']['tl_settings']['nic_bgcolor'] = array('Hintergrundfarbe','Geben Sie die Hintergrundfarbe als Hexadezimalcode an, Standart ist 000000');
$GLOBALS['TL_LANG']['tl_settings']['nic_font'] = array('Schriftart');
 
$GLOBALS['TL_LANG']['tl_settings']['imagecaptcha_legend'] = 'NumberImageCaptcha Einstellungen';
