window.ST = window.ST || {};

(function( exports, $ ){
    var api = {}, ctor, inherits,
        slice = Array.prototype.slice;

    // Shared empty constructor function to aid in prototype-chain creation.
    ctor = function() {};

    /**
     * Helper function to correctly set up the prototype chain, for subclasses.
     * Similar to `goog.inherits`, but uses a hash of prototype properties and
     * class properties to be extended.
     *
     * @param  object parent      Parent class constructor to inherit from.
     * @param  object protoProps  Properties to apply to the prototype for use as class instance properties.
     * @param  object staticProps Properties to apply directly to the class constructor.
     * @return child              The subclassed constructor.
     */
    inherits = function( parent, protoProps, staticProps ) {
        var child;

        // The constructor function for the new subclass is either defined by you
        // (the "constructor" property in your `extend` definition), or defaulted
        // by us to simply call `super()`.
        if ( protoProps && protoProps.hasOwnProperty( 'constructor' ) ) {
            child = protoProps.constructor;
        } else {
            child = function() {
                // Storing the result `super()` before returning the value
                // prevents a bug in Opera where, if the constructor returns
                // a function, Opera will reject the return value in favor of
                // the original object. This causes all sorts of trouble.
                var result = parent.apply( this, arguments );
                return result;
            };
        }

        // Inherit class (static) properties from parent.
        $.extend( child, parent );

        // Set the prototype chain to inherit from `parent`, without calling
        // `parent`'s constructor function.
        ctor.prototype  = parent.prototype;
        child.prototype = new ctor();

        // Add prototype properties (instance properties) to the subclass,
        // if supplied.
        if ( protoProps )
            $.extend( child.prototype, protoProps );

        // Add static properties to the constructor function, if supplied.
        if ( staticProps )
            $.extend( child, staticProps );

        // Correctly set child's `prototype.constructor`.
        child.prototype.constructor = child;

        // Set a convenience property in case the parent's prototype is needed later.
        child.__super__ = parent.prototype;

        return child;
    };

    /**
     * Base class for object inheritance.
     */
    api.Class = function( applicator, argsArray, options ) {
        var magic, args = arguments;

        if ( applicator && argsArray && api.Class.applicator === applicator ) {
            args = argsArray;
            $.extend( this, options || {} );
        }

        magic = this;

        /*
         * If the class has a method called "instance",
         * the return value from the class' constructor will be a function that
         * calls the "instance" method.
         *
         * It is also an object that has properties and methods inside it.
         */
        if ( this.instance ) {
            magic = function() {
                return magic.instance.apply( magic, arguments );
            };

            $.extend( magic, this );
        }

        magic.initialize.apply( magic, args );
        return magic;
    };

    /**
     * Creates a subclass of the class.
     *
     * @param  object protoProps  Properties to apply to the prototype.
     * @param  object staticProps Properties to apply directly to the class.
     * @return child              The subclass.
     */
    api.Class.extend = function( protoProps, classProps ) {
        var child = inherits( this, protoProps, classProps );
        child.extend = this.extend;
        return child;
    };

    api.Class.applicator = {};

    /**
     * Initialize a class instance.
     *
     * Override this function in a subclass as needed.
     */
    api.Class.prototype.initialize = function() {};

    /*
     * Checks whether a given instance extended a constructor.
     *
     * The magic surrounding the instance parameter causes the instanceof
     * keyword to return inaccurate results; it defaults to the function's
     * prototype instead of the constructor chain. Hence this function.
     */
    api.Class.prototype.extended = function( constructor ) {
        var proto = this;

        while ( typeof proto.constructor !== 'undefined' ) {
            if ( proto.constructor === constructor )
                return true;
            if ( typeof proto.constructor.__super__ === 'undefined' )
                return false;
            proto = proto.constructor.__super__;
        }
        return false;
    };

    /**
     * An events manager object, offering the ability to bind to and trigger events.
     *
     * Used as a mixin.
     */
    api.Events = {
        trigger: function( id ) {
            if ( this.topics && this.topics[ id ] )
                this.topics[ id ].fireWith( this, slice.call( arguments, 1 ) );
            return this;
        },

        bind: function( id ) {
            this.topics = this.topics || {};
            this.topics[ id ] = this.topics[ id ] || $.Callbacks();
            this.topics[ id ].add.apply( this.topics[ id ], slice.call( arguments, 1 ) );
            return this;
        },

        unbind: function( id ) {
            if ( this.topics && this.topics[ id ] )
                this.topics[ id ].remove.apply( this.topics[ id ], slice.call( arguments, 1 ) );
            return this;
        }
    };

    /**
     * Cast a string to a jQuery collection if it isn't already.
     *
     * @param {string|jQuery collection} element
     */
    api.ensure = function( element ) {
        return typeof element == 'string' ? $( element ) : element;
    };

    exports.LightSlider = api;
})( ST, jQuery );


