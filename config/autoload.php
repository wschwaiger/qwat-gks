<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'GoogleKeywordSuggest',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'GoogleKeywordSuggest\GoogleKeywordSuggest' => 'system/modules/qwat-gks/classes/GoogleKeywordSuggest.php',
));
