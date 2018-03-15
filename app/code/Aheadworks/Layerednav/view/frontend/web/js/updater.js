/**
* Copyright 2018 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

define([
    'jquery',
    './filter/value',
    './filter/item/current',
    './url'
], function ($, filterValue, currentFilterItem, url) {
    'use strict';

    return {
        config: {
            mainColumn: 'div.column.main',
            navigation: '[data-role=filter-block]'
        },

        /**
         * Initialize
         *
         * @param {Object} config
         */
        init: function (config) {
            $.extend(this.config, config);
        },

        /**
         * Performs update blocks and window url, without scroll up to the top of page
         *
         * @param {String} windowUrl
         * @param {Object} blocksHtml
         */
        update: function (windowUrl, blocksHtml) {
            if (blocksHtml) {
                this._performUpdate(windowUrl, blocksHtml);
            }
        },

        /**
         * Performs update blocks, window url and scroll up to the top of page
         *
         * @param {String} windowUrl
         * @param {Object} blocksHtml
         */
        updateAndScrollUpToTop: function (windowUrl, blocksHtml) {
            if (blocksHtml) {
                this._performUpdate(windowUrl, blocksHtml);
                $('body, html').animate({scrollTop: 0}, 0);
            }
        },

        /**
         * Performs update blocks and window url
         *
         * @param {String} windowUrl
         * @param {Object} blocksHtml
         */
        _performUpdate: function (windowUrl, blocksHtml) {
            var mainColumnHtml = blocksHtml.mainColumn,
                navigationHtml = blocksHtml.navigation;

            $(this.config.mainColumn).replaceWith(mainColumnHtml);
            $(this.config.mainColumn).trigger('contentUpdated');

            $(this.config.navigation).replaceWith(navigationHtml);
            filterValue.reset();
            currentFilterItem.reset();
            $(this.config.navigation).trigger('contentUpdated');

            this._setCurrentUrl(windowUrl);
        },

        /**
         * Set current url
         *
         * @param {String} windowUrl
         */
        _setCurrentUrl: function (windowUrl) {
            url.setCurrentUrl(windowUrl);
            if (typeof(window.history.pushState) == 'function') {
                window.history.pushState(null, url.getCurrentUrl(), url.getCurrentUrl());
            } else {
                window.location.hash = '#!' + url.getCurrentUrl();
            }
        }
    };
});
