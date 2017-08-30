<?php

/**
 * PHP version 5
 * @copyright  sr-tag Webentwicklung 2011 
 * @author     Sven Rhinow 
 * @package    FormImageCaptcha
 * @license    LGPL 
 * @filesource
 */


/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require('../../../initialize.php');


/**
 * Class createCapture
 *
 * Create a Capture image and return it to the browser
 * @copyright  Felix Pfeiffer : Neue Medien 2009
 * @author     Felix Pfeiffer   info@felixpfeiffer.com
 * @package    Controller
 */
class createCapture extends \Frontend
{

	/**
	* Setzen einiger globaler Variablen für diese Klasse
	*/
	protected $defImg_width   = 91;        # Breite des Bildes in Pixel
	protected $defImg_height  = 31;         # Hoehe des Bildes in Pixel
	protected $defFontPath = './fonts/';
	protected $defFont   =  "bradlay.ttf";
	protected $defIntFontsize = 20;
	protected $defIntAngleMax = 10;
	protected $defHexBgColor = '000000';
	protected $defHexLineColor = '666666';
	protected $defHexFontColor = 'ffffff';
	protected $defCharCount = 5;
	protected $defFontSize = 15;
	protected $defCharSpace = 10;
	protected $defImgPadding = 3;
	protected $defAngle = 0;
	protected $session;
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
		$sessionName = "captcha_".$sk;
		$this->session = $_SESSION[$sessionName];

		$this->zahl = $this->session['nic_sum'];

		$k = $this->Input->get('k');
		if($k) $this->zahl =  (string) ($k / $sk);

		$this->c = ($this->session['nic_length']) ? : $this->defCharCount;

		//Ermitteln der Abmaße
		$this->imgWidth  = ($this->session['nic_width']) ? : $this->defImg_width;
		$this->imgHeight = ($this->session['nic_height']) ? : $this->defImg_height;


		// Ermitteln der Farbwerte für Hintergrund, Linien und Schrift
		#### Hintergrundfarben######
		$this->hexBgColor   = ($this->session['nic_bgcolor']) ? : $this->defHexBgColor;
		$this->rgbBgColor = $this->hex2rgb($this->hexBgColor);

		#### Schriftfarben ######
		$this->hexFontColor = ($this->session['nic_fontcolor']) ? : $this->defHexFontColor;
		$this->rgbFontColor = $this->hex2rgb($this->hexFontColor);

		#### Linienfarben ######
		$this->hexLineColor = ($this->session['nic_linecolor']) ? : $this->defHexLineColor;
		$this->rgbLineColor = $this->hex2rgb($this->hexLineColor);

		#### Font ####
		if($this->session['nic_font'] && file_exists($this->defFontPath . $this->session['nic_font']))
		{
		    $this->Font = $this->defFontPath .$this->session['nic_font'];
		}
		else
		{
		    $this->Font = $this->defFontPath .$this->defFont;
		}

		$this->fontSize = ($this->session['nic_fontsize']) ? : $this->defFontSize;
		$this->charspace = ($this->session['nic_charspace']) ? : $this->defCharSpace;
		$this->padding = ($this->session['nic_padding']) ? : $this->defImgPadding;
		$this->angle = ($this->session['nic_angle']) ? : $this->defAngle;
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
		$wl = 20;
		$hl = 6;
		$sw = (int) ($this->imgWidth - $wl)  / ($wl - 1); // space-width
		$sh = ($this->imgHeight - $hl)  / ($hl - 1); // space-height


		for($x=0; $x <= $this->imgWidth; $x+=$sw)
		    imageline($im, $x, 0, $x, $this->imgHeight, $linecolor);
		for($y=0; $y <= $this->imgHeight; $y+=$sh)
		    imageline($im, 0, $y, $this->imgWidth, $y, $linecolor);

		/* den Zahlencode auf das Bild "schreiben" */
		$w = $this->padding;
		$fz2p = $this->fontSize + (2 * $this->padding);
		$half = $this->imgHeight / 2;

		if($fz2p < $this->imgHeight)
		{
			$minp = ($this->imgHeight + $this->padding) - $this->fontSize;
			$maxp = $this->imgHeight - $this->padding;
		} else {
			$this->fontSize = $this->imgHeight - (2 * $this->padding);
			$minp = $this->padding;
			$maxp = $this->padding;
		}
		// print_r($innerWidth);
	    // print $minp.' ' .$maxp;
	    // exit();
		for($i=0 ; $i < $this->c ; $i++)
		{
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
			}
			else
			{
				$out = false;
			}

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
	   }
	   else $out = false;

	   return $out;
	}
}

/**
 * Instantiate controller
 */
$objCaptcha = new createCapture();
$objCaptcha->generateCaptcha();
