<?php

/**
 * @copyright  sr-tag Webentwicklung 2016
 * @author     Sven Rhinow
 * @package    FormImageCaptcha
 * @license    LGPL
 * @filesource
 */

/**
 * Palette
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{imagecaptcha_legend:hide},nic_width,nic_height,nic_fontcolor,nic_linecolor,nic_bgcolor,nic_length,nic_fontsize,nic_charset,nic_charspace,nic_angle,nic_padding,nic_font';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_width'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_width'],
			'default'		  => 91,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_height'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_height'],
			'default'		  => 31,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_fontcolor'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_fontcolor'],
			'inputType'               => 'text',
			'default'		  => 'ffffff',
			'eval'                    => array('maxlength'=>6, 'rgxp'=>'alnum', 'tl_class'=>'w50 wizard'),
			'wizard' => array
			(
				array('tl_settinghelper', 'colorPicker')
			)
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_linecolor'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_linecolor'],
			'inputType'               => 'text',
			'default'		  => 'eeeeee',
			'eval'                    => array('maxlength'=>6, 'rgxp'=>'alnum', 'tl_class'=>'w50 wizard'),
			'wizard' => array
			(
				array('tl_settinghelper', 'colorPicker')
			)
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_bgcolor'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_bgcolor'],
			'inputType'               => 'text',
			'default'		  => '000000',
			'eval'                    => array('maxlength'=>6, 'rgxp'=>'alnum', 'tl_class'=>'w50 wizard'),
			'wizard' => array
			(
				array('tl_settinghelper', 'colorPicker')
			)
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_font'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_font'],
			'default'		  => 4,
			'inputType'               => 'select',
			'options_callback'        => array('tl_settinghelper', 'getFonts'),
			'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_fontsize'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_fontsize'],
			'default'		  => 4,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_length'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_length'],
			'default'		  => 5,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_charspace'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_charspace'],
			'default'		  => 18,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_angle'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_angle'],
			'default'		  => 0,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['nic_padding'] = array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['nic_padding'],
			'default'		  => 0,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
);

/**
 * Class tl_settinghelper copy from tl_style
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2009
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Controller
 */
class tl_settinghelper extends Backend
{

	/**
	 * Add the mooRainbow scripts to the page
	 */
	public function __construct()
	{
		parent::__construct();

		$GLOBALS['TL_CSS'][] = 'assets/mootools/colorpicker/1.4/css/mooRainbow.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'assets/mootools/colorpicker/1.4/js/mooRainbow.js';
	}

	/**
	 * Return the color picker wizard
	 * @param object
	 * @return string
	 */
	public function colorPicker(DataContainer $dc)
	{
	    return ' ' . $this->generateImage('pickcolor.gif', $GLOBALS['TL_LANG']['MSC']['colorpicker'], 'style="vertical-align:top;cursor:pointer" id="moo_'.$dc->field.'"') . '
	      <script>
	      new MooRainbow("moo_'.$dc->field.'", {
		id:"ctrl_' . $dc->field . '_0",
		startColor:((cl = $("ctrl_'.$dc->field.'").value.hexToRgb(true)) ? cl : [255, 0, 0]),
		imgPath:"assets/mootools/colorpicker/1.4/images/",
		onComplete: function(color) {
		  $("ctrl_' . $dc->field . '").value = color.hex.replace("#", "");
		}
	      });
	      </script>';
	}

	/**
	 * Return all ttf-Files as array
	 * @return array
	 */
	public function getFonts()
	{
		$arrReturn = array();
		$arrFiles = scan(TL_ROOT . '/system/modules/form-image-captcha/assets/fonts');
                #print_r($arrFiles);
		foreach ($arrFiles as $strFile)
		{
			if (($strFile[0] == '.') || is_dir(TL_ROOT . '/system/modules/form-image-captcha/assets/fonts/' . $strFile) || !in_array(stristr($strFile,'.'),array('.ttf')) )
			{
			     continue;
			}

			$arrReturn[$strFile] = $strFile;
		}

		return $arrReturn;
	}

}
