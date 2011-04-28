<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * @copyright  Leo Feyer 2005-2009
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Frontend
 * @license    LGPL
 * @filesource
 */


/**
 * Class FormCaptcha
 *
 * File upload field.
 * @copyright  Leo Feyer 2005-2009
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Controller
 */
class FormImageCaptcha extends Widget
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
	
	protected $defCharCount = 5;
	
	/**
	 * Initialize the object
	 * @param array
	 */
	public function __construct($arrAttributes=false)
	{
		parent::__construct($arrAttributes);
                
                $this->c = ($GLOBALS['TL_CONFIG']['fic_length']) ? $GLOBALS['TL_CONFIG']['fic_length'] : $this->defCharCount;			

		$this->arrAttributes['maxlength'] =  $this->c;
		$this->strCaptchaKey = 'c' . md5(uniqid('', true));
		$this->mandatory = true;
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
		$arrCaptcha = $this->Session->get('captcha_' . $this->strId);

		if (!is_array($arrCaptcha) || !strlen($arrCaptcha['key']) || !strlen($arrCaptcha['sum']) || $this->Input->post($arrCaptcha['key']) != $arrCaptcha['sum'] || $arrCaptcha['time'] > (time() - 3))
		{
			$this->class = 'error';
			$this->addError($GLOBALS['TL_LANG']['ERR']['imagecaptcha']);
		}

		$this->Session->set('captcha_' . $this->strId, '');
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
	 * @return string
	 */
	public function generateImage()
	{
		$int1 = '';
		
		for($i=0 ; $i<$this->c ; $i++)
		{
		    $int1 .= mt_rand(1, 9);
                }
		
		$this->Session->set('captcha_' . $this->strId, array
		(
			'sum' => $int1,
			'key' => $this->strCaptchaKey
		));


		return sprintf('<img src="system/modules/FormImageCaptcha/image.php?sk=%s" alt="SecureImage" border="0" />',
						$this->strId);
	}

}

?>
