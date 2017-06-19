<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package NumberImageCaptcha
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'NumberImageCaptcha' => 'system/modules/NumberImageCaptcha/classes/NumberImageCaptcha.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'image_captcha' => 'system/modules/NumberImageCaptcha/templates',
));
