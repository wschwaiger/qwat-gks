<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   GoogleKeywordSuggest
 * @author    Wolfgang Schwaiger <wolfgang.schwaiger@qualitywork.at>
 * @license   LGPLv3
 * @copyright quality work | clever.simple.effective.
 */

$lang = array(
    'de' => array(
        'bad_request' => 'Ungültige Eingabe. Bitte füllen Sie alle Eingabefelder aus.',
        'http_error' => 'Fehler beim lesen der Server-Antwort. Status Code:',
        'api_error' => 'Die Server-Antwort lieferte keine Ergebnisse.',
        'title' => 'In Google ansehen'
    ),
    'en' => array(
        'bad_request' => 'Bad request. Please fill in all input fields.',
        'http_error' => 'Error reading response from API. Response status:',
        'api_error' => 'The response does not contain any results.',
        'title' => 'View in Google'
    )
);

// collect data from AJAX request via POST
$l_str_Language = array_key_exists("lang", $_POST) ? $_POST["lang"][0] : "";
$l_str_Country = array_key_exists("country", $_POST) ? $_POST["country"][0] : "";
$l_str_Keyword = array_key_exists("keyword", $_POST) ? utf8_encode(urlencode(trim($_POST['keyword'][0]))) : "";
$l_str_be_lang = array_key_exists("be_lang", $_POST) ? $_POST["be_lang"][0] : "";

// abort if a requested value is empty, return an empty string to clear the current list
if (empty($l_str_Language) || empty($l_str_Country) || empty($l_str_Keyword)) {
    echo '<li><span class="tl_error">' . $lang[$l_str_be_lang]['bad_request'] . '<span></li>';
    exit;
}

// get url
$l_str_Url = 'http://google.com/complete/search?output=xml&hl=' . $l_str_Language . '&gl=' . $l_str_Country. '&q=' . $l_str_Keyword;

$l_obj_Curl = curl_init();
curl_setopt($l_obj_Curl, CURLOPT_URL, $l_str_Url);
curl_setopt($l_obj_Curl, CURLOPT_HEADER, 0);
curl_setopt($l_obj_Curl, CURLOPT_RETURNTRANSFER, 1);
$l_str_Response = curl_exec($l_obj_Curl);
$l_int_HttpStatus = curl_getinfo($l_obj_Curl, CURLINFO_HTTP_CODE);
curl_close($l_obj_Curl);

// either no response received or Failure in request
if (empty($l_str_Response)) {
    echo '<li>' . sprintf('<p class="tl_error">'. $lang[$l_str_be_lang]['http_error'] . ' %d</p>', $l_int_HttpStatus) . '</li>';
    exit;
}
$l_str_Response = utf8_encode($l_str_Response);

// get url
$l_str_Url = 'http://google.de/complete/search?output=toolbar&hl=' . $l_str_Language.'&gl=' .
    $l_str_Country . '&q=' . $l_str_Keyword;

$l_obj_Curl = curl_init();
curl_setopt($l_obj_Curl, CURLOPT_URL, $l_str_Url);
curl_setopt($l_obj_Curl, CURLOPT_HEADER, 0);
curl_setopt($l_obj_Curl, CURLOPT_RETURNTRANSFER, 1);
$l_str_Response = curl_exec($l_obj_Curl);
$l_int_HttpStatus = curl_getinfo($l_obj_Curl, CURLINFO_HTTP_CODE);
curl_close($l_obj_Curl);

// either no response received or Failure in request
if (empty($l_str_Response)) {
    echo '<li>' . sprintf('<p class="tl_error">'. $lang[$l_str_be_lang]['http_error'] . ' %d</p>', $l_int_HttpStatus) . '</li>';
    exit;
}
$l_str_Response = utf8_encode($l_str_Response);

// convert response to XML
/** @var SimpleXMLElement $l_obj_xml */
$l_obj_xml = simplexml_load_string($l_str_Response);

if (empty($l_obj_xml)) {
    echo '<li>' . sprintf('<p class="tl_error">'. $lang[$l_str_be_lang]['api_error'] . '</p>') . '</li>';
    exit;
}

// iterate through each suggestion
$l_str_Result = "";
foreach ($l_obj_xml->CompleteSuggestion as $l_obj_Value) {
    // append suggestion to output list
    $l_str_Result .= '<li><a href="https://www.google.com/?gws_rd=ssl#hl=' . $l_str_Language . '&gl=' . $l_str_Country. '&q=' . $l_obj_Value->suggestion['data'] . '" class="navigation" target="_blank" title="'. $lang[$l_str_be_lang]['title'] . '"><span style="margin-right: 0.5em;">' . $l_obj_Value->suggestion['data'] . '</span></a></li>';
}
// alert suggestions
echo '<ul class="results">' . $l_str_Result . '</ul>';
echo '<div class="clear"></div>';
