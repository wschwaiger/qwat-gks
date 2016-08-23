<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   GoogleKeywordSuggest
 * @author    Wolfgang Schwaiger <wolfgang.schwaiger@qualitywork.at>
 * @license   LGPLv3
 * @copyright quality work | clever.simple.effective.
 */


/**
 * Namespace
 */
namespace GoogleKeywordSuggest;

/**
 * Class GoogleKeywordSuggest
 *
 * @copyright  quality work | clever.simple.effective.
 * @author     Wolfgang Schwaiger <wolfgang.schwaiger@qualitywork.at>
 * @package    Devtools
 */
class GoogleKeywordSuggest extends \BackendModule
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = '';


    /**
     * Generate the module
     */
    protected function compile()
    {
        /* empty */
    }
    
    public function injectJavaScript($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_main') {
            /* find the navigation element and prevent the default click event */
            $strContent .= '<script>' . file_get_contents('../' . GKS_PATH . '/assets/js/gks.js') . '</script>';
        }

        return $strContent;
    }
}
