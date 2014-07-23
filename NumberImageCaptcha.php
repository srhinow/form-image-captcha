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
 * captcha field.
 * @copyright  sr-tag Webentwicklung 2011 
 * @author     Sven Rhinow 
 * @package    NumberImageCaptcha 
 * @license    LGPL 
 */
class NumberImageCaptcha extends Widget
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
	* Default/Fallback chars
	* @var integer
	*/
	protected $defCharCount = 5;
	
	/**
	* defined count
	* @var integer
	*/
	protected $c = 0;	
	
	/**
	 * Initialize the object
	 * @param array
	 */
	public function __construct($arrAttributes = false)
	{
		parent::__construct($arrAttributes);
                
		$this->import('Session');
		
		$sk = $this->Input->get('sk');
		$this->sessionName ='captcha_' . $sk;                
                
		if($this->Input->get('k')) 
		{		
		     $key = $this->Input->get('k') / $this->strId;
		     $this->Session->set($this->sessionName['sum'],$key);    
		}                
		$sessionDataArr = $this->Session->get($sessionName);
		
		if($this->fic_length > 0) $this->c = $this->fic_length;
		elseif($GLOBALS['TL_CONFIG']['fic_length']) $this->c = $GLOBALS['TL_CONFIG']['fic_length'];
		elseif($sessionDataArr['fic_length']) $this->c = $sessionDataArr['fic_length'];
		else $this->c = $this->defCharCount; //fallback			

		$this->arrAttributes['maxlength'] =  $this->c;
		$this->strCaptchaKey = 'c' . md5(uniqid('', true));
		$this->mandatory = true;
                
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
		$this->sessionName ='captcha_' . $this->strId;
		$arrCaptcha = $this->Session->get($this->sessionName); 

		//Phänomän mit Sessionsetzung mit und ohne Ajax ausgleichen
		$sum =  ($this->Input->post('sendAjax')) ? $this->Input->post('k') / $arrCaptcha['sk'] : $arrCaptcha['sum']; 

		$length = ($this->fic_length) ? $this->fic_length : $GLOBALS['TL_CONFIG']['fic_length'];
                
		if (!is_array($arrCaptcha) || !strlen($arrCaptcha['key']) || !strlen($sum) || $this->Input->post($arrCaptcha['key']) != $sum)
		{
			$this->class = 'error '.$this->Input->post('k');
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['imagecaptcha'],$length));
		}

		$this->Session->set($this->sessionName, '');
                
                
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
	public function generateCaptcha($src='', $alt='', $attributes='')
	{
		$int1 = '';
        global $objPage;
                    
		for($i=0 ; $i<$this->c ; $i++)
		{
			$int1 .= mt_rand(1, 9);
        }
		
		$k = $int1 * $this->strId;

		$this->Session->set('captcha_' . $this->strId, array
		(
			'sk' => $this->strId,
			'sum' => $int1,
			'key' => $this->strCaptchaKey,
			'anz' => $this->c,
            'fic_width' => ($this->fic_width) ? $this->fic_width : $GLOBALS['TL_CONFIG']['fic_width'],
            'fic_height' => ($this->fic_height) ? $this->fic_height : $GLOBALS['TL_CONFIG']['fic_height'],
            'fic_fontcolor' => ($this->fic_linecolor) ? $this->fic_fontcolor : $GLOBALS['TL_CONFIG']['fic_fontcolor'],
            'fic_linecolor' => ($this->fic_linecolor) ? $this->fic_linecolor : $GLOBALS['TL_CONFIG']['fic_linecolor'],
            'fic_bgcolor' => ($this->fic_bgcolor) ? $this->fic_bgcolor : $GLOBALS['TL_CONFIG']['fic_bgcolor'],
            'fic_length' => ($this->fic_length) ? $this->fic_length : $GLOBALS['TL_CONFIG']['fic_length'],
            'fic_fontsize' => ($this->fic_fontsize) ? $this->fic_fontsize : $GLOBALS['TL_CONFIG']['fic_fontsize'],
            'fic_charset' => ($this->fic_charset) ? $this->fic_charset : $GLOBALS['TL_CONFIG']['fic_charset'],
            'fic_charspace' => ($this->fic_charspace) ? $this->fic_charspace : $GLOBALS['TL_CONFIG']['fic_charspace'],
            'fic_angle' => ($this->fic_angle) ? $this->fic_angle : $GLOBALS['TL_CONFIG']['fic_angle'],
            'fic_padding' => ($this->fic_padding) ? $this->fic_padding : $GLOBALS['TL_CONFIG']['fic_padding'],
            'fic_font' => ($this->fic_font) ? $this->fic_font : $GLOBALS['TL_CONFIG']['fic_font']

                        
		));
		$GLOBALS['TL_CSS'][] = 'system/modules/NumberImageCaptcha/html/css/nic_styles.css';

		$GLOBALS['TL_MOOTOOLS'][] = "
		        <script type=\"text/javascript\">
		        <!--//--><![CDATA[//><!--
		        
		        $$('input[name=sendAjax]').each(function(el){ el.set('value','0')});
		        
		        var doAjax = function(e){
		          e.stop(); // prevent the form from submitting

		          new Request({
		            url: 'ajax.php?action=ffl&id=".$this->strId."&sk=".$this->strId."',
		            method: 'get',
		            data: this,
		            onRequest: function(){
		              $('captcha_img').fade('out');
		            },
		            onSuccess: function(r){
		            	var rObj = JSON.decode(r);
		            	// console.log(rObj);
		             // $('number_box').setStyle('display','block');
		                $('captcha_img').set('src', rObj.content.img);
		                $$('input[name=k]')[0].set('value',rObj.content.k);
		                $('captcha_img').fade('in');
		                $$('input[name=sendAjax]').each(function(el){ el.set('value','1')});
		            }
		          }).send();
		        }

		        addEvent('domready', function(){
		          $('refresh_captcha').addEvent('click', doAjax);
		        });
		        //--><!]]>
		        </script>
		        ";

		$this->loadLanguageFile('tl_form_field');       
		return sprintf('<img src="system/modules/NumberImageCaptcha/image.php?sk=%s&k=%s" alt="SecureImage" border="0"  id="captcha_img"/>
		<a href="{{link_url::%s}}" id="refresh_captcha" title="'.$GLOBALS['TL_LANG']['tl_form_field']['fic_reload_button_text'][1].'">'.$GLOBALS['TL_LANG']['tl_form_field']['fic_reload_button_text'][0].'</a>
		<input type="hidden" name="sendAjax" value="0"/>
		<input type="hidden" name="k" value="%s">',
						$this->strId,$this->strId * $int1,$objPage->id,$k);
						
		
	}

    public function generateAjax()
	{
            $this->import('Session');

            $sk = $this->Input->get('sk');
            $int1='';

            $sessionName ='captcha_' . $sk;
            $this->captchaSession = $this->Session->get($sessionName);
         
            //new Code
			if($this->captchaSession['fic_length']) $this->c = $this->captchaSession['fic_length'];
			else $this->c = $GLOBALS['TL_CONFIG']['fic_length']; 
            	          
            for($i=0 ; $i < $this->c ; $i++)
            {
				$int1 .= mt_rand(1, 9);
            }
            $k = $int1 * $sk;
            $this->captchaSession['sum'] = $int1;
            $this->Session->set($sessionName,$this->captchaSession);
            // $_SESSION['FE_DATA'][$sessionName] = $this->captchaSession;

            $ajaxArr = array(
            		'img' => "system/modules/NumberImageCaptcha/image.php?sk=".$sk."&k=".$k,
            		'k' => $k
            	);
            
            return $ajaxArr;
        }

}
