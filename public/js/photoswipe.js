//noinspection ThisExpressionReferencesGlobalObjectJS
/**
 * @param root        references the window, top level 'this'
 *                    @todo continue
 * @param factory    @todo
 *
 */
(function (root, factory) {
    root.SmPhotoSwipe = factory(root);
})(window || this, function (root) {
    'use strict';
    /**
     * @todo see if this is necessary. Seems kind of odd to immediately return something from an anonymous function
     * @param template{HTMLElement} The element holding the gallery
     * @param UiClass @todo figure out wtf this is
     * @param items     A list of items to load into the gallery
     * @param options
     */
    var SmPhotoswipeFunction = function (template, UiClass, items, options) {
        var Point = function (x, y) {
            this.x = (x != null) ? x : 0;
            /** Y dimension-variable */
            this.y = (y != null) ? y : 0;
        };
        /**
         * X dimension-variable
         * @type {number}
         */
        Point.prototype.x = 0;
        /**
         * Y dimension-variable
         * @type {number}
         */
        Point.prototype.y = 0;
        Point.prototype.id = null;
        /**
         * Round the dimension variables of this point
         */
        Point.prototype.roundPoint = function () {
            this.x = Math.round(this.x);
            this.y = Math.round(this.y);
        };
        /**
         * Set this point equal to another one
         * @param PointEqual{Point}
         */
        Point.setEqualTo = function (PointEqual) {
            this.x = PointEqual.x;
            this.y = PointEqual.y;
            if (PointEqual.id)    this.id = PointEqual.id;
        };
        /**
         * An object
         * @constructor
         */
        var Bound = function () {
        };
        Bound.prototype.max = new Point();
        Bound.prototype.min = new Point();
        Bound.prototype.center = new Point();

        /**
         * An object representing an image or a video or whatever
         * @param x @todo figure out the necessity of x and y
         * @param y
         * @constructor
         * @param width width of the item(in px)
         * @param height height of the item(in px)
         */
        var Item = function (x, y, width, height) {
            this.x = x;
            this.y = y;
            this.error = false;
        };
        Item.prototype.width = 0;
        Item.prototype.height = 0;
        Item.prototype.error = false;
        Item.prototype.bounds = new Bound();
        //Todo figure this out
        Item.prototype.container = null;
        Item.prototype.needsUpdate = false;
        //Vertical gap of the top and bottom of this object
        Item.prototype.vGap = {top:0,bottom:0};
        //todo what is this
        Item.prototype.fitRatio = 1;
        //The initial coordinates of the item
        Item.prototype.initialPosition = new Point();
        Item.prototype._initialZoomLevel = false;
        Item.prototype.src = '';
        Item.prototype.checkForError = function(cleanUp) {
            if(this.src && this.loadError && this.container) {
                if(cleanUp) {
                    this.container.innerHTML = '';
                }
                this.container.innerHTML = app._config.errorMsg.replace('%url%',  this.src );
                return true;
            }
        };

        Item.prototype.getInitialZoomLevel = function () {
            return this._initialZoomLevel;
        };
        Item.prototype._calculateItemSize = function (viewportSize, zoomLevel) {
            if (this.src && !this.loadError) {
                //todo figure
                var isInitial = !zoomLevel;
                if(isInitial) {
                    if(!this.vGap) {
                        this.vGap = {top:0,bottom:0};
                    }
                    // allows overriding vertical margin for individual items
                    app._shout('parseVerticalMargin', this);
                }
                app.gallery._tempPanAreaSize.x = viewportSize.x;
                app.gallery._tempPanAreaSize.y = viewportSize.y - this.vGap.top - this.vGap.bottom;
                if (isInitial) {
                    var hRatio = app.gallery._tempPanAreaSize.x / this.width;
                    var vRatio = app.gallery._tempPanAreaSize.y / this.height;
                    this.fitRatio = hRatio < vRatio ? hRatio : vRatio;
                    //this.fillRatio = hRatio > vRatio ? hRatio : vRatio;
                    var scaleMode = app._config.scaleMode;
                    if (scaleMode === 'orig') {
                        zoomLevel = 1;
                    } else if (scaleMode === 'fit') {
                        zoomLevel = this.fitRatio;
                    }
                    if (zoomLevel > 1) {
                        zoomLevel = 1;
                    }
                    this.initialZoomLevel = zoomLevel;
                    if(!this.bounds) {
                        // reuse bounds object
                        this.bounds = new Bound();
                    }
                }
                if(!zoomLevel) {
                    return;
                }
                this._calculateSingleItemPanBounds(this.width * zoomLevel, this.height * zoomLevel);
                if (isInitial && zoomLevel === this.initialZoomLevel) {
                    this.initialPosition = this.bounds.center;
                }
                return this.bounds;
            } else {
                this.width = this.height = 0;
                this.initialZoomLevel = this.fitRatio = 1;
                this.bounds = new Bound();
                this.initialPosition = this.bounds.center;
                // if it's not image, we return zero bounds (content is not able to be zoomed)
                return this.bounds;
            }
        };
        Item.prototype._calculateSingleItemPanBounds = function(realPanElementW, realPanElementH ) {
            var bounds = this.bounds;
            // position of element when it's centered
            bounds.center.x = Math.round((app.gallery._tempPanAreaSize.x - realPanElementW) / 2);
            bounds.center.y = Math.round((app.gallery._tempPanAreaSize.y - realPanElementH) / 2) + this.vGap.top;
            // maximum pan position
            bounds.max.x = (realPanElementW > app.gallery._tempPanAreaSize.x) ?
                Math.round(app.gallery._tempPanAreaSize.x - realPanElementW) :
                bounds.center.x;
            bounds.max.y = (realPanElementH > app.gallery._tempPanAreaSize.y) ?
            Math.round(app.gallery._tempPanAreaSize.y - realPanElementH) + this.vGap.top :
                bounds.center.y;
            // minimum pan position
            bounds.min.x = (realPanElementW > app.gallery._tempPanAreaSize.x) ? 0 : bounds.center.x;
            bounds.min.y = (realPanElementH > app.gallery._tempPanAreaSize.y) ? this.vGap.top : bounds.center.y;
        };
        /**
         * This function
         * @type {SmPhotoswipeFunction}
         */
        var self = this;
        self.SmPhotoswipe = {};
        // todo uncomment
        //var app = this.SmPhotoSwipe;
        ////////////////////$$$FRAMEWORK/////////////////////////
        /**
         * A set of generic functions/variables to be used by this plugin
         * @type {object}
         */
        var framework = {
            /** @todo discover this */
            features: {
                //all of these values are defaults, meant to be overridden when the proper rules apply
                //User client allows transform
                transform: false,
                //User client allows perspective
                perspective: false,
                //User client allows animationName
                animationName: false,
                raf: false,
                caf: false,
                oldIE: false,
                //Meant to be replaced (the isOld)
                isOldIOSPhone: false,
                isMobileOpera: false,
                isOldAndroid: false,

                //touchscreen
                touch: false
            },
            /**
             * Bind or unbind a listener to an element
             * @param eventTarget
             * @param type_string a space-delimited string of the event types to listen for
             * @param listener int The object that receives notification that this event has happened on this object
             * @param unbind When set to true, we run the "removeEventListener" method. Usually, we run the "addEventListener" method
             *
             * */
            bind: function (eventTarget, type_string, listener, unbind) {
                var methodName = (unbind ? 'remove' : 'add') + 'EventListener';
                type_string = type_string.split(' ');
                for (var i = 0; i < type_string.length; i++) {
                    if (type_string[i]) {
                        eventTarget[methodName](type_string[i], listener, false);
                    }
                }
            },
            /**
             * A shortcut for the framework.bind function with the unbind flag already set to true. Done for clarity
             * @param eventTarget
             * @param type_string
             * @param listener
             */
            unbind: function (eventTarget, type_string, listener) {
                framework.bind(eventTarget, type_string, listener, true);
            },
            /**
             * Make an element with specified classes
             * @todo reorder the elements and potentially add an id?
             * @param classes the classes to which the element is meant to belong
             * @param tag the type of tag to create
             * @return {HTMLElement} the newly created element
             */
            createEl: function (classes, tag) {
                var el = document.createElement(tag || 'div');
                if (classes) {
                    el.className = classes;
                }
                return el;
            },
            /**
             * @returns {Number} The number of pixels by which the page has been scrolled
             */
            getScrollY: function () {
                var yOffset = window.pageYOffset;
                return yOffset !== undefined ? yOffset : document.documentElement.scrollTop;
            },
            /**
             * Add a class to a specified object
             * @param el{HTMLElement}
             * @param className{string}
             */
            addClass: function (el, className) {
                el.className += (el.className ? ' ' : '') + className;
            },
            /**
             * Remove a class from a specified HTMLElement
             * @param el{HTMLElement}
             * @param className{string}
             */
            removeClass: function (el, className) {
                var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
                el.className = el.className.replace(reg, ' ').replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            },
            /**
             * Check to see if an element has a class
             * @param el{HTMLElement} The element in question
             * @param className{string} The class in question
             * @returns {boolean}
             */
            hasClass: function (el, className) {
                return (el.className && new RegExp('(^|\\s)' + className + '(\\s|$)').test(el.className));
            },
            /**
             * Find first child with a given class within a parent element
             * @param parentEl{HTMLElement} The parent to search through
             * @param childClassName{string} The classname to find
             * @returns {Node} The found node matching the classname
             */
            getChildByClass: function (parentEl, childClassName) {
                var node = parentEl.firstChild;
                while (node) {
                    if (framework.hasClass(node, childClassName)) {
                        return node;
                    }
                    node = node.nextSibling;
                }
            },
            /**
             * Search for a value in an array
             * @param array
             * @param value
             * @param key
             * @returns {*}
             */
            arraySearch: function (array, value, key) {
                var i = array.length;
                while (i--) {
                    if (array[i][key] === value) {
                        return i;
                    }
                }
                return -1;
            },
            /**
             * "Extend' one object using another object as a model (copy over all of the properties)
             * @param object_to_get_extended :The object receiving the extended properties
             * @param object_with_extendable_properties    :The object with the properties we want to extend
             * @param safeExtend{boolean}:If this is true, make sure we add -but do not overwrite- properties
             */
            extend: function (object_to_get_extended, object_with_extendable_properties, safeExtend) {
                for (var prop in object_with_extendable_properties) {
                    if (object_with_extendable_properties.hasOwnProperty(prop)) {
                        if (safeExtend && object_to_get_extended.hasOwnProperty(prop)) {
                            continue;
                        }
                        object_to_get_extended[prop] = object_with_extendable_properties[prop];
                    }
                }
            },
            /**
             *  Container of smooth easing methods
             *  @todo figure this out
             */
            easing: {
                sine: {
                    out: function (k) {
                        return Math.sin(k * (Math.PI / 2));
                    },
                    inOut: function (k) {
                        return -(Math.cos(Math.PI * k) - 1) / 2;
                    }
                },
                cubic: {
                    out: function (k) {
                        return --k * k * k + 1;
                    }
                }
            },
            /**
             * Detect which features we have access to in most cases. Also, create requestAnimationFrame and
             * cancelAnimationFrame functions stored in framework.features.raf and caf respectively. Not all browsers
             * support requestAnimationFrame, so we make our own.
             *
             * todo make this more of my own, especially around the nested for loop
             * @returns {object}
             */
            detectFeatures: function () {
                if (framework.features) {
                    return framework.features;
                }
                /**
                 * A randomly created element meant to be used to check if a given functionality is present
                 */
                var helperEl = framework.createEl(),
                    helperStyle = helperEl.style;
                var vendor = '',
                    features = {};
                /**
                 * Determine if the browser is old(IE8 or below)
                 * @todo make a more generic check
                 * @type {Array|boolean}
                 */
                features.oldIE = document.all && !document.addEventListener;
                features.touch = 'ontouchstart' in window;
                if (window.requestAnimationFrame) {
                    features.raf = window.requestAnimationFrame;
                    features.caf = window.cancelAnimationFrame;
                }
                if(navigator.hasOwnProperty('pointerEnabled') || navigator.hasOwnProperty('msPointerEnabled'))
                    features.pointerEvent = navigator.pointerEnabled || navigator.msPointerEnabled;

                //There used to be UA sniffing here to try to counteract known bugs. I am not in love with the idea, so
                //I took that out. There should be some system of flags letting us know which features are available to
                //The user
                //features.isOldIOSPhone,
                //features.isOldAndroid,
                //features.androidVersion,
                //features.isMobileOpera

                var styleChecks =
                        [
                            'transform', 'perspective', 'animationName'
                        ],
                    vendors =
                        [
                            '', 'webkit', 'Moz', 'ms', 'O'
                        ],
                    styleCheckItem,
                    styleName;
                for (var i = 0; i < 4; i++) {
                    vendor = vendors[i];
                    for (var a = 0; a < 3; a++) {
                        styleCheckItem = styleChecks[a];
                        /**
                         * The vendor name with the first name capitalized if there is one
                         * @type {string}
                         */
                        styleName = vendor + (vendor ?
                        styleCheckItem.charAt(0).toUpperCase() + styleCheckItem.slice(1) : styleCheckItem);
                        if (!features[styleCheckItem] && styleName in helperStyle) {
                            features[styleCheckItem] = styleName;
                        }
                    }
                    if (vendor && !features.raf) {
                        vendor = vendor.toLowerCase();
                        features.raf = window[vendor + 'RequestAnimationFrame'];
                        if (features.raf) {
                            features.caf = window[vendor + 'CancelAnimationFrame'] ||
                            window[vendor + 'CancelRequestAnimationFrame'];
                        }
                    }
                }
                if (!features.raf) {
                    var lastTime = 0;
                    //todo figure out how raf works
                    features.raf =
                        function (fn) {
                            var current_time = new Date().getTime();
                            var timeToCall = Math.max(0, 16 - (current_time - lastTime));
                            var id = window.setTimeout(function () {
                                fn(current_time + timeToCall);
                            }, timeToCall);
                            lastTime = current_time + timeToCall;
                            return id;
                        };
                    features.caf = function (id) {
                        clearTimeout(id);
                    };
                }
                // Detect SVG support
                features.svg = !!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect;
                framework.features = features;
                return features;
            },
            getCurrentTime: function () {
                return new Date().getTime();
            }
        };
        framework.detectFeatures();
        //if we are dealing with a browser that does not support addEventListener, create a new version for us to use
        if (framework.features.oldIE) {
            framework.bind = function (target, type, listener, unbind) {
                type = type.split(' ');
                var methodName = (unbind ? 'detach' : 'attach') + 'Event',
                    evName,
                    _handleEv = function () {
                        listener.handleEvent.call(listener);
                    };
                for (var i = 0; i < type.length; i++) {
                    evName = type[i];
                    if (evName) {
                        if (typeof listener === 'object' && listener.handleEvent) {
                            if (!unbind) {
                                listener['oldIE' + evName] = _handleEv;
                            } else {
                                if (!listener['oldIE' + evName]) {
                                    return false;
                                }
                            }
                            target[methodName]('on' + evName, listener['oldIE' + evName]);
                        } else {
                            target[methodName]('on' + evName, listener);
                        }
                    }
                }
            };
        }
        ////////////////////^^^FRAMEWORK/////////////////////////

        /**
         * I don't know what these are. Speculation is that DTR is the tolerance for what is considered a double tap
         * and num_holders is ...
         * @todo figure this out
         * @type {number}
         */
        var DOUBLE_TAP_RADIUS = 25;
        // The number of holders  WHAT IS A HOLDER
        var NUM_HOLDERS = 3;
        //////////////

        /////////////////
        var app = {
            //Here for extensibiity, these are the modules that have been registered via extend. For the future!
            _modules: [],
            //todo figure this out
            itemHolders: [],
            /**
             * I don't really want to use this here, but meant to be a shortcut for app.gallery.container.style
             */
            containerStyle: '',
            //todo figure this out
            /** speculation: the direction which will be used to move the images (left or right)*/
            _transformKey: '',
            _mainScrollPos: null,
            _midZoomPoint: new Point(),

            _containerShiftIndex: 0,
            // drag move, drag end & drag cancel events array todo
            _upMoveEvents: [],
            // An array of events for when the user starts dragging todo
            _downEvents: [],
            /**
             * An object of the global event listeners we want to bind to the window
             * i.e. scroll, resize, keydown, and click
             */
            _globalEventHandlers: {},
            /**
             * Figure out what this does and how it's different from
             * @link app.gallery.currentItemIndex
             */
            _currPositionIndex: 0,
            /**
             * The current y position of the window scroll in pixels
             * @type number
             */
            _currentWindowScrollY: 0,
            _viewportSize: {x:0, y:0},
            _startZoomLevel: 0,
            _offset: {},
            _currPanDist: 0,
            _startPanOffset: new Point(),
            _mouseMoveTimeout: 0,
            _windowVisibleSize: {x:0, y:0},
            /**
             * I think this is a function that is used to determine how often to check the size of the window.
             * This would be a function saying 'every x milliseconds, check the update the window size if something is different'
             */
            _updateSizeInterval: 0,
            // difference of indexes since last content update
            _indexDiff: 0,
            //touch
            _isDragging: null,
            /**
             * @type {Bound}
             */
            _currPanBounds: null,
            //todo figure out what this is
            _isFixedPosition: false,

            //todo read into which css selector is being referenced by these translate controls
            /** Primarily written to in _setupTransforms to be --> '3d('   -or-  '('
             * The former being so if perspective is allowed and we aren't dealing with a touch device*/
            _translatePrefix: '',
            /** Primarily written to in _setupTransforms to be --> ', 0px)' -or- ')'
             * The former being so if perspective is allowed*/
            _translateSuffix: '',
            //@todo figure out what this is. used in  app._applyCurrentZoomPan
            _currZoomElementStyle: null,
            /**
             * @type {Point}
             */
            _panOffset: new Point(),
            _currZoomLevel: null,
            /**
             * THIS IS NOT A POINT! I just haven't the time to reconfigure the whole x: , y: thing and thought it was a point initially.
             * This is the size each slide will be based on the viewport size and the configures spacing
             */
            _slideSize: new Point(),
            /**
             * An object of the customizations we want to be made available to the user
             */
            _config: {
                canPinchClosed: true,
                canCloseOnScroll: true,
                //Can close the gallery view on a vertical drag
                canCloseOnVertDrag: true,
                canPanToNext: true,
                canLoopThru: true,
                mouseUsed: false,
                //Escape key is used to close the gallery
                escKeyUsed: true,
                //Arrow keys are used for navigational purposes
                arrowKeysUsed: true,
                canBeFocused: true,
                //speculation the opacity of the elements that are getting revealed or hidden?
                //look more into this
                showHideOpacity: false,
                _initialWindowScrollY: 0,
                spacing: 0.12,
                _bgOpacity: 1,
                hideAnimationDuration: 333,
                showAnimationDuration: 333,
                mainScrollEndFriction: 0.35,
                panEndFriction: 0.35,
                maxSpreadZoom: 2,
                /**
                 * Check to see if the element is something that can be used for our clicking purposes
                 * @param el
                 * @returns {boolean}
                 */
                isClickableElement: function (el) {
                    return el.tagName === 'A';
                },
                /**
                 * A list of events and event statistics
                 */
                event_list: {
                    _moved: false,
                    _zoomStarted: false,
                    _mainScrollAnimating: false,
                    _initialZoomRunning: false,
                    _verticalDragInitiated: false,
                    _scrollChanged: false,
                    _closedByScroll: false,
                    _isDragging: false,
                    //the number of animations currently taking place ... ?
                    _numAnimations: 0,
                    _isZooming: false

                },
                /**
                 * todo i don't know
                 * @param isMouseClick
                 * @param item
                 * @returns {number}
                 */
                getDoubleTapZoom: function (isMouseClick, item) {
                    if (isMouseClick) {
                        return 1;
                    } else {
                        return item.initialZoomLevel < 0.7 ? 1 : 1.5;
                    }
                }
            },
            /**
             * An object denoting the entire gallery, both the theater view and not
             */
            gallery: {
                _bg: null,
                _tempPanAreaSize: {x:0, y:0},
                _num_items: 0,
                currentItemIndex: 0,
                _prevItemIndex: 0,
                _itemsNeedUpdate: false,
                _items: [],
                
                /**The item with which we are currently dealing
                 * @type {Item}
                 */
                _currentItem: null,
                //The root DOM element of SmPhotoswipe
                /**
                 * @type HTMLElement
                 */
                container: null,
                /** The wrapper of each slide, hiding the overflow.
                 * @type HTMLElement
                 */
                scrollWrap: null,
                _getNumItems: function () {
                    //todo implement
                },
                //The theater view is currently open
                isOpen: false,
                //The theater view is currently being destroyed
                isDestroying: false,
                closedBy: null,
                panDist: new Point(),
                startPanOffset: new Point(),
                // Closes the gallery, then destroy it
                close: function () {
                    if (!app.gallery.isOpen) {
                        return;
                    }
                    app.gallery.isOpen = false;
                    app.gallery.isDestroying = true;
                    app._shout('close');
                    app._unbindEvents();
                    _showOrHide(app.gallery._currentItem, null, true, app.gallery.destroy);
                },
                // destroys gallery (unbinds events, cleans up intervals and timeouts to avoid memory leaks)
                destroy: function () {
                    app._shout('destroy');
                    if (_showOrHideTimeout) {
                        window.clearTimeout(_showOrHideTimeout);
                    }
                    if (app._config.modal) {
                        template.setAttribute('aria-hidden', 'true');
                        template.className = app._initalClassName;
                    }
                    if (app._updateSizeInterval) {
                        window.clearInterval(app._updateSizeInterval);
                    }
                    framework.unbind(app.gallery.scrollWrap, app._downEvents, self);
                    // we unbind lost event at the end, as closing animation may depend on it
                    framework.unbind(window, 'scroll', self);
                    _stopDragUpdateLoop();
                    _stopAllAnimations();
                    app._listeners = null;
                },
                /**
                 * Assuming we allow looping, get the id of the element that is before the first one or after the last one once we get there.
                 * @returns {*}
                 */
                _getLoopedId: function (index) {
                    var numSlides = this.gallery._getNumItems();
                    if (index > numSlides - 1) {
                        return index - numSlides;
                    } else if (index < 0) {
                        return numSlides + index;
                    }
                    return index;
                },
                //return an item found at a specified index
                _getItemAt: function (index) {
                    if (index >= 0) {
                        return app.gallery._items[index] !== undefined ? app.gallery._items[index] : false;
                    }
                    return false;
                },
                //go to a slide at a specified index
                goTo: function (index) {
                    index = app.gallery._getLoopedId(index);
                    var diff = index - app.gallery.currentItemIndex;
                    app._indexDiff = diff;
                    app.gallery.currentItemIndex = index;
                    app.gallery._currentItem = app.gallery._getItemAt(app.gallery.currentItemIndex);
                    app._currPositionIndex -= diff;
                    app._moveMainScroll(app._slideSize.x * app._currPositionIndex);
                    _stopAllAnimations();
                    app.event_list._mainScrollAnimating = false;
                    app.gallery.updateCurrItem();
                },
                next: function () {
                    this.goTo(app.gallery.currentItemIndex + 1);
                },
                prev: function () {
                    this.goTo(app.gallery.currentItemIndex - 1);
                },
                /**
                 * Set the current item and run functions based on that
                 * @param beforeAnimation
                 */
                updateCurrItem: function (beforeAnimation) {
                    //unless there is no difference in indices
                    if (app._indexDiff === 0) {
                        return;
                    }
                    var diffAbs = Math.abs(app._indexDiff), tempHolder;
                    if (beforeAnimation && diffAbs < 2) {
                        return;
                    }
                    app.gallery._currentItem = app.gallery._getItemAt(app.gallery.currentItemIndex);
                    app._shout('beforeChange', app._indexDiff);
                    if (diffAbs >= NUM_HOLDERS) {
                        app._containerShiftIndex += app._indexDiff + (app._indexDiff > 0 ? -NUM_HOLDERS : NUM_HOLDERS);
                        diffAbs = NUM_HOLDERS;
                    }
                    for (var i = 0; i < diffAbs; i++) {
                        if (app._indexDiff > 0) {
                            tempHolder = app.itemHolders.shift();
                            app.itemHolders[NUM_HOLDERS - 1] = tempHolder; // move first to last
                            app._containerShiftIndex++;
                            app._setTranslateX((app._containerShiftIndex + 2) * app._slideSize.x, tempHolder.el.style);
                            app.gallery.setContent(tempHolder, app.gallery.currentItemIndex - diffAbs + i + 1 + 1);
                        } else {
                            tempHolder = app.itemHolders.pop();
                            app.itemHolders.unshift(tempHolder); // move last to first
                            app._containerShiftIndex--;
                            app._setTranslateX(app._containerShiftIndex * app._slideSize.x, tempHolder.el.style);
                            app.gallery.setContent(tempHolder, app.gallery.currentItemIndex + diffAbs - i - 1 - 1);
                        }
                    }
                    // reset zoom/pan on previous item
                    if (app._currZoomElementStyle && Math.abs(app._indexDiff) === 1) {
                        var prevItem = app.gallery._getItemAt(app.gallery._prevItemIndex);
                        if (prevItem.initialZoomLevel !== app._currZoomLevel) {
                            prevItem._calculateItemSize(app._viewportSize);
                            app._applyZoomPanToItem(prevItem);
                        }
                    }
                    // reset diff after update
                    app._indexDiff = 0;
                    app.updateCurrZoomItem();
                    app.gallery._prevItemIndex = app.gallery.currentItemIndex;
                    app._shout('afterChange');
                },
                setContent : function(holder, index) {
                    if(app._config.canLoopThru) {
                        index = app.gallery._getLoopedId(index);
                    }
                    var prevItem = app.gallery._getItemAt(holder.index);
                    if(prevItem) {
                        prevItem.container = null;
                    }
                    var item = app.gallery._getItemAt(index),
                        img;
                    if(!item) {
                        holder.el.innerHTML = '';
                        return;
                    }
                    // allow to override data
                    app._shout('gettingData', index, item);
                    holder.index = index;
                    holder.item = item;
                    // base container DIV is created only once for each of 3 holders
                    var baseDiv = item.container = framework.createEl('pswp__zoom-wrap');
                    if(!item.src && item.html) {
                        if(item.html.tagName) {
                            baseDiv.appendChild(item.html);
                        } else {
                            baseDiv.innerHTML = item.html;
                        }
                    }
                    item.checkForError();
                    if(item.src && !item.loadError && !item.loaded) {
                        item.loadComplete = function(item) {
                            // gallery closed before image finished loading
                            if(!app.gallery.isOpen) {
                                return;
                            }
                            // Apply hw-acceleration only after image is loaded.
                            // This is webkit progressive image loading bugfix.
                            // https://bugs.webkit.org/show_bug.cgi?id=108630
                            // https://code.google.com/p/chromium/issues/detail?id=404547
                            item.img.style.webkitBackfaceVisibility = 'hidden';
                            // check if holder hasn't changed while image was loading
                            if(holder && holder.index === index ) {
                                if( item.checkForError(true) ) {
                                    item.loadComplete = item.img = null;
                                    item._calculateItemSize( app._viewportSize);
                                    app._applyZoomPanToItem(item);
                                    if(holder.index === app.gallery.currentItemIndex) {
                                        // recalculate dimensions
                                        app.updateCurrZoomItem();
                                    }
                                    return;
                                }
                                if( !item.imageAppended ) {
                                    if(framework.features.transform && (app.event_list._mainScrollAnimating || app.event_list._initialZoomRunning) ) {
                                        _imagesToAppendPool.push({
                                            item:item,
                                            baseDiv:baseDiv,
                                            img:item.img,
                                            index:index,
                                            holder:holder
                                        });
                                    } else {
                                        _appendImage(index, item, baseDiv, item.img, app.event_list._mainScrollAnimating || app.event_list._initialZoomRunning);
                                    }
                                } else {
                                    // remove preloader & mini-img
                                    if(!app.event_list._initialZoomRunning && item.placeholder) {
                                        item.placeholder.style.display = 'none';
                                        item.placeholder = null;
                                    }
                                }
                            }
                            item.loadComplete = null;
                            item.img = null; // no need to store image element after it's added
                            app._shout('imageLoadComplete', index, item);
                        };
                        if(framework.features.transform) {
                            var placeholderClassName = 'pswp__img pswp__img--placeholder';
                            placeholderClassName += (item.msrc ? '' : ' pswp__img--placeholder--blank');
                            var placeholder = framework.createEl(placeholderClassName, item.msrc ? 'img' : '');
                            if(item.msrc) {
                                placeholder.src = item.msrc;
                            }
                            placeholder.style.width = item.w + 'px';
                            placeholder.style.height = item.h + 'px';
                            baseDiv.appendChild(placeholder);
                            item.placeholder = placeholder;
                        }
                        if(!item.loading) {
                            _preloadImage(item);
                        }
                        if( self.allowProgressiveImg() ) {
                            // just append image
                            if(!_initialContentSet && framework.features.transform) {
                                _imagesToAppendPool.push({
                                    item:item,
                                    baseDiv:baseDiv,
                                    img:item.img,
                                    index:index,
                                    holder:holder
                                });
                            } else {
                                _appendImage(index, item, baseDiv, item.img, true, true);
                            }
                        }
                    } else if(item.src && !item.loadError) {
                        // image object is created every time, due to bugs of image loading & delay when switching images
                        img = framework.createEl('pswp__img', 'img');
                        img.style.webkitBackfaceVisibility = 'hidden';
                        img.style.opacity = 1;
                        img.src = item.src;
                        _appendImage(index, item, baseDiv, img, true);
                    }
                    item._calculateItemSize(app._viewportSize);
                    if(!_initialContentSet && index === app.gallery.currentItemIndex) {
                        app._currZoomElementStyle = baseDiv.style;
                        _showOrHide(item, (img ||item.img) );
                    } else {
                        app._applyZoomPanToItem(item);
                    }
                    holder.el.innerHTML = '';
                    holder.el.appendChild(baseDiv);
                },
            _showOrHide : function(item, img, out, completeFn) {
                if(_showOrHideTimeout) {
                    clearTimeout(_showOrHideTimeout);
                }
                app.event_list._initialZoomRunning = true;
                _initialContentSet = true;
                // dimensions of small thumbnail {x:,y:,w:}.
                // Height is optional, as calculated based on large image.
                var thumbBounds;
                if(item.initialLayout) {
                    thumbBounds = item.initialLayout;
                    item.initialLayout = null;
                } else {
                    thumbBounds = app._config.getThumbBoundsFn && app._config.getThumbBoundsFn(_currentItemIndex);
                }
                var duration = out ? app._config.hideAnimationDuration : app._config.showAnimationDuration;
                var onComplete = function() {
                    _stopAnimation('initialZoom');
                    if(!out) {
                        _applyBgOpacity(1);
                        if(img) {
                            img.style.display = 'block';
                        }
                        framework.addClass(template, 'pswp--animated-in');
                        _shout('initialZoom' + (out ? 'OutEnd' : 'InEnd'));
                    } else {
                        self.template.removeAttribute('style');
                        self.bg.removeAttribute('style');
                    }
                    if(completeFn) {
                        completeFn();
                    }
                    _initialZoomRunning = false;
                };
                // if bounds aren't provided, just open gallery without animation
                if(!duration || !thumbBounds || thumbBounds.x === undefined) {
                    var finishWithoutAnimation = function() {
                        _shout('initialZoom' + (out ? 'Out' : 'In') );
                        _currZoomLevel = item.initialZoomLevel;
                        _equalizePoints(_panOffset,  item.initialPosition );
                        _applyCurrentZoomPan();
                        // no transition
                        template.style.opacity = out ? 0 : 1;
                        _applyBgOpacity(1);
                        onComplete();
                    };
                    finishWithoutAnimation();
                    return;
                },
                startAnimation : function() {
                    var closeWithRaf = _closedByScroll,
                        fadeEverything = !self.currItem.src || self.currItem.loadError || app._config.showHideOpacity;
                    // apply hw-acceleration to image
                    if(item.miniImg) {
                        item.miniImg.style.webkitBackfaceVisibility = 'hidden';
                    }
                    if(!out) {
                        _currZoomLevel = thumbBounds.w / item.w;
                        _panOffset.x = thumbBounds.x;
                        _panOffset.y = thumbBounds.y - _initalWindowScrollY;
                        self[fadeEverything ? 'template' : '_bg'].style.opacity = 0.001;
                        _applyCurrentZoomPan();
                    }
                    _registerStartAnimation('initialZoom');
                    if(out && !closeWithRaf) {
                        framework.removeClass(template, 'pswp--animated-in');
                    }
                    if(fadeEverything) {
                        if(out) {
                            framework[ (closeWithRaf ? 'remove' : 'add') + 'Class' ](template, 'pswp--animate_opacity');
                        } else {
                            setTimeout(function() {
                                framework.addClass(template, 'pswp--animate_opacity');
                            }, 30);
                        }
                    }
                    _showOrHideTimeout = setTimeout(function() {
                        _shout('initialZoom' + (out ? 'Out' : 'In') );
                        if(!out) {
                            // "in" animation always uses CSS transitions (instead of rAF).
                            // CSS transition work faster here,
                            // as developer may also want to animate other things,
                            // like ui on top of sliding area, which can be animated just via CSS
                            _currZoomLevel = item.initialZoomLevel;
                            _equalizePoints(_panOffset,  item.initialPosition );
                            _applyCurrentZoomPan();
                            _applyBgOpacity(1);
                            if(fadeEverything) {
                                template.style.opacity = 1;
                            } else {
                                _applyBgOpacity(1);
                            }
                            _showOrHideTimeout = setTimeout(onComplete, duration + 20);
                        } else {
                            // "out" animation uses rAF only when PhotoSwipe is closed by browser scroll, to recalculate position
                            var destZoomLevel = thumbBounds.w / item.w,
                                initialPanOffset = {
                                    x: _panOffset.x,
                                    y: _panOffset.y
                                },
                                initialZoomLevel = _currZoomLevel,
                                scrollY = _initalWindowScrollY,
                                initalBgOpacity = _bgOpacity,
                                onUpdate = function(now) {
                                    if(_scrollChanged) {
                                        scrollY = framework.getScrollY();
                                        _scrollChanged = false;
                                    }
                                    if(now === 1) {
                                        _currZoomLevel = destZoomLevel;
                                        _panOffset.x = thumbBounds.x;
                                        _panOffset.y = thumbBounds.y  - scrollY;
                                    } else {
                                        _currZoomLevel = (destZoomLevel - initialZoomLevel) * now + initialZoomLevel;
                                        _panOffset.x = (thumbBounds.x - initialPanOffset.x) * now + initialPanOffset.x;
                                        _panOffset.y = (thumbBounds.y - scrollY - initialPanOffset.y) * now + initialPanOffset.y;
                                    }
                                    _applyCurrentZoomPan();
                                    if(fadeEverything) {
                                        template.style.opacity = 1 - now;
                                    } else {
                                        _applyBgOpacity( initalBgOpacity - now * initalBgOpacity );
                                    }
                                };
                            if(closeWithRaf) {
                                _animateProp('initialZoom', 0, 1, duration, framework.easing.cubic.out, onUpdate, onComplete);
                            } else {
                                onUpdate(1);
                                _showOrHideTimeout = setTimeout(onComplete, duration + 20);
                            }
                        }
                    }, out ? 25 : 90); // Main purpose of this delay is to give browser time to paint and
                    // create composite layers of PhotoSwipe UI parts (background, controls, caption, arrows).
                    // Which avoids lag at the beginning of scale transition.
                };
                startAnimation();
            }
            },
            /**
             * Add the public methods of a module in this code to the application. Made to add a level of extensibility to the plugin
             * @param name
             * @param module
             * @private
             */
            _registerModule: function (name, module) {
                framework.extend(app, module.publicMethods);
                app._modules.push(name);
            },
            _listeners: {},
            //todo figure
            _listen: function (name, fn) {
                if (!this._listeners[name]) {
                    this._listeners[name] = [];
                }
                return this._listeners[name].push(fn);
            },
            /**
             * run a given listener using the arguments provided by todo what?
             * @param name
             * @private
             */
            _shout: function (name) {
                var listeners = this._listeners[name];
                if (listeners) {
                    var args = Array.prototype.slice.call(arguments);
                    args.shift();
                    for (var i = 0; i < listeners.length; i++) {
                        listeners[i].apply(self, args);
                    }
                }
            },
            al: function (toAlert) {
                alert(toAlert);
            },
            //todo figure
            _applyBgOpacity: function (opacity) {
                app._config._bgOpacity = opacity;
                app._config._bg = opacity * app._config._bgOpacity;
            },
            /**
             * todo figure
             * @param styleObj
             * @param x
             * @param y
             * @param zoom
             */
            _applyZoomTransform: function (styleObj, x, y, zoom) {
                styleObj[app._transformKey] = app._translatePrefix + x + 'px, ' + y + 'px' + app._translateSuffix + ' scale(' + zoom + ')';
            },
            //todo figure
            _applyCurrentZoomPan: function () {
                if (app._currZoomElementStyle) {
                    app._applyZoomTransform(app._currZoomElementStyle, app._panOffset.x, app._panOffset.y, app._currZoomLevel);
                }
            },
            //todo figure ESPECIALLY container
            _applyZoomPanToItem: function (item) {
                if (item.container) {
                    app._applyZoomTransform(item.container.style,
                        item.initialPosition.x,
                        item.initialPosition.y,
                        item.initialZoomLevel);
                }
            },
            /**
             * todo figure
             * @param x
             * @param elStyle
             * @private
             */
            _setTranslateX: function (x, elStyle) {
                elStyle[app._transformKey] = app._translatePrefix + x + 'px, 0px' + app._translateSuffix;
            },
            /**
             * todo figure this out
             * @param x
             * @param dragging
             * @private
             */
            _moveMainScroll: function (x, dragging) {
                if (!app._config.canLoopThru && dragging) {
                    // if of current item during scroll (float)
                    var newSlideIndexOffset = app.gallery.currentItemIndex + (app._slideSize.x * app._currPositionIndex - x) / app._slideSize.x;
                    var delta = Math.round(x - app._mainScrollPos.x);
                    if ((newSlideIndexOffset < 0 && delta > 0) ||
                        (newSlideIndexOffset >= app.gallery._getNumItems() - 1 && delta < 0)) {
                        x = app._mainScrollPos.x + delta * app._config.mainScrollEndFriction;
                    }
                }
                app._mainScrollPos.x = x;
                app._setTranslateX(x, app._containerStyle);
            },
            /**
             * @todo figure this out!
             * @param axis
             * @param zoomLevel
             * @returns {number}
             * @private
             */
            _calculatePanOffset: function (axis, zoomLevel) {
                var m = app._midZoomPoint[axis] - app._offset[axis];
                return app._startPanOffset[axis] + app._currPanDist[axis] + m - m * ( zoomLevel / app._startZoomLevel );
            },
            /**
             * Check to see if the mouse event has been fired like a normal mouse would be
             * (twice in 100ms)(useful because some mobile browsers trigger it on touchstart).
             * Because methinks this function is bound to mousemove as a default,
             * unbind it once we know we are dealing with the proper mouse setting.
             * @todo change the 'pswp--has_mouse' thing to something stored in a js variable, not a css selector
             * @private
             */
            _onFirstMouseMove: function () {
                if (app._mouseMoveTimeout) {
                    framework.unbind(document, 'mousemove', app._onFirstMouseMove);
                    framework.addClass(template, 'pswp--has_mouse');
                    app._config.mouseUsed = true;
                    app._shout('mouseUsed');
                }
                app._mouseMoveTimeout = setTimeout(function () {
                    app._mouseMoveTimeout = null;
                }, 100);
            },
            /**
             * @todo figure |
             * speculation is that this is a function binding the self function to the keydown
             *    When a key is pressed, we check to see if it was something that would be relevant to our function
             * @todo rethink the 'self' being bound to the keydown. Check to see if there are any events that actually need this.
             * @private
             */
            _bindEvents: function () {
                framework.bind(document, 'keydown', self);
                if (framework.features.transform) {
                    // don't bind click event in browsers that don't support transform (mostly IE8)
                    framework.bind(app.gallery.scrollWrap, 'click', self);
                }
                if (!app._config.mouseUsed) {
                    framework.bind(document, 'mousemove', app._onFirstMouseMove);
                }
                framework.bind(window, 'resize scroll', self);
                app._shout('bindEvents');
            },
            /**
             * unbind the events related to this app
             * @private
             */
            _unbindEvents: function () {
                framework.unbind(window, 'resize', self);
                framework.unbind(window, 'scroll', app._globalEventHandlers.scroll);
                framework.unbind(document, 'keydown', self);
                framework.unbind(document, 'mousemove', app._onFirstMouseMove);
                if (framework.features.transform) {
                    framework.unbind(app.gallery.scrollWrap, 'click', self);
                }
                if (app._isDragging) {
                    framework.unbind(window, app._upMoveEvents, self);
                }
                app._shout('unbindEvents');
            },
            /**
             *
             * @param zoomLevel
             * @param update
             * @returns {*}
             * @private
             */
            _calculatePanBounds: function (zoomLevel, update) {
                var bounds = app.gallery._currentItem._calculateItemSize(app._viewportSize, zoomLevel);
                if (update) {
                    app._currPanBounds = bounds;
                }
                return bounds;
            },
            /**
             * This function has been replaced with the 'Item' class's getInitialZoomLevel method
             * @param item{Item} The item in question or nothing
             * @deprecated
             * @returns {Item.initialZoomLevel}
             * @private
             */
            _getMinZoomLevel: function (item) {
                if (!item) {
                    item = app.gallery._currentItem;
                }
                return item.getInitialZoomLevel;
            },
            _getMaxZoomLevel: function (item) {
                if (!item) {
                    item = app.gallery._currentItem;
                }
                //todo figure Item.width
                return item.width > 0 ? app._config.maxSpreadZoom : 1;
            },
            /**
             * State whether or not the given offset is outside of the given bounds
             * @param axis{string}  Axis in question (x or y)
             * @param destPanBounds{Bound} // todo
             * @param destPanOffset // the offset about which we are concerned
             * @param destZoomLevel // todo
             * @returns {boolean}
             * @private
             */
            _modifyDestPanOffset: function (axis, destPanBounds, destPanOffset, destZoomLevel) {
                if (destZoomLevel === app.gallery._currentItem.getInitialZoomLevel()) {
                    destPanOffset[axis] = app.gallery._currentItem.initialPosition[axis];
                    return true;
                } else {
                    destPanOffset[axis] = app._calculatePanOffset(axis, destZoomLevel);
                    if (destPanOffset[axis] > destPanBounds.min[axis]) {
                        destPanOffset[axis] = destPanBounds.min[axis];
                        return true;
                    } else if (destPanOffset[axis] < destPanBounds.max[axis]) {
                        destPanOffset[axis] = destPanBounds.max[axis];
                        return true;
                    }
                }
                return false;
            },
            _setupTransforms: function () {
                if (app._transformKey) {
                    // setup 3d transforms
                    var allow3dTransform = framework.features.perspective && !framework.features.touch;
                    app._translatePrefix = 'translate' + (allow3dTransform ? '3d(' : '(');
                    app._translateSuffix = framework.features.perspective ? ', 0px)' : ')';
                    return;
                }

                //From this point on, we assume that we are dealing with a browser that is more outdated than the default
                // and as such, we begin to override functions (setTranslateX, applyZoomPan
                // Override zoom/pan/move functions in case old browser is used (most likely IE)
                // (so they use left/top/width/height, instead of CSS transform)
                app._transformKey = 'left';
                framework.addClass(template, 'pswp--ie');
                app._setTranslateX = function (x, elStyle) {
                    elStyle.left = x + 'px';
                };
                //todo figure item.container as opposed to app.gallery.item
                //noinspection JSValidateJSDoc
                /**
                 *
                 * @param item{Item}
                 * @private
                 */
                app._applyZoomPanToItem = function (item) {
                    var style = item.container.style,
                        width = item.fitRatio * item.width,
                        height = item.fitRatio * item.height;

                    style.width = width + 'px';
                    style.height = height + 'px';
                    style.left = item.initialPosition.x + 'px';
                    style.top = item.initialPosition.y + 'px';
                };
                app._applyCurrentZoomPan = function () {
                    if (app._currZoomElementStyle) {
                        var style = app._currZoomElementStyle;
                        var item = app.gallery._currentItem;
                        var w = item.fitRatio * item.width;
                        var h = item.fitRatio * item.height;
                        style.width = w + 'px';
                        style.height = h + 'px';
                        style.left = app._panOffset.x + 'px';
                        style.top = app._panOffset.y + 'px';
                    }
                };
            },
            _onKeyDown: function (e) {
                var keydownAction = '';
                if (app._config.escKeyUsed && e.keyCode === 27) {
                    keydownAction = 'close';
                } else if (app._config.arrowKeysUsed) {
                    if (e.keyCode === 37) {
                        keydownAction = 'prev';
                    } else if (e.keyCode === 39) {
                        keydownAction = 'next';
                    }
                }
                if (keydownAction) {
                    // don't do anything if special key pressed to prevent from overriding default browser actions
                    // e.g. in Chrome on Mac cmd+arrow-left returns to previous page
                    if (!e.ctrlKey && !e.altKey && !e.shiftKey && !e.metaKey) {
                        if (e.preventDefault) {
                            e.preventDefault();
                        } else {
                            e.returnValue = false;
                        }
                        //run the action specified above if it exists ( close based on escape, prev based on <-, next based on ->)
                        app.gallery[keydownAction]();
                    }
                }
            },
            _onGlobalClick: function (e) {
                if (!e) {
                    return;
                }
                // don't allow click event to pass through when triggering after drag or some other gesture
                if (app.event_list._moved || app.event_list._zoomStarted || app.event_list._mainScrollAnimating || app.event_list._verticalDragInitiated) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            },
            _onPageScroll: function () {
                app.event_list._scrollChanged = true;
                // "close" on scroll works only on desktop devices, or when mouse is used
                if (!app._config.canCloseOnScroll) {
                    //todo unbind this event!
                    return
                }
                if (app.gallery.isOpen && (!framework.features.touch || app._config.mouseUsed)) {
                    // if scrolled for more than 2px
                    if (Math.abs(framework.getScrollY() - app._initialWindowScrollY) > 2) {
                        app.event_list._closedByScroll = true;
                        app.gallery.close();
                    }
                }
            },
            updateSize: function (force) {
                if (!app._isFixedPosition) {
                    var windowScrollY = framework.getScrollY();
                    if (app._currentWindowScrollY !== windowScrollY) {
                        template.style.top = windowScrollY + 'px';
                        app._currentWindowScrollY = windowScrollY;
                    }
                    if (!force && app._windowVisibleSize.x === window.innerWidth && app._windowVisibleSize.y === window.innerHeight) {
                        return;
                    }
                    app._windowVisibleSize.x = window.innerWidth;
                    app._windowVisibleSize.y = window.innerHeight;
                    //template.style.width = app._windowVisibleSize.x + 'px';
                    template.style.height = app._windowVisibleSize.y + 'px';
                }
                app._viewportSize.x = app.gallery.scrollWrap.clientWidth;
                app._viewportSize.y = app.gallery.scrollWrap.clientHeight;
                app.offset = {x: 0, y: app._currentWindowScrollY};//framework.getOffset(template);
                app._slideSize.x = app._viewportSize.x + Math.round(app._viewportSize.x * app._config.spacing);
                app._slideSize.y = app._viewportSize.y;
                app._moveMainScroll(app._slideSize.x * app._currPositionIndex);
                app._shout('beforeResize'); // even may be used for example to switch image sources ... ?
                // don't re-calculate size on initial size update
                if (app._containerShiftIndex !== undefined) {
                    // temporary holder at a given index
                    var tmp_holder;
                    /**
                     * The item in question
                     * @type Item
                     */
                    var item;
                    var tmp_holder_index;
                    for (var i = 0; i < NUM_HOLDERS; i++) {
                        tmp_holder = app.itemHolders[i];
                        app._setTranslateX((i + app._containerShiftIndex) * app._slideSize.x, tmp_holder.el.style);
                        tmp_holder_index = app.gallery._getLoopedId(app.gallery.currentItemIndex + i - 1);
                        // update zoom level on items and refresh source (if needsUpdate)
                        item = app.gallery._getItemAt(tmp_holder_index);
                        // re-render gallery item if `needsUpdate`,
                        // or doesn't have `bounds` (entirely new slide object)
                        if (app.gallery._itemsNeedUpdate || item.needsUpdate || !item.bounds) {
                            if (item) {
                                self.cleanSlide(item);
                            }
                            app.gallery.setContent(tmp_holder, tmp_holder_index);
                            // if "center" slide
                            if (i === 1) {
                                app.gallery._currentItem = item;
                                app.updateCurrZoomItem(true);
                            }
                            item.needsUpdate = false;
                        } else if (tmp_holder.index === -1 && tmp_holder_index >= 0) {
                            // add content first time
                            app.gallery.setContent(tmp_holder, tmp_holder_index);
                        }
                        if (item && item.container) {
                            item._calculateItemSize(app._viewportSize);
                            app._applyZoomPanToItem(item);
                        }
                    }
                    app.gallery._itemsNeedUpdate = false;
                }
                app._startZoomLevel = app._currZoomLevel = app.gallery._currentItem.initialZoomLevel;
                app._currPanBounds = app.gallery._currentItem.bounds;
                if (app._currPanBounds) {
                    app._panOffset.x = app._currPanBounds.center.x;
                    app._panOffset.y = app._currPanBounds.center.y;
                    app._applyCurrentZoomPan();
                }
                app._shout('resize');
            },
            zoomTo: function (destZoomLevel, centerPoint, speed, easingFn, updateFn) {
                /*
                 if(destZoomLevel === 'fit') {
                 destZoomLevel = app.gallery._currentItem.fitRatio;
                 } else if(destZoomLevel === 'fill') {
                 destZoomLevel = app.gallery._currentItem.fillRatio;
                 }
                 */
                if (centerPoint) {
                    app._startZoomLevel = app._currZoomLevel;
                    app._midZoomPoint.x = Math.abs(centerPoint.x) - app._panOffset.x;
                    app._midZoomPoint.y = Math.abs(centerPoint.y) - app._panOffset.y;
                    app._startPanOffset.setEqualTo(app._panOffset);
                }
                var destPanBounds = app._calculatePanBounds(destZoomLevel, false),
                    destPanOffset = {};
                app._modifyDestPanOffset('x', destPanBounds, destPanOffset, destZoomLevel);
                app._modifyDestPanOffset('y', destPanBounds, destPanOffset, destZoomLevel);
                var initialZoomLevel = app._currZoomLevel;
                var initialPanOffset = {
                    x: app._panOffset.x,
                    y: app._panOffset.y
                };
                destPanOffset.roundPoint();
                var onUpdate = function (now) {
                    if (now === 1) {
                        app._currZoomLevel = destZoomLevel;
                        app._panOffset.x = destPanOffset.x;
                        app._panOffset.y = destPanOffset.y;
                    } else {
                        app._currZoomLevel = (destZoomLevel - initialZoomLevel) * now + initialZoomLevel;
                        app._panOffset.x = (destPanOffset.x - initialPanOffset.x) * now + initialPanOffset.x;
                        app._panOffset.y = (destPanOffset.y - initialPanOffset.y) * now + initialPanOffset.y;
                    }
                    if (updateFn) {
                        updateFn(now);
                    }
                    _applyCurrentZoomPan();
                };
                if (speed) {
                    _animateProp('customZoomTo', 0, 1, speed, easingFn || framework.easing.sine.inOut, onUpdate);
                } else {
                    onUpdate(1);
                }
            },
            updateCurrZoomItem: function (emulateSetContent) {
                if (emulateSetContent) {
                    app._shout('beforeChange', 0);
                }
                // itemHolder[1] is middle (current) item
                if (app.itemHolders[1].el.children.length) {
                    var zoomElement = app.itemHolders[1].el.children[0];
                    if (framework.hasClass(zoomElement, 'pswp__zoom-wrap')) {
                        app._currZoomElementStyle = zoomElement.style;
                    } else {
                        app._currZoomElementStyle = null;
                    }
                } else {
                    app._currZoomElementStyle = null;
                }
                app._currPanBounds = app.gallery._currentItem.bounds;
                app._startZoomLevel = app._currZoomLevel = app.gallery._currentItem.initialZoomLevel;
                app._panOffset.x = app._currPanBounds.center.x;
                app._panOffset.y = app._currPanBounds.center.y;
                if (emulateSetContent) {
                    app._shout('afterChange');
                }
            }
        };
        //Allow the default configuration options to be changed by a config array
        framework.extend(app._config, options, false);

        //These are the variables and functions meant to be made directly accessible to the user. Some repeat privates for convenience
        var publicMethods = {
            // make a few local variables and functions public
            shout: app._shout,
            listen: app._listen,
            viewportSize: app._viewportSize,
            options: app._config,
            isMainScrollAnimating: function () {
                return app.event_list._mainScrollAnimating;
            },
            getZoomLevel: function () {
                return app._currZoomLevel;
            },
            getCurrentIndex: function () {
                return app.gallery.currentItemIndex;
            },
            isDragging: function () {
                return app.event_list._isDragging;
            },
            isZooming: function () {
                return app.event_list._isZooming;
            },
            applyZoomPan: function (zoomLevel, panX, panY) {
                app._panOffset.x = panX;
                app._panOffset.y = panY;
                app._currZoomLevel = zoomLevel;
                app._applyCurrentZoomPan();
            },
            init: function () {
                if (app.gallery.isOpen || app.gallery.isDestroying) {
                    return;
                }
                var i;
                self.template = template; // root DOM element of PhotoSwipe
                self.bg = framework.getChildByClass(template, 'pswp__bg');
                //Keep track of what the classname was so we can reset it at the end
                app._initalClassName = template.className;
                app.gallery.isOpen = true;
                framework.features = framework.detectFeatures();
                // I don't see the point of this and I do not like it
                app._requestAF = framework.features.raf;
                app._cancelAF = framework.features.caf;
                app._transformKey = framework.features.transform;
                app.gallery.scrollWrap = framework.getChildByClass(template, 'pswp__scroll-wrap');
                app.gallery.container = framework.getChildByClass(app.gallery.scrollWrap, 'pswp__container');
                app.containerStyle = app.gallery.container.style; // for fast access
                // Objects that hold slides (there are only 3 in DOM)
                app.itemHolders = [
                    {el: app.gallery.container.children[0], wrap: 0, index: -1},
                    {el: app.gallery.container.children[1], wrap: 0, index: -1},
                    {el: app.gallery.container.children[2], wrap: 0, index: -1}
                ];
                // hide nearby item holders until initial zoom animation finishes (to avoid extra Paints)
                app.itemHolders[0].el.style.display = app.itemHolders[2].el.style.display = 'none';
                app._setupTransforms();
                // Setup global events
                app._globalEventHandlers = {
                    resize: app.updateSize,
                    scroll: app._onPageScroll,
                    keydown: app._onKeyDown,
                    click: app._onGlobalClick
                };
                // disable show/hide effects on old browsers that don't support CSS animations or transforms,
                // old IOS, Android and Opera mobile. Blackberry seems to work fine, even older models.
                var oldPhone = framework.features.isOldIOSPhone || framework.features.isOldAndroid || framework.features.isMobileOpera;
                if (!framework.features.animationName || !framework.features.transform || oldPhone) {
                    //If the user client doesn't support animationName or transform (or if the user is using an old phone)
                    //Don't use the AnimationDuration for showing and revealing applications
                    app._config.showAnimationDuration = app._config.hideAnimationDuration = 0;
                }
                //run the Init function for each of the extensibility modules
                //todo figure out how extensibility will work
                for (i = 0; i < app._modules.length; i++) {
                    self['init' + app._modules[i]]();
                }
                // init

                if (UiClass) {
                    //todo todo todo!
                    var ui = self.ui = new UiClass(self, framework);
                    ui.init();
                }
                //todo figure out what firstUpdate is
                app._shout('firstUpdate');
                //todo figure out where else the current item at index could be set to make it not already 0
                app.gallery.currentItemIndex = app.gallery.currentItemIndex || app._config.index || 0;
                // validate index
                //if the current item index is not a positive number less than or equal to the number of elements, make it 0
                if (isNaN(app.gallery.currentItemIndex) || app.gallery.currentItemIndex < 0 || app.gallery.currentItemIndex >= app.gallery._getNumItems()) {
                    app.gallery.currentItemIndex = 0;
                }
                app.gallery._currentItem = app.gallery._getItemAt(app.gallery.currentItemIndex);

                if (oldPhone) {
                    app._isFixedPosition = false;
                }
                //todo figure modal
                if (app._config.modal) {
                    //todo rename selector
                    template.setAttribute('aria-hidden', 'false');
                    if (!app._isFixedPosition) {
                        template.style.position = 'absolute';
                        template.style.top = framework.getScrollY() + 'px';
                    } else {
                        template.style.position = 'fixed';
                    }
                }
                if (typeof (app._currentWindowScrollY) == 'undefined') {
                    //todo figure currentWindowScrollY
                    app._shout('initialLayout');
                    app._currentWindowScrollY = app._config._initialWindowScrollY = framework.getScrollY();
                }
                // add classes to root element of PhotoSwipe based on whatever is available.
                // I believe using css selectors is a rather inelegant solution
                var rootClasses = 'pswp--open ';
                if (app._config.showHideOpacity) {
                    rootClasses += 'pswp--animate_opacity ';
                }
                rootClasses += framework.features.touch ? 'pswp--touch' : 'pswp--notouch';
                rootClasses += framework.features.animationName ? ' pswp--css_animation' : '';
                rootClasses += framework.features.svg ? ' pswp--svg' : '';
                framework.addClass(template, rootClasses);
                //todo move this function
                app.updateSize();
                // initial update
                app._containerShiftIndex = -1;
                app._indexDiff = null;
                for (i = 0; i < NUM_HOLDERS; i++) {
                    app._setTranslateX((i + app._containerShiftIndex) * app._slideSize.x, app.itemHolders[i].el.style);
                }
                if (!framework.features.oldIE) {
                    framework.bind(app.gallery.scrollWrap, app._downEvents, self); // no dragging for old IE
                }
                app._listen('initialZoomInEnd', function () {
                    app.gallery.setContent(app.itemHolders[0], app.gallery.currentItemIndex - 1);
                    app.gallery.setContent(app.itemHolders[2], app.gallery.currentItemIndex + 1);
                    app.itemHolders[0].el.style.display = app.itemHolders[2].el.style.display = 'block';
                    if (app._config.focus) {
                        // focus causes layout,
                        // which causes lag during the animation,
                        // that's why we delay it until the initial zoom transition ends
                        template.focus();
                    }
                    app._bindEvents();
                });
                // set content for center slide (first time)
                app.gallery.setContent(app.itemHolders[1], app.gallery.currentItemIndex);
                app.gallery.updateCurrItem();
                app._shout('afterInit');
                if (!app._isFixedPosition) {
                    // On all versions of iOS lower than 8.0, we check size of viewport every second.
                    //
                    // This is done to detect when Safari top & bottom bars appear,
                    // as this action doesn't trigger any events (like resize). This problem was fixed in ios8
                    app._updateSizeInterval = setInterval(function () {
                        if (!app.event_list._numAnimations && !app.event_list._isDragging && !app.event_list._isZooming && (app._currZoomLevel === app.gallery._currentItem.initialZoomLevel)) {
                            app.updateSize();
                        }
                    }, 1000);
                }
                framework.addClass(template, 'pswp--visible');
            },
            /**
             * Pan image to position
             * @param {Number} x
             * @param {Number} y
             * @param {Boolean} force Will ignore bounds if set to true.
             */
            panTo: function (x, y, force) {
                if (!force) {
                    if (x > app._currPanBounds.min.x) {
                        x = app._currPanBounds.min.x;
                    } else if (x < app._currPanBounds.max.x) {
                        x = app._currPanBounds.max.x;
                    }
                    if (y > app._currPanBounds.min.y) {
                        y = app._currPanBounds.min.y;
                    } else if (y < app._currPanBounds.max.y) {
                        y = app._currPanBounds.max.y;
                    }
                }
                app._panOffset.x = x;
                app._panOffset.y = y;
                _applyCurrentZoomPan();
            },
            handleEvent: function (e) {
                e = e || window.event;
                if (app._globalEventHandlers[e.type]) {
                    app._globalEventHandlers[e.type](e);
                }
            },
            // update current zoom/pan objects
            invalidateCurrItems: function () {
                app.gallery._itemsNeedUpdate = true;
                for (var i = 0; i < NUM_HOLDERS; i++) {
                    if (app.itemHolders[i].item) {
                        app.itemHolders[i].item.needsUpdate = true;
                    }
                }
            }
            //Zoom current item to
        };

        self.SmPhotoswipe = app;
    };
    return SmPhotoswipeFunction;

});