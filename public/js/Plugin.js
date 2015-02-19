/**
 * Created by Samuel on 2/12/2015.
 */
/**
 *
 * Name v0.0.1
 * Description, by Chris Ferdinandi.
 * http://gomakethings.com
 *
 * Free to use under the MIT License.
 * http://gomakethings.com/mit/
 *
 */

(function (root, factory) {
    //http://addyosmani.com/writing-modular-js/
    if (typeof define === 'function' && define.amd) {
        define('SmPhotoswipe', factory(root));
    } else if (typeof exports === 'object') {
        module.exports = factory(root);
    } else {
        root.SmPhotoswipe = factory(root);
    }
})(window || this, function (root) {

    'use strict';

    return function (tmp) {
        var plugin = this;
        //
        // Variables
        //
        var exports = {}; // Object for public APIs

        var Point = function (x, y) {
            this.x = x;
            this.y = y;
        };
        Point.prototype.x = 0;
        Point.prototype.y = 0;

        var SquareBound = function () {
        };
        SquareBound.prototype.lft_bound = 0;
        SquareBound.prototype.rgt_bound = 0;
        SquareBound.prototype.top_bound = 0;
        SquareBound.prototype.btm_bound = 0;


        var Item = function () {
        };
        Item.prototype._bound = new SquareBound();
        Item.prototype._center = new Point();

        Item.prototype._length = 0;
        Item.prototype._height = 0;
        Item.prototype._element = null;
        Item.prototype._class = 'element';
        Item.prototype._builder = function () {
        };
        Item.prototype.build = function () {
            this._builder();
        };
        Item.prototype._beeper = function () {
        };
        Item.prototype.beep = function () {

        };

        var Tray = function () {
        };
        Tray.prototype.list = [];
        Tray.prototype.container = [];
        /**
         * Return the item at a given index
         * @param index
         * @returns {*|boolean}
         */
        Tray.prototype.getItem = function (index) {
            return this.container[index] || false;
        };
        /**
         * Return the index of the current item.
         * @returns {*}
         */
        Tray.prototype.getCurrentIndex = function () {
            return this.list[0];
        };
        /**
         * Move the first or last indexed list item to the opposite position in the list.
         * @param direction 0 means we move the first to last, 1 means we move the last to first.
         * @returns {*} The element that has been cycled
         */
        Tray.prototype.rotate = function (direction) {
            //todo check to see if the array is empty
            //todo implement this somewhere else to make it accessible to other arrays
            direction = (typeof direction !== 'undefined') ? direction : 1;
            var index;
            if (direction == 1) {
                index = this.list.pop();
                this.list.unshift(index);
            } else if (direction == 0) {
                index = this.list.unshift();
                this.list.push(index);
            }
            return index;
        };
        Tray.prototype.push = function (item) {
            this.container.push(item);
            this.list.push(this.container.length - 1);
        };
        var framework = {
            ANIMATION_MANUAL_STOP: 0,
            //the framework has been initialized
            is_init: false,
            features: {
                vendor: null,
                request_animation_frame: function () {
                },
                cancel_animation_frame: function () {
                },
                //Using a touch device
                touch: false,
                /**
                 * Try to figure out the engine behind the user's browser
                 * @private
                 * @returns {*}
                 */
                _get_vendor: function () {
                    if (framework.features.vendor) {
                        return framework.features.vendor;
                    }
                    var styles = window.getComputedStyle(document.documentElement, ''),
                        pre = (Array.prototype.slice
                            .call(styles)
                            .join('')
                            .match(/-(moz|webkit|ms)-/) || (styles.OLink === '' && ['', 'o'])
                        )[1],
                        dom = ('WebKit|Moz|MS|O').match(new RegExp('(' + pre + ')', 'i'))[1];
                    return framework.features.vendor = pre.toLowerCase();
                },
                /**
                 * Initialize the features object
                 */
                init: function () {
                    //The user's supposed browser vendor
                    var vendor = framework.features._get_vendor();

                    // Just some compatibility stuff regarding requestAnimationFrame and the like
                    if (window.requestAnimationFrame) {
                        console.log('true');
                        framework.features.request_animation_frame = function (thing) {
                            window.requestAnimationFrame(thing);
                        };
                        if (!window.cancelAnimationFrame) {
                            window.cancelAnimationFrame = function (id) {
                                clearTimeout(id)
                            };
                        }
                        framework.features.cancel_animation_frame = window.cancelAnimationFrame;
                    }
                    else if (vendor && !framework.features.request_animation_frame) {
                        framework.features.request_animation_frame = window[vendor + 'RequestAnimationFrame'];
                        if (framework.features.request_animation_frame) {
                            framework.features.cancel_animation_frame = window[vendor + 'CancelAnimationFrame'] ||
                            window[vendor + 'CancelRequestAnimationFrame'];
                        }
                    }
                    else {
                        framework.features.request_animation_frame = function (fn) {
                            var current_time = new Date().getTime();
                            var timeToCall = Math.max(0, 16 - (current_time - lastTime));
                            var id = window.setTimeout(function () {
                                fn(current_time + timeToCall);
                            }, timeToCall);
                            lastTime = current_time + timeToCall;
                            return id;
                        };
                        framework.features.cancel_animation_frame = function (id) {
                            clearTimeout(id);
                        };
                    }

                    framework.is_init = true;
                }
            },
            events: {
                info: {
                    /**
                     * requestAnimationFrame already is running
                     * @type {boolean}
                     */
                    ticking: false,
                    last_scrollY: 0
                },
                request_tick: function (callback) {
                    if (!framework.events.info.ticking) {
                        framework.features.request_animation_frame(callback);
                    }
                }
            },
            /**
             * A simple forEach() implementation for Arrays, Objects and NodeLists
             * @private
             * @param {Array|Object|NodeList} collection Collection of items to iterate
             * @param {Function} callback Callback function for each iteration
             * @param {Array|Object|NodeList} scope Object/NodeList/Array that forEach is iterating over (aka `this`)
             */
            foreach: function (collection, callback, scope) {
                if (Object.prototype.toString.call(collection) === '[object Object]') {
                    for (var prop in collection) {
                        if (Object.prototype.hasOwnProperty.call(collection, prop)) {
                            callback.call(scope, collection[prop], prop, collection);
                        }
                    }
                } else {
                    for (var i = 0, len = collection.length; i < len; i++) {
                        callback.call(scope, collection[i], i, collection);
                    }
                }
            },
            /**
             * "Extend' one object using another object as a model (copy over all of the properties)
             * @param defaults :The object receiving the extended properties
             * @param options    :The object with the properties we want to extend
             * @param safeExtend{boolean}:If this is true, make sure we add -but do not overwrite- properties
             */
            extend: function (defaults, options, safeExtend) {
                for (var prop in options) {
                    if (options.hasOwnProperty(prop)) {
                        if (safeExtend && defaults.hasOwnProperty(prop)) {
                            continue;
                        }
                        defaults[prop] = options[prop];
                    }
                }
            },
            expand: function (element, viscosity) {
                viscosity = viscosity || 10;
                var val = framework.ANIMATION_MANUAL_STOP += viscosity;
                if (framework.ANIMATION_MANUAL_STOP <= 500) {
                    element.style.height = 10 + val + "px";
                    element.style.width = 10 + val + "px";
                    framework.features.request_animation_frame(function () {
                        framework.expand(element, Math.ceil(viscosity * 1.5))
                    });
                }
            },
            /**
             *
             * @param duration  How long to run animation?
             * @param delta
             * @param step
             * @param delay
             */
            animate: function (duration, delta, step, delay) {

                var start = new Date;

                var id = setInterval(function () {
                    var timePassed = new Date - start;
                    var progress = timePassed / duration;

                    if (progress > 1) progress = .5;

                    var delta = delta(progress);
                    step(delta);

                    if (progress == 1) {
                        clearInterval(id)
                    }
                }, delay || 10)

            }

        };
        var app = {
            /** Default settings of the app */
            default_settings: {
                callbackBefore: function () {
                },
                callbackAfter: function () {
                }
            },
            gallery: {
                Tray: new Tray(),
                /**
                 * List of items that the user has selected, maybe stored in a tray or array
                 * @type {Tray|null|Array}
                 */
                selected_items: null,
                theater_view: {
                    /**
                     * An array of built elements that are likely to come before or after an element
                     */
                    pre_queue: [], post_queue: []
                }
            }
        };

        /**
         * Convert data-options attribute into an object of key/value pairs
         * @private
         * @param {String} options Link-specific options as a data attribute string
         * @returns {Object}
         */
        var getDataOptions = function (options) {
            return !options || !(typeof JSON === 'object' && typeof JSON.parse === 'function') ? {} : JSON.parse(options);
        };

        // @todo Do something...

        /**
         * Destroy the current initialization.
         * @public
         */
        exports.destroy = function () {
            // @todo Undo init...
        };

        /**
         * Initialize Plugin
         * @public
         * @param {Object} options User settings
         */
        exports.init = function (options) {
            // @todo Do something...
        };


        framework.features.init();

        document.getElementById('test').addEventListener('click', function () {
            document.getElementById('in').style.width = '10px';
            document.getElementById('in').style.height = '10px';
            framework.ANIMATION_MANUAL_STOP = 0;
            window.requestAnimationFrame(function () {
                framework.expand(document.getElementById('in'))
            });
        })
    };

});