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
* @copyright  Felix Pfeiffer : Neue Medien 2009  & Nik Andreichikov
 * @author     Felix Pfeiffer   info@felixpfeiffer.com & Nik Andreichikov annd.design@googlemail.com
 * @package    PictureCaptcha 
 * @license    LGPL 
 * 
 */
$GLOBALS['TL_LANG']['tl_settings']['fic_width'] = array('Breite vom Captcha','Geben Sie an, wie breit das Captchabild seien soll. Vorbelegung ist 91.');
$GLOBALS['TL_LANG']['tl_settings']['fic_height'] = array('Höhe vom Captcha','Geben Sie an, hoch das Captcha seien soll. Vorbelegung ist 31.');
 
$GLOBALS['TL_LANG']['tl_settings']['fic_length'] = array('Zeichenanzahl','Geben Sie an, aus wievielen Zeichen das Captcha bestehen soll. Vorbelegung ist 4. Ist als Zeichensatz Rechenaufgabe gesetzt, wird diese Angabe ignoriert.');
$GLOBALS['TL_LANG']['tl_settings']['fic_charset'] = array('Zeichensatz','Wählen Sie, welche Art von Zeichen (Ziffern, Buchstaben und einige Sonderzeichen) im Captcha enthalten sein sollen.');
$GLOBALS['TL_LANG']['tl_settings']['fic_fontsize'] = array('Schriftgröße','Geben Sie die Schriftgröße an, Standart ist 20');
$GLOBALS['TL_LANG']['tl_settings']['fic_charspace'] = array('Zeichenabstand','Wählen Sie, welchen Abstand die Zeichen zueinander haben sollen. Standart ist 18');

$GLOBALS['TL_LANG']['tl_settings']['fic_angle'] = array('Radius','Wenn die Zeichen verdreht dargestellt werden sollen, wählen sie hier den Radius. 0 = wenn keine Drehung gewünscht ist');
$GLOBALS['TL_LANG']['tl_settings']['fic_padding'] = array('Randabstand','Wählen Sie, wieviel Abstand zum linken oberen und unteren Rand der Schrift zum Bildrand bleiben soll. Der rechte Rand ergibt sich aus der Schriftgröße,Schriftabstand und Anzahl der Zeichen.');

$GLOBALS['TL_LANG']['tl_settings']['fic_fontcolor'] = array('Schriftfarbe','Geben Sie die Farbe der Schrift an, Standart ist ffffff');
$GLOBALS['TL_LANG']['tl_settings']['fic_linecolor'] = array('Linienfarbe','Geben Sie die Farbe der Linien an, Standart ist eeeeee');
$GLOBALS['TL_LANG']['tl_settings']['fic_bgcolor'] = array('Hintergrundfarbe','Geben Sie die Hintergrundfarbe als Hexadezimalcode an, Standart ist 000000');
$GLOBALS['TL_LANG']['tl_settings']['fic_bgimage'] = array('Hintergrundbild');
$GLOBALS['TL_LANG']['tl_settings']['fic_font'] = array('Schriftart');
$GLOBALS['TL_LANG']['tl_settings']['fic_defaultcaptcha'] = array('Standart Captcha','Wählen Sie ob die Bildcaptcha die Textcaptcha ersetzen soll, Standart - ist aus'); 
 
$GLOBALS['TL_LANG']['tl_settings']['imagecaptcha_legend'] = 'FormImageCaptcha Einstellungen';
?>
