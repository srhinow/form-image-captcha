<?php

/**
 * TYPOlight webCMS
 * Copyright (C) 2005-2009 Leo Feyer
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
 * @filesource
 */


/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require('../../initialize.php');


/**
 * Class createCapture
 *
 * Create a Capture image and return it to the browser
 * @copyright  Felix Pfeiffer : Neue Medien 2009
 * @author     Felix Pfeiffer   info@felixpfeiffer.com
 * @package    Controller
 */
class createCapture extends Frontend
{

	/**
	* Setzen einiger globaler Variablen für diese Klasse
	*/
	protected $defImg_width   = 91;        # Breite des Bildes in Pixel
	protected $defImg_height  = 31;         # Hoehe des Bildes in Pixel

	protected $defFontPath = './html/';
	protected $defFont   =  "bradlay.ttf";
	protected $defIntFontsize = 20;
	protected $defIntAngleMax = 10;
	protected $defHexBgColor = '000000';
	protected $defHexLineColor = '666666';
	protected $defHexFontColor = 'ffffff';
	protected $defCharCount = 5;
	protected $defFontSize = 20;
	protected $defCharSpace = 18;
	protected $defImgPadding = 5;
	protected $defAngle = 0;

	/**
	 * Initialize object (do not remove)
	 */
	public function __construct()
	{
		// Einbinden des Konstruktors der Elternklasse (parent)
		// Dadurch werden einige wichtige Funktionen von TL dieser Klasse verfügbar gemacht
		parent::__construct();

        $this->import('Session');

		$sk=$_GET['sk'];
        $sessionName = $this->Session->get("captcha_".$sk);
		$this->zahl = $sessionName['sum'];
// print_r($sessionName);
// exit();
		$k = $this->Input->get('k');
		if($k) $this->zahl =  (string) ($k / $sk);

		$this->c = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_length']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_length'] : $this->defCharCount;

