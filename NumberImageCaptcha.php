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
	
	protected $defCharCount = 5;
	
	/**
	 * Initialize the object
	 * @param array
	 */
	public function __construct($arrAttributes=false)
	{
		parent::__construct($arrAttributes);
                
                $this->import('Session');
		
		$sk = $this->Input->get('sk');
		$sessionName ='captcha_' . $sk;                
                
		if($this->Input->get('k')) {
		
		     $key = $this->Input->get('k')/$this->strId;
		     $this->Session->set($sessionName['sum'],$key);
		     
		}                
                if($this->fic_length >0) $this->c = $this->fic_length;
                elseif($GLOBALS['TL_CONFIG']['fic_length']) $this->c = $GLOBALS['TL_CONFIG']['fic_length'];
                elseif($this->Session->get($sessionName['fic_length'])) $this->c = $this->Session->get($sessionName['fic_length']);
                else $this->c = $this->defCharCount;			

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
		$sessionName ='captcha_' . $this->strId;
		$arrCaptcha = $this->Session->get($sessionName); 

                //Phänomän mit Sessionsetzung mit und ohne Ajax ausgleichen
                $sum = ($this->Input->post('sendAjax')==1)? $this->Session->get($sessionName['sum']) : $arrCaptcha['sum']; 
		
                $length = ($this->fic_length) ? $this->fic_length : $GLOBALS['TL_CONFIG']['fic_length'];
                
		if (!is_array($arrCaptcha) || !strlen($arrCaptcha['key']) || !strlen($sum) || $this->Input->post($arrCaptcha['key']) != $sum)
		{
			$this->class = 'error';
			$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['imagecaptcha'],$length));
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
	public function generateCaptcha($src='', $alt='', $attributes='')
	{
		$int1 = '';
                global $objPage;

		for($i=0 ; $i<$this->c ; $i++)
		{
		    $int1 .= mt_rand(1, 9);
                }
		
		$this->Session->set('captcha_' . $this->strId, array
		(
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
//                $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/FormImageCaptcha/html/js/ajax.js';
                
                $GLOBALS['TL_CSS'][] = 'system/modules/NumberImageCaptcha/html/css/nic_styles.css';
                
                $GLOBALS['TL_MOOTOOLS'][] = "
                        <script type=\"text/javascript\">
                        <!--//--><![CDATA[//><!--
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
                              // the 'r' is response from server
                             // $('number_box').setStyle('display','block');
                                $('captcha_img').set('src', r);
                                $('captcha_img').fade('in');
                                $$('input[name=sendAjax]').each(function(el){ console.log(el);el.set('value','1')});
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
		return sprintf('<img src="system/modules/NumberImageCaptcha/image.php?sk=%s" alt="SecureImage" border="0"  id="captcha_img"/>
		<a href="{{link_url::%s}}" id="refresh_captcha" title="'.$GLOBALS['TL_LANG']['tl_form_field']['fic_reload_button_text'][1].'">'.$GLOBALS['TL_LANG']['tl_form_field']['fic_reload_button_text'][0].'</a>
		<input type="hidden" name="sendAjax" value="0"/>',
						$this->strId,$objPage->id);
						
		
	}

        public function generateAjax()
	{
            $this->import('Session');

            $sk = $this->Input->get('sk');
            $sessionName ='captcha_' . $sk;
            $captchaSession = $this->Session->get($sessionName);
         
            //new Code
             if($captchaSession['fic_length']) $this->c = $captchaSession['fic_length'];
             else $this->c = $GLOBALS['TL_CONFIG']['fic_length']; 
            	          
            for($i=0 ; $i < $this->c ; $i++)
            {
                $int1 .= mt_rand(1, 9);
            }
            
            $this->Session->set($sessionName['sum'],$int1);

            print "system/modules/NumberImageCaptcha/image.php?sk=".$sk."&k=".$this->Session->get($sessionName['sum'])*$sk;
        }

}

?>
