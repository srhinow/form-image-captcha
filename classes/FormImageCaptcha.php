<?php
/**
 * Class FormImageCaptcha
 *
 * captcha field.
 * @copyright  sr-tag Webentwicklung 2016
 * @author     Sven Rhinow
 * @package    FormImageCaptcha
 * @license    LGPL
 */
class FormImageCaptcha extends \Widget
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'image_captcha';

	/**
	 * Captcha key
	 * @var string
	 */
	protected $strCaptchaKey;

	/**
	 * Char Count
	 * @var int
	 */
	protected $defCharCount = 5;

	/**
	 * Initialize the object
	 * @param array
	 */
	public function __construct($arrAttributes = false)
	{
		parent::__construct($arrAttributes);

		$sk = \Input::get('sk');
		$sessionName ='captcha_' . (($sk)?:$this->strId);

		if(\Input::get('k'))
		{
			$key = \Input::get('k') / $this->strId;
			$_SESSION[$sessionName]['nic_sum'] =$key;
		}
		
		if( $this->nic_length > 0 ) $this->c = $this->nic_length;
		elseif( $GLOBALS['TL_CONFIG']['nic_length'] ) $this->c = $GLOBALS['TL_CONFIG']['nic_length'];
		elseif( $_SESSION[$sessionName]['nic_length'] ) $this->c = $_SESSION[$sessionName]['nic_length'];
		else $this->c = $this->defCharCount;

		$this->arrAttributes['maxlength'] =  $this->c;
		$this->strCaptchaKey = 'c' . md5(uniqid('', true));
		$this->mandatory = true;
		
		// AJAX request
		if ($_POST && \Environment::get('isAjaxRequest'))
		{
			ob_end_clean();
			$this->generateAjax();
		}

		$_SESSION['AJAX-FFL'][$this->strId] = array('type'=>'imagecaptcha');
	}


	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'mandatory':
				$this->arrConfiguration['mandatory'] = $varValue ? true : false;
			break;
			default:
				parent::__set($strKey, $varValue);
			break;
		}
	}

	/**
	 * Validate input and set value
	 */
	public function validate()
	{
		$sessionName ='captcha_' . $this->strId;
		$arrCaptcha = $_SESSION[$sessionName];

		$length = ($this->nic_length) ? $this->nic_length : $GLOBALS['TL_CONFIG']['nic_length'];

		if (!is_array($arrCaptcha) || !strlen($arrCaptcha['key']) || !strlen($arrCaptcha['nic_sum']) || \Input::post($arrCaptcha['key']) != $arrCaptcha['nic_sum'])
		{
			$this->class = 'error';
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['imagecaptcha'],$length));
		}

		$_SESSION['captcha_' . $this->strId] = '';
	}


	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		return sprintf('<input type="text" name="%s" id="ctrl_%s" class="captcha%s" value=""%s />',
						$this->strCaptchaKey,
						$this->strId,
						(strlen($this->strClass) ? ' ' . $this->strClass : ''),
						$this->getAttributes()) . $this->addSubmit();

	}

	/**
	 * Generate the captcha question and return it as string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function generateCaptcha($src='', $alt='', $attributes='')
	{
		global $objPage;
		$int1 = '';

		for( $i = 0 ; $i < $this->c ; $i++ )
		{
			$int1 .= mt_rand(1, 9);
		}

		$_SESSION['captcha_' . $this->strId] = array
			(
				'nic_sum' => $int1,
				'key' => $this->strCaptchaKey,
				'anz' => $this->c,
				'nic_width' => ($this->nic_width) ? : $GLOBALS['TL_CONFIG']['nic_width'],
				'nic_height' => ($this->nic_height) ? : $GLOBALS['TL_CONFIG']['nic_height'],
				'nic_fontcolor' => ($this->nic_fontcolor) ? : $GLOBALS['TL_CONFIG']['nic_fontcolor'],
				'nic_linecolor' => ($this->nic_linecolor) ? : $GLOBALS['TL_CONFIG']['nic_linecolor'],
				'nic_bgcolor' => ($this->nic_bgcolor) ? : $GLOBALS['TL_CONFIG']['nic_bgcolor'],
				'nic_length' => ($this->nic_length) ? : $GLOBALS['TL_CONFIG']['nic_length'],
				'nic_fontsize' => ($this->nic_fontsize) ? : $GLOBALS['TL_CONFIG']['nic_fontsize'],
				'nic_charset' => ($this->nic_charset) ? : $GLOBALS['TL_CONFIG']['nic_charset'],
				'nic_charspace' => ($this->nic_charspace) ? : $GLOBALS['TL_CONFIG']['nic_charspace'],
				'nic_angle' => ($this->nic_angle) ? : $GLOBALS['TL_CONFIG']['nic_angle'],
				'nic_padding' => ($this->nic_padding) ? : $GLOBALS['TL_CONFIG']['nic_padding'],
				'nic_font' => ($this->nic_font) ? : $GLOBALS['TL_CONFIG']['nic_font']
			);

		// $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/FormImageCaptcha/html/js/ajax.js';

		$GLOBALS['TL_CSS'][] = 'system/modules/form-image-captcha/assets/css/nic_styles.css';

		$GLOBALS['TL_MOOTOOLS'][] = "
		<script type=\"text/javascript\">

			$$('input[name=sendAjax]').each(function(el){ el.set('value','0')});

			var doAjax = function(e){
			  e.stop(); // prevent the form from submitting

			 var form = this.getParent('form');
			 var method = form.get('method'),
			 	action = form.get('action'),
			 	data = form.toQueryString();

			  new Request({
			    url: action,
			    method: method,
			    data: data,
			    onRequest: function(){
			      $('captcha_img').fade('out');
			    },
			    onSuccess: function(r){
			      // the 'r' is response from server
			        $('captcha_img').set('src', r);
			        $('captcha_img').fade('in');
			        $$('input[name=sendAjax]').each(function(el){ el.set('value','1')});
			    }
			  }).send();
			}

			addEvent('domready', function(){
			  $('refresh_captcha').addEvent('click', doAjax);
			});

			</script>";

		$GLOBALS['TL_JQUERY'][] = "
		<script type=\"text/javascript\">

			jQuery(document).ready(function( $ ) {

				$('#refresh_captcha').on('click', function(event){

       				event.preventDefault();

        			// Einfach so mal spaßeshalber und fürs Debugging
        			
					var form = $(this).parents('form');
					var action = form.attr('action'),
						method = form.attr('method'),
						data = form.serialize();

        			$.ajax({
						url: action,
				    	method: method,
				    	data: data,
					}).done(function (data) {
        				// Bei Erfolg
        				// alert('Erfolgreich:' + data);
        				form.find('#captcha_img').attr('src',data);
    				});
				});

			});
			</script>";

		$this->loadLanguageFile('tl_form_field');
		
		return sprintf('<img src="system/modules/form-image-captcha/assets/image.php?sk=%s" alt="SecureImage" border="0"  id="captcha_img"/>
		<a href="{{link_url::%s}}" id="refresh_captcha" title="'.$GLOBALS['TL_LANG']['tl_form_field']['nic_reload_button_text'][1].'">'.$GLOBALS['TL_LANG']['tl_form_field']['nic_reload_button_text'][0].'</a>
		<input type="hidden" name="sendAjax" value="0"/>', $this->strId, $objPage->id );
	}

	public function generateAjax()
	{
		$this->import('Session');

		$sk = $this->strId;
		$sessionName ='captcha_' . $sk;
		$captchaSession = $_SESSION[$sessionName];

		//new Code
		if($captchaSession['nic_length']) $this->c = $captchaSession['nic_length'];
		else $this->c = $GLOBALS['TL_CONFIG']['nic_length'];

		for($i=0 ; $i < $this->c ; $i++)
		{
		    $int1 .= mt_rand(1, 9);
		}

		$_SESSION[$sessionName]['nic_sum'] = $int1;

		print "system/modules/form-image-captcha/assets/image.php?sk=".$sk."&amp;k=".$_SESSION[$sessionName]['nic_sum']*$sk;
		exit();
	}

}