		//Ermitteln der Abmaße
		$this->imgWidth  = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_width']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_width'] : $this->defImg_width;
		$this->imgHeight = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_height']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_height'] : $this->defImg_height;


		// Ermitteln der Farbwerte für Hintergrund, Linien und Schrift
		#### Hintergrundfarben######
		$this->hexBgColor   = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_bgcolor']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_bgcolor'] : $this->defHexBgColor;
		$this->rgbBgColor = $this-> hex2rgb($this->hexBgColor);

		#### Schriftfarben ######
		$this->hexFontColor = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_fontcolor']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_fontcolor'] : $this->defHexFontColor;
		$this->rgbFontColor = $this-> hex2rgb($this->hexFontColor);

		#### Linienfarben ######
		$this->hexLineColor = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_linecolor']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_linecolor'] : $this->defHexLineColor;
		$this->rgbLineColor = $this-> hex2rgb($this->hexLineColor);

		#### Font ####
		if($_SESSION['FE_DATA']["captcha_".$sk]['fic_font'] && file_exists($this->defFontPath . $_SESSION['FE_DATA']["captcha_".$sk]['fic_font']))
		{

		    $this->Font = $this->defFontPath .$_SESSION['FE_DATA']["captcha_".$sk]['fic_font'];

		}else{

		    $this->Font = $this->defFontPath .$this->defFont;
		}

		$this->fontSize = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_fontsize']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_fontsize'] : $this->defFontSize;
		$this->charspace = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_charspace']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_charspace'] : $this->defCharSpace;
		$this->padding = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_padding']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_padding'] : $this->defImgPadding;
		$this->angle = ($_SESSION['FE_DATA']["captcha_".$sk]['fic_angle']) ? $_SESSION['FE_DATA']["captcha_".$sk]['fic_angle'] : $this->defAngle;


	}

	/**
	* Generate Image
	*/
	public function generateCaptcha()
	{
		header("Content-Type: image/png");
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");          // Datum in der Vergangenheit
		header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); // immer modifiziert
		header ("Cache-Control: no-cache, must-revalidate");        // HTTP/1.1
		header ("Pragma: no-cache");

		/* das Bild und seine Eigenschaften */
		$im        = imagecreate($this->imgWidth, $this->imgHeight); # das bild erstellen
		$bgcolor   = imagecolorallocate($im, $this->rgbBgColor['r'], $this->rgbBgColor['g'], $this->rgbBgColor['b']); # Backgroundcolor setzen
		$linecolor = imagecolorallocate($im, $this->rgbLineColor['r'], $this->rgbLineColor['g'], $this->rgbLineColor['b']); # Schriftfarbe setzen
		$fontcolor = imagecolorallocate($im, $this->rgbFontColor['r'], $this->rgbFontColor['g'], $this->rgbFontColor['b']); //Schriftfarbe setzen
		imagefilledrectangle($im, 0, 0, 49, 19, $bgcolor);

		/* die Linien auf das Bild "zeichnen" */
		for($x=0; $x <= 102; $x+=5)
		    imageline($im, $x, 0, $x, 40, $linecolor);
		for($y=0; $y <=52; $y+=5)
		    imageline($im, 0, $y, 102, $y, $linecolor);

		/* den Zahlencode auf das Bild "schreiben" */
		$w = $this->padding;
	        $half = $this->imgHeight / 2;
	        $minp = ($this->padding < $half)? $this->fontSize : $this->padding+$this->fontSize;
	        $maxp = ($this->padding > $half)? $half : $this->padding+$this->fontSize;
	        
		for($i=0 ; $i < $this->c ; $i++){
		    imagettftext($im, $this->fontSize, mt_rand(-$this->angle,$this->angle), $w, mt_rand($minp,$maxp), $fontcolor, $this->Font, $this->zahl[$i]);
		    $w += $this->charspace;
		}

		imagepng($im);
		imagedestroy($im);

		session_start();
		$sk=$_GET['sk'];


	}

	protected function generateCaptchacode()
	{
		// Der Code wird zurückgegeben
		return $captchacode;
	}

	/**
	 * Return a RGB-Array
	 * @param hexadecimal-String
	 * @return array
	*/
	public function hex2rgb($c)
	{
		if(!$c) return false;
		
		$c = trim($c);
		$out = false;

		if(preg_match("/^[0-9ABCDEFabcdef\#]+$/i", $c))
		{
			$c = str_replace('#','', $c);
			$l = strlen($c) == 3 ? 1 : (strlen($c) == 6 ? 2 : false);

			if($l)
			{
				unset($out);
				$out[0] = $out['r'] = $out['red'] = hexdec(substr($c, 0,1*$l));
				$out[1] = $out['g'] = $out['green'] = hexdec(substr($c, 1*$l,1*$l));
				$out[2] = $out['b'] = $out['blue'] = hexdec(substr($c, 2*$l,1*$l));
			}else $out = false;

		}else $out = false;

		return $out;
	}
	/**
	 * Return a Hex-String
	 * @param RGB-String
	 * @return string
	*/
	public function rgb2hex($c)
	{
		if(!$c) return false;
		$c = trim($c);
		$out = false;

		if (preg_match("/^[0-9]+(,| |.)+[0-9]+(,| |.)+[0-9]+$/i", $c))
		{
			$spr = str_replace(array(',',' ','.'), ':', $c);
			$e = explode(":", $spr);
			if(count($e) != 3) return false;
			$out = '#';
			for($i = 0; $i<3; $i++)
			$e[$i] = dechex(($e[$i] <= 0)?0:(($e[$i] >= 255)?255:$e[$i]));

			for($i = 0; $i<3; $i++)
			$out .= ((strlen($e[$i]) < 2)?'0':'').$e[$i];

			$out = strtoupper($out);
		}else $out = false;

		return $out;
	}
}

/**
 * Instantiate controller
 */
$objCaptcha = new createCapture();
$objCaptcha->generateCaptcha();
