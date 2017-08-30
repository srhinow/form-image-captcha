<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package FormImageCaptcha
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'FormImageCaptcha' => 'system/modules/form-image-captcha/classes/FormImageCaptcha.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'image_captcha' => 'system/modules/form-image-captcha/templates',
));