(function (exports, globalParams, $) {
    'use strict';

    var api = window.ST.LightSlider;

    api.Option = api.Class.extend({
        initialize: function(element, defaultValue) {
            var option = this;

            option.element = api.ensure(element);
            option.id = option.element.data('optionId');

            option.ready();

            if (defaultValue) {
                option.set(defaultValue);
            }
        },
        ready: function () {
            var option = this;

            // Bind event for built-in inputs
            var type = option.element.data('optionType'),

                builtInTypes = ['input', 'select', 'textarea'];
            if (builtInTypes.indexOf(type) > -1) {
                var events = 'change';

                if ('textarea' == type) {
                    events += ' keyup';
                }

                option.control().bind(events, function () {
                    var value;

                    if (option.control().is('[type="checkbox"]')) {
                        value = true == option.control().prop('checked') ? 'yes' : 'no';
                    } else {
                        value = option.control().val();
                    }

                    option.triggerChange(value);
                });
            }
        },
        control: function () {
            var inputSelector = 'input, select, textarea';

            return this.element.is(inputSelector) ? this.element : this.find(inputSelector);
        },
        get: function () {
            if (this.control().is('[type="checkbox"]')) {
                return this.control().prop('checked') ? 'yes' : 'no';
            } else {
                return this.control().val();
            }
        },
        set: function (value) {
            if (this.control().is('[type="checkbox"]')) {
                this.control().prop('checked', 'yes' === value ? true : false);
            } else {
                this.control().val(value);
            }
        },
        find: function (selector) {
            return this.element.find(selector);
        },
        triggerChange: function (value) {
            this.trigger('change', {
                id: this.id,
                value: value
            });
        }
    });

    $.extend( api.Option.prototype, api.Events );

    api.ColorOption = api.Option.extend({
        ready: function () {
            var option = this;

            this.control().wpColorPicker({
                change: function(evt, picker) {
                    if (option.noTrigger) {
                        option.noTrigger = false;
                    } else {
                        option.triggerChange(picker.color.toString());
                    }
                },
                clear: function() {
                    option.triggerChange('');
                }

            });
        },
        set: function (value) {
            this.noTrigger = true;
            this.control()
                .val(value)
                .wpColorPicker('color', value);
        }
    });

    api.ImageOption = api.Option.extend({
        ready: function () {
            var self = this;

            self.control().on('change', function () {
                self.triggerChange(self.control().val());
            });

            self.find('.option-btn-change-image').on('click', function (evt) {
                evt.preventDefault();

                self.openFrame();
            });

            self.find('.option-btn-clear-image').on('click', function (evt) {
                evt.preventDefault();

                self.control()
                    .val('')
                    .trigger('change');
            });
        },
        openFrame: function () {
            var self = this;

            if (!self.frame) {
                self.frame = wp.media({
                    title: globalParams.i18n_choose_image,
                    library: {
                        type: 'image'
                    },
                    multiple: false,
                    button: {
                        text: globalParams.i18n_choose
                    }
                });

                self.frame.on('select', $.proxy(self.select, self));
            }

            self.frame.open();
        },
        select: function () {
            var selectedImage = this.frame.state().get('selection').first().toJSON();

            if (selectedImage.url) {
                this.control()
                    .val(selectedImage.url)
                    .trigger('change');
            }
        }
    });

    api.OptionContainer = api.Class.extend({
        initialize: function (element, options) {
            this.element = api.ensure(element);
            this.initializeOptions(options);

            this.ready();
        },
        ready: function () {},
        initializeOptions: function (options) {
            var self = this;

            self.options = options;
            self.optionControls = {};

            this.element.find('[data-option-id]').each(function () {
                var $optionEl = $(this),
                    optionId = $optionEl.data('optionId'),
                    optionType = $optionEl.data('optionType');

                switch (optionType) {
                    case 'color':
                        self.optionControls[optionId] = new api.ColorOption($optionEl, self.getOption(optionId, options));

                        break;
                    case 'image':
                        self.optionControls[optionId] = new api.ImageOption($optionEl, self.getOption(optionId, options));

                        break;
                    default:
                        self.optionControls[optionId] = new api.Option($optionEl, self.getOption(optionId, options));

                        break;
                }

                self.optionControls[optionId].bind('change', function (obj) {
                    self.triggerOptionChange(obj);
                });
            });
        },
        getOption: function (id, options) {
            var propParts = id.split('.');

            var obj = options,
                value = null;
            $.each(propParts, function (index, prop) {
                if ($.isPlainObject(obj[prop])) {
                    obj = obj[prop];
                } else {
                    value = obj[prop];
                }
            });

            return value;
        },
        rebindData: function (data) {
            var self = this;

            $.each(self.optionControls, function (optionId, optionControl) {
                optionControl.set(self.getOption(optionId, data));
            });
        },
        triggerOptionChange: function (obj) {
            this.trigger('optionChanged', obj);
        }
    });

    $.extend( api.OptionContainer.prototype, api.Events );

    api.Slider = api.OptionContainer.extend({});

    api.SlideList = api.Class.extend({
        initialize: function (element, slides) {
            var self = this;

            self.element = api.ensure(element);
            self.slides  = slides;

            self.slideListEl = self.element.find('.sls-slides-list');
            self.slideTemplate = wp.template('slide-item');

            // Show Slide
            $.each(self.slides, function (index, slide) {
                if (slide) {
                    self.showSlide(slide);
                }
            });

            // Bind event for button add image slide
            self.element.find('.sls-btn-add-image-slide').on('click', function (evt) {
                evt.preventDefault();

                self.showImageChooser();
            });

            // Init jQuery UI Sortable
            self.element.find('.sls-slides-list').sortable({
                distance: 10,
                placeholder: "ui-state-highlight",
                update: $.proxy(self.updateSlideOrder, self)
            });

            self.element.on('click', '.sls-slide-item', function (evt) {
                evt.preventDefault();

                self.chooseSlide($(this).data('slideIndex'));
            });

            // Init events for slide
            self.element.on('click', '.sls-slide-toggle-visibility', function (evt) {
                evt.preventDefault();
                evt.stopPropagation();

                var $slideItem = $(this).closest('.sls-slide-item'),
                    slideIndex = $slideItem.data('slideIndex');

                self.slides[slideIndex]['status'] = 'private' == self.slides[slideIndex]['status'] ? 'publish' : 'private';

                $slideItem.toggleClass('private', self.slides[slideIndex]['status'] == 'private');
            });

            self.element.on('click', '.sls-slide-duplicate', function (evt) {
                evt.preventDefault();
                evt.stopPropagation();

                var $slideItem = $(this).closest('.sls-slide-item'),
                    slideIndex = $slideItem.data('slideIndex'),
                    slide = self.slides[slideIndex],
                    newSlide;

                newSlide = $.extend(true, {}, slide);

                self.slides.push(newSlide);
                self.showSlide(newSlide);

                self.chooseSlide(self.slides.length - 1);
            });

            self.element.on('click', '.sls-slide-remove', function (evt) {
                evt.preventDefault();
                evt.stopPropagation();

                if (!confirm(globalParams.i18n_confirm_delete_slide)) {
                    return false;
                }

                var $slideItem = $(this).closest('.sls-slide-item'),
                    slideIndex = $slideItem.data('slideIndex'),
                    slide = self.slides[slideIndex];

                delete self.slides[slideIndex];
                $slideItem.remove();

                self.trigger('slideDeleted');
            });
        },
        chooseSlide: function (index) {
            var self = this;

            self.element.find('.active').removeClass('active');
            self.element.find('[data-slide-index="'+ index +'"]').addClass('active');

            this.trigger('currentSlideChanged', self.slides[index]);
        },
        showImageChooser: function () {
            var self = this;

            if (!self.frame) {
                self.frame = wp.media({
                    title: globalParams.i18n_choose_background_image,
                    library: {
                        type: 'image'
                    },
                    multiple: true,
                    button: {
                        text: globalParams.i18n_choose
                    }
                });

                self.frame.on('select', $.proxy(self.addSlide, self));
            }

            self.frame.open();
        },
        addSlide: function () {
            var selection = this.frame.state().get('selection');

             if (!selection) {
                return;
             }

             var self = this,
                 firstNewSlideIndex = null;

             selection.each(function (attachment) {
                 var slide = $.extend(true, {}, slsData.theme_data.slide, {
                     params: {
                         background_image: attachment.attributes.url
                     }
                 });

                 self.slides.push(slide);

                 if (firstNewSlideIndex === null) {
                     firstNewSlideIndex = self.slides.length - 1;
                 }

                 self.showSlide(slide);
             });

            if (firstNewSlideIndex !== null) {
                self.chooseSlide(firstNewSlideIndex);
            }
        },
        showSlide: function (slide, slideIndex) {
            var self = this;

            var data = {
                slideIndex: slideIndex || self.slides.indexOf(slide),
                slide: slide
            };

            self.slideListEl.append(self.slideTemplate(data));
        },
        updateSlideOrder: function () {
            var self = this;

            self.element.find('.sls-slide-item').each(function (index) {
                var $slideItem = $(this),
                    slideIndex = $slideItem.data('slideIndex');

                self.slides[slideIndex]['sort'] = index;
            });
        }
    });

    $.extend( api.SlideList.prototype, api.Events );

    api.Slide = api.OptionContainer.extend({
        ready: function () {
            var self = this;

            self.bind('currentSlideChanged', function () {
                self.rebindData(self.options);
            });
        }
    });

    api.LayerList = api.OptionContainer.extend({
        ready: function () {
            var self = this;

            self.bind('currentSlideChanged', function () {
                self.rebindData(self.options);
            });
        }
    });

    api.SlidePreview = api.Class.extend({
        initialize: function (element, data) {
            var self = this;

            self.data    = data;
            self.element = api.ensure(element);

            self.slideTemplate = wp.template('slide-preview');

            self.initEvents();

            self.updateSliderUI();
        },
        initEvents: function () {
            var self = this;

            self.bind('currentSlideChanged', $.proxy(self.changeCurrentSlide, self));
            self.bind('optionChanged', $.proxy(self.updateUI, self));
            self.bind('sliderOptionChanged', $.proxy(self.updateSliderUI, self));
        },
        changeCurrentSlide: function () {
            var self = this;

            self.element.html(self.slideTemplate());

            self.updateSliderUI();
            self.updateUI();
        },
        updateSliderUI: function () {
            var self = this,
                $slider = self.element.find('.sls-slider');

            $slider.css({
                width: self.data.slider.params.width,
                height: self.data.slider.params.height,
                'background-image': "url('" + self.data.slider.params.background_image + "')",
                'background-color': self.data.slider.params.background_color
            });
        },
        updateUI: function () {
            var self = this,
                $slide = self.element.find('.sls-slider .sls-slide'),
                classAttr = $slide.attr('class');

            classAttr = classAttr || '';

            $slide.css({
                'background-image': "url('" + self.data.currentSlide.params.background_image + "')",
                'background-color': self.data.currentSlide.params.background_color
            });

            if ( typeof self.data.currentSlide.params.layout !== 'undefined' ) {
                $slide.attr('class', classAttr.replace(/sls-layout-[\w-0-9]+/gi, ''))
                    .addClass(self.data.currentSlide.params.layout);
            }

            $.each(self.data.currentSlide.layers, function (layerId, layer) {
                var $layerEl = $('[data-layer-id="'+ layerId +'"]', self.element);

                $layerEl
                    .attr('class', $layerEl.data('class'))
                    .addClass(layer.style);

                switch (layer.type) {
                    case 'caption':
                        $layerEl.html(layer.content);

                        break;
                    case 'image':
                        $layerEl.attr('src', layer.url);

                        break;
                    case 'button':
                        $layerEl
                            .attr('href', layer.url)
                            .html(layer.content);

                        break;
                }
            });
        }
    });

    $.extend( api.SlidePreview.prototype, api.Events );

    api.SliderPage = api.Class.extend({
        initialize: function (data) {
            var self = this;

            self.data = data;

            self.slider       = new api.Slider('#slider-settings', self.data);
            self.slideList    = new api.SlideList('#sls-slide-list', self.data.slides);
            self.slide        = new api.Slide('#sls-slide-option-container', self.data);
            self.layerList    = new api.LayerList('#sls-layer-list', self.data);
            self.slidePreview = new api.SlidePreview('.sls-slide-preview', self.data);

            self.$slideEditorContainer = $('#sls-slide-editor-container');

            self.initEvents();
        },
        initEvents: function () {
            var self = this;

            self.slider.bind('optionChanged', function (obj) {
                self.set(obj.id, obj.value);

                self.slidePreview.trigger('sliderOptionChanged');
            });

            self.slide.bind('optionChanged', function (obj) {
                self.set(obj.id, obj.value);

                self.slidePreview.trigger('optionChanged');
            });

            self.layerList.bind('optionChanged', function (obj) {
                self.set(obj.id, obj.value);

                self.slidePreview.trigger('optionChanged');
            });

            self.slideList.bind('currentSlideChanged', function (currentSlide) {
                self.data.currentSlide = currentSlide;

                self.slide.trigger('currentSlideChanged', currentSlide);
                self.layerList.trigger('currentSlideChanged', currentSlide);

                self.slidePreview.trigger('currentSlideChanged', currentSlide);

                self.showSlideEditorContainer();
            });

            self.slideList.bind('slideDeleted', $.proxy(self.hideSlideEditorContainer, self));
        },
        set: function (propChain, value) {
            var propParts = propChain.split('.');

            var obj = this.data,
                lastProp;
            $.each(propParts, function (index, prop) {
                if (index < propParts.length - 1 && typeof obj[prop] == 'undefined') {
                    obj[prop] = {};
                }

                if (index < propParts.length - 1) {
                    obj = obj[prop];
                } else {
                    lastProp = prop;
                }
            });

            obj[lastProp] = value;
        },
        showSlideEditorContainer: function () {
            this.$slideEditorContainer.show();
        },
        hideSlideEditorContainer: function () {
            this.$slideEditorContainer.hide();
        }
    });

    // Init slider page when document ready
    $(function () {
        var sliderPage = new api.SliderPage(slsData);

        $('.sls-tab-container').tabslet({
            active: 2
        });

        $('.button-save-slider').on('click', function (evt) {
            evt.preventDefault();

            var $btn = $(this);

            $btn.prop('disabled', true)
                .next()
                .addClass('is-active');

            $.ajax({
                url: sls_admin_params.ajax_url,
                method: 'post',
                data: {
                    action: 'sls_save_slider',
                    nonce: globalParams.nonce,
                    slider: sliderPage.data.slider,
                    slides: sliderPage.data.slides
                },
                success: function (response) {
                    if (response.data.redirect) {
                        window.location = response.data.redirect;
                    }

                    $btn.prop('disabled', false)
                        .next()
                        .removeClass('is-active');
                }
            })
        });

        $('.button-preview-slider').on('click', function (evt) {
            evt.preventDefault();

            $('#sls-dialog-preview-slider').dialog({
                autoOpen: true,
                width: '90%',
                height: 600,
                modal: true
            });

            var $form = $('#sls-form-preview-slider');

            $form.empty();

            $('<input type="hidden" name="slider" />')
                .val(JSON.stringify(sliderPage.data.slider))
                .appendTo($form);

            $('<input type="hidden" name="slides" />')
                .val(JSON.stringify(sliderPage.data.slides))
                .appendTo($form);

            $('<input type="hidden" name="theme" />')
                .val(sliderPage.data.slider.theme)
                .appendTo($form);

            var startSlide = sliderPage.data.slides.indexOf(sliderPage.data.currentSlide);

            startSlide = startSlide > -1 ? startSlide + 1 : 1;

            $('<input type="hidden" name="start_slide" />')
                .val(startSlide)
                .appendTo($form);

            $form[0].submit();
        });

        $('.sls-slider-action-container').followTo();

        exports.sliderPage = sliderPage;
    });

    $.fn.followTo = function () {
        var $this = this,
            $window = $(window);

        $window.scroll(function(e){
            if ($window.scrollTop() > $('.sls-slider-action-placeholder').offset().top - $window.height()) {
                $this.css({
                    position: 'static',
                    width: '100%',
                    'box-shadow': 'none'
                });
            } else {
                $this.css({
                    position: 'fixed',
                    bottom: 0,
                    width: $('.sls-tab-container').width(),
                    'box-shadow': '0px -2px 5px 0px rgba(51, 51, 51, 0.25)'
                });
            }
        });
    };
})(ST, sls_slider_params, jQuery);