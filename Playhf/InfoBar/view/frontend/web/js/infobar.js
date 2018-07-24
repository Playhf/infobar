define([
    'uiElement',
    'underscore'
], function (Component, _) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
        },

        getItems: function () {
            return _.toArray(this.items);
        }
    });
});