/*global $: false, $$: false, Class: false, Backend: false, Request: false */

/**
 * @package   qwat-gks
 * @author    Wolfgang Schwaiger <wolfgang.schwaiger@qualitywork.at>
 * @license   LGPLv3
 * @copyright quality work | clever.simple.effective.
 */
var GoogleKeywordSuggest = new Class({
    init: function () {
        'use strict';
        
        var self = this;
        /* check if we have MooTools */
        $$('#content li a.qwat-gks').addEvent('click', function (event) {
            event.stop();
            /* show pop-up and load content via ajax */
            Backend.getScrollOffset();
            Backend.openModalIframe({
                'width': 768,
                'title': this.text,
                'url': this.href + "&amp;popup=1"
            });
        });
    },
    initCSS: function () {
        'use strict';
        
        $$('.results li').setStyles({
            width: '50%',
            float: 'left',
            display: 'inline-block',
            'line-height': '3em'
        });
    },
    initListener: function (url) {
        'use strict';
        
        gks.initCSS();
        /* if the input field already has values then fire instantly the request */
        if ($$("#ctrl_keyword").get('value').length >= 0) {
            new Request({
                url: url + "/ajax.php",
                data: {
                    action: "gks_search",
                    be_lang: $$("html").get("lang"),
                    lang: $$("#ctrl_language").get("value"),
                    country: $$("#ctrl_country").get("value"),
                    keyword: $$("#ctrl_keyword").get("value")
                },
                method: "post",
                onRequest: function () {},
                onSuccess: function (responseText) {
                    $$("#gks_results").set("html", responseText);
                    gks.initCSS();
                },
                onFailure: function () {}
            }).send();
        }
        /* add listener to the input field */
        $$("#ctrl_keyword").addEvent("input", function (event) {
            new Request({
                url: url + "/ajax.php",
                data: {
                    action: "gks_search",
                    be_lang: $$("html").get("lang"),
                    lang: $$("#ctrl_language").get("value"),
                    country: $$("#ctrl_country").get("value"),
                    keyword: $$("#ctrl_keyword").get("value")
                },
                method: "post",
                onRequest: function () {},
                onSuccess: function (responseText) {
                    $$("#gks_results").set("html", responseText);
                    gks.initCSS();
                },
                onFailure: function () {}
            }).send();
        });
    }
}),
    gks = new GoogleKeywordSuggest();

/* init the awesome */
if (window.MooTools) {
    window.addEvent('domready', function () {
        'use strict';
        
        gks.init();
        
        if ($('top').hasClass('popup')) {
            /* when the pop up is open hide 'Save and Close' button and the 'back' button */
            $$('#saveNclose, #tl_buttons').hide();
        }
    });
}