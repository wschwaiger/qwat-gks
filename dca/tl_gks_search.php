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

$GLOBALS['TL_DCA']['tl_gks_search'] = array
(
    'config' => array
    (
        'dataContainer'               => 'File',
        'label'                       => &$GLOBALS['TL_LANG']['gks']
    ),

    'palettes' => array(
        'default' => '{settings_legend},language,country,keyword;{results_legend},results;'
    ),

    'subpalettes' => array
    (
        'keyword' => 'results'
    ),

    'fields' => array
    (
        'language' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_gks_search']['language'],
            'default'                 => str_replace('-', '_', $GLOBALS['TL_LANGUAGE']),
            'inputType'               => 'select',
            'options'                 => System::getLanguages(true), /* only get the installed languages */
            'eval'                    => array('rgxp'=>'locale', 'chosen'=>true, 'tl_class'=>'w50'),
        ),
        'country' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_gks_search']['country'],
            'inputType'               => 'select',
            'options'                 => System::getCountries(),
            'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
        ),
        'keyword' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_gks_search']['keyword'],
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'clr long'),
        ),
        'results' => array
        (
            'input_field_callback' => array('tl_gks_search', 'initJavaScript')
        )
    ),
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author    Wolfgang Schwaiger <wolfgang.schwaiger@qualitywork.at>
 */
class tl_gks_search extends Backend
{
    /**
     * Append JavaScript code for the AJAX calls to the Google API
     * @param \DataContainer
     * @return string
     */
    public function initJavaScript(DataContainer $dataContainer)
    {
        // assemble JavaScript
        $return = '<script type="text/javascript">';
        $return .= 'if (window.MooTools) {';
        $return .= 'window.addEvent("domready", function () {';
        $return .= '"use strict";';
        
        $return .= 'gks.initListener("'. GKS_PATH . '");';
        
        $return .= '});';
        $return .= '}';
        $return .= '</script><div id="gks_results"></div>';
        
        return $return;
    }
}
