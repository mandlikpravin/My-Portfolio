"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
(function ($, w) {
  "use strict";

  var $window = $(w);
  w.happyParallaxEffects = function (element, settings) {
    var self = this,
      $el = $(element),
      scrolls = $el.data("scrolls"),
      elementSettings = settings,
      elType = elementSettings.elType,
      elOffset = $el.offset();

    //Check if Horizontal Scroll Widget
    var isHScrollWidget = $el.closest(".premium-hscroll-temp").length;
    self.elementRules = {};
    self.init = function () {
      if (scrolls || 'SECTION' === elType) {
        if (!elementSettings.effects.length) {
          return;
        }
        self.setDefaults();
        elementorFrontend.elements.$window.on('scroll load', self.initScroll);
      } else {
        elementorFrontend.elements.$window.off('scroll load', self.initScroll);
        return;
      }
    };
    self.setDefaults = function () {
      elementSettings.defaults = {};
      elementSettings.defaults.axis = 'y';
    };
    self.initScroll = function () {
      if (elementSettings.effects.includes('translateY')) {
        self.initVScroll();
      }
      if (elementSettings.effects.includes('translateX')) {
        self.initHScroll();
      }
    };
    self.initVScroll = function () {
      var percents = self.getPercents();

      // console.log( percents );
      // console.log( elementSettings.vscroll );
      /* elementSettings.vscroll => in this object {
      		speed: 4,
      		direction: 'down',
      		range: {
      			start: 0,
      			end: 100
      		}
      }*/

      self.transform('translateY', percents, elementSettings.vscroll);
    };
    self.initHScroll = function () {
      var percents = self.getPercents();
      self.transform('translateX', percents, elementSettings.hscroll);
    };
    self.transform = function (translate, percents, data) {
      /*
      	translate or action = 'translateY' or 'translateX' or 'rotate'
      	data = speed: 4, direction: 'down', range: { start: 0, end: 100 }
       */

      // data = {speed: 4, direction: 'down', range: { start: 98, end: 100 }};
      // console.log( data );

      if ("down" === data.direction) {
        percents = 100 - percents;
      }

      // console.log("percents = >", percents);

      if (data.range) {
        if (data.range.start > percents && !isHScrollWidget) {
          // if percents is less than start
          percents = data.range.start;
        }
        if (data.range.end < percents && !isHScrollWidget) {
          // if percents is greater than end
          percents = data.range.end;
        }
      }
      if ('rotate' === translate) {
        elementSettings.defaults.unit = 'deg';
      } else {
        elementSettings.defaults.unit = 'px';
      }

      // console.log("change percents = >", percents);

      // var getStep = ( -(percents - 50) * data.speed );

      // console.log("translate value = >", getStep);
      // console.log( '===============================' );

      self.updateElement('transform', translate, self.getStep(percents, data) + elementSettings.defaults.unit);
      // self.updateElement( 'transform', translate, getStep + elementSettings.defaults.unit );
    };
    self.getPercents = function () {
      var dimensions = self.getDimensions(); // this function returns elements ofset top and left. element height, element width and range (element height + window height)

      var startOffset = innerHeight; // innerHeight is window.innerHeight, actually window height

      if (isHScrollWidget) startOffset = 0; // this is not aplicable bcz horizontal scroll widget not exists

      // pageYOffset is window.pageYOffset, pageYOffset is the number of pixels the document has already been scrolled vertically.
      // elemntTopWindowPoint is the element's top position from the document top minus the number of pixels the document has already been scrolled vertically.
      var elementTopWindowPoint = dimensions.elementTop - pageYOffset;
      var elementEntrancePoint = elementTopWindowPoint - startOffset;
      // var elementEntrancePoint = elementTopWindowPoint - innerHeight;

      // console.log(elementTopWindowPoint);
      // console.log(elementEntrancePoint);
      // console.log('==========================');

      // dimensions.range is elements height plus window height
      var passedRangePercents = 100 / dimensions.range * (elementEntrancePoint * -1);
      // console.log('element Top Window Point =>', elementTopWindowPoint);
      // console.log('element Entrance Point =>', elementEntrancePoint);
      // console.log('passedRangePercents =>', passedRangePercents);

      return passedRangePercents;
    };
    self.getDimensions = function () {
      // this function used in getPercents function only.
      // this function returns elements ofset top and left. element height, element width and range (element height + window height)
      var elementOffset = $el.offset(); // elements top and left position from the document top and left

      var dimensions = {
        elementHeight: $el.outerHeight(),
        // elements height
        elementWidth: $el.outerWidth(),
        // elements width
        elementTop: elementOffset.top,
        // elements top position from the document top
        elementLeft: elementOffset.left // elements left position from the document left
      };

      // innerHeight is window.innerHeight
      dimensions.range = dimensions.elementHeight + innerHeight; // elements height plus window height

      return dimensions;
    };
    self.getStep = function (percents, options) {
      return -(percents - 50) * options.speed;
    };

    // self.getEffectMovePoint = function (percents, effect, range) { // this function is not used in the code.

    //     var point = 0;

    //     if (percents < range.start) {
    //         if ("down" === effect) {
    //             point = 0;
    //         } else {
    //             point = 100;
    //         }
    //     } else if (percents < range.end) {

    //         point = self.getPointFromPercents( (range.end - range.start), (percents - range.start) );

    //         if ("up" === effect) {
    //             point = 100 - point;
    //         }

    //     } else if ("up" === effect) {
    //         point = 0;
    //     } else if ("down" === effect) {
    //         point = 100;
    //     }

    //     return point;

    // };

    // self.getEffectValueFromMovePoint = function (level, movePoint) { // this function is not used in the code.

    //     return level * movePoint / 100;

    // };

    // self.getPointFromPercents = function (movableRange, percents) {

    //     var movePoint = percents / movableRange * 100;

    //     return +movePoint.toFixed(2); // toFixed returns string, argument is number, it means how many digits after decimal point will be returned

    // };

    self.updateElement = function (transform, key, value) {
      // transform is reffer css transform
      // key is reffer css transform key like translateX, translateY, rotate, scale etc.
      // value is the value of the css transform key like 50px, 100px, 30deg etc.

      if (!self.elementRules[transform]) {
        self.elementRules[transform] = {};
      }
      if (!self.elementRules[transform][key]) {
        self.elementRules[transform][key] = true;
        self.updateElementRule(transform); // this function fire only once when the dom is loaded
      }
      var cssVarKey = '--' + key;
      // console.log("value=>", value);

      element.style.setProperty(cssVarKey, value);
    };
    self.updateElementRule = function (rule) {
      // console.log('updateElementRule', rule);

      var cssValue = '';
      $.each(self.elementRules[rule], function (variableKey) {
        cssValue += variableKey + '(var(--' + variableKey + '))';
      });
      $el.css(rule, cssValue);
    };
    self.isInViewport = function () {
      var elementTop = $el.offset().top;
      var elementBottom = elementTop + $el.outerHeight();
      var windowTop = $(window).scrollTop();
      var windowBottom = windowTop + $(window).height();

      // Check if element is in viewport
      var isInViewport = elementBottom > windowTop && elementTop < windowBottom;
      return isInViewport;
    };
  };
  var ParallaxController = /*#__PURE__*/function () {
    function ParallaxController(targetElement, configuration) {
      _classCallCheck(this, ParallaxController);
      this.targetElement = targetElement;
      this.$element = $(targetElement);
      this.scrollConfiguration = this.$element.data("scrolls");
      this.settings = configuration;
      this.elementType = configuration.elType;
      this.initialOffset = this.$element.offset();

      // Check if element is within horizontal scroll widget
      this.isInsideHorizontalScrollWidget = this.$element.closest(".premium-hscroll-temp").length > 0;
      this.transformRules = {};
      this.defaultSettings = {
        axis: 'y',
        unit: 'px'
      };
      this.initialize();
    }
    return _createClass(ParallaxController, [{
      key: "initialize",
      value: function initialize() {
        if (!this.scrollConfiguration && this.settings.elType !== 'SECTION') {
          this.destroyScrollListeners();
          return;
        }
        if (!this.settings.effects || !this.settings.effects.length) {
          return;
        }
        this.setupDefaultConfiguration();
        this.attachScrollListeners();
      }
    }, {
      key: "setupDefaultConfiguration",
      value: function setupDefaultConfiguration() {
        this.settings.defaults = _objectSpread({}, this.defaultSettings);
      }
    }, {
      key: "attachScrollListeners",
      value: function attachScrollListeners() {
        var $window = elementorFrontend.elements.$window;
        $window.on('scroll load', this.handleScrollEvent.bind(this));
      }
    }, {
      key: "destroyScrollListeners",
      value: function destroyScrollListeners() {
        var $window = elementorFrontend.elements.$window;
        $window.off('scroll load', this.handleScrollEvent);
      }
    }, {
      key: "handleScrollEvent",
      value: function handleScrollEvent() {
        if (this.settings.effects.includes('translateY')) {
          this.processVerticalScroll();
        }
        if (this.settings.effects.includes('translateX')) {
          this.processHorizontalScroll();
        }
      }
    }, {
      key: "processVerticalScroll",
      value: function processVerticalScroll() {
        var scrollPercentage = this.calculateScrollPercentage();
        this.applyTransformation('translateY', scrollPercentage, this.settings.vscroll);
      }
    }, {
      key: "processHorizontalScroll",
      value: function processHorizontalScroll() {
        var scrollPercentage = this.calculateScrollPercentage();
        this.applyTransformation('translateX', scrollPercentage, this.settings.hscroll);
      }
    }, {
      key: "calculateScrollPercentage",
      value: function calculateScrollPercentage() {
        var dimensions = this.getElementDimensions();
        var viewportHeight = window.innerHeight;
        var startOffset = this.isInsideHorizontalScrollWidget ? 0 : viewportHeight;
        var elementTopRelativeToViewport = dimensions.elementTop - window.pageYOffset;
        var elementEntrancePoint = elementTopRelativeToViewport - startOffset;
        var scrollPercentage = 100 / dimensions.scrollRange * (elementEntrancePoint * -1);
        return scrollPercentage;
      }
    }, {
      key: "getElementDimensions",
      value: function getElementDimensions() {
        var elementOffset = this.$element.offset();
        var dimensions = {
          elementHeight: this.$element.outerHeight(),
          elementWidth: this.$element.outerWidth(),
          elementTop: elementOffset.top,
          elementLeft: elementOffset.left
        };
        dimensions.scrollRange = dimensions.elementHeight + window.innerHeight;
        return dimensions;
      }
    }, {
      key: "applyTransformation",
      value: function applyTransformation(transformAction, percentage, transformData) {
        var adjustedPercentage = percentage;

        // Reverse percentage for downward direction
        if (transformData.direction === "down") {
          adjustedPercentage = 100 - percentage;
        }

        // Apply range constraints
        if (transformData.range && !this.isInsideHorizontalScrollWidget) {
          adjustedPercentage = this.constrainPercentageToRange(adjustedPercentage, transformData.range);
        }

        // Set appropriate unit based on transform type
        var unit = transformAction === 'rotate' ? 'deg' : 'px';
        // const unit = 'deg';

        var transformValue = this.calculateTransformValue(adjustedPercentage, transformData);
        this.updateElementTransform('transform', transformAction, transformValue + unit);
        // this.updateElementTransform('transform', 'rotate', transformValue + unit);
      }
    }, {
      key: "constrainPercentageToRange",
      value: function constrainPercentageToRange(percentage, range) {
        // console.log(range);
        // console.log(percentage);

        if (range.start > percentage) {
          return range.start;
        }
        if (range.end < percentage) {
          return range.end;
        }
        return percentage;
      }
    }, {
      key: "calculateTransformValue",
      value: function calculateTransformValue(percentage, transformOptions) {
        return -(percentage - 50) * transformOptions.speed;
      }
    }, {
      key: "calculateEffectMovePoint",
      value: function calculateEffectMovePoint(percentage, effectDirection, range) {
        var movePoint = 0;
        if (percentage < range.start) {
          movePoint = effectDirection === "down" ? 0 : 100;
        } else if (percentage < range.end) {
          movePoint = this.convertPercentageToPoint(range.end - range.start, percentage - range.start);
          if (effectDirection === "up") {
            movePoint = 100 - movePoint;
          }
        } else {
          movePoint = effectDirection === "up" ? 0 : 100;
        }
        return movePoint;
      }
    }, {
      key: "calculateEffectValueFromMovePoint",
      value: function calculateEffectValueFromMovePoint(level, movePoint) {
        return level * movePoint / 100;
      }
    }, {
      key: "convertPercentageToPoint",
      value: function convertPercentageToPoint(movableRange, percentage) {
        var movePoint = percentage / movableRange * 100;
        return +movePoint.toFixed(2);
      }
    }, {
      key: "updateElementTransform",
      value: function updateElementTransform(propertyName, transformKey, value) {
        if (!this.transformRules[propertyName]) {
          this.transformRules[propertyName] = {};
        }
        if (!this.transformRules[propertyName][transformKey]) {
          this.transformRules[propertyName][transformKey] = true;
          this.updateElementCSSRule(propertyName);
        }
        var cssVariableName = '--' + transformKey;
        this.targetElement.style.setProperty(cssVariableName, value);
      }
    }, {
      key: "updateElementCSSRule",
      value: function updateElementCSSRule(cssProperty) {
        var cssValue = '';
        Object.keys(this.transformRules[cssProperty]).forEach(function (variableKey) {
          cssValue += "".concat(variableKey, "(var(--").concat(variableKey, "))");
        });
        this.$element.css(cssProperty, cssValue);
      }
    }]);
  }();
  $window.on("elementor/frontend/init", function () {
    // Factory function to maintain compatibility with existing code
    var ParallaxEffects = function ParallaxEffects(element, settings) {
      return new ParallaxController(element, settings);
    };
    var MultiLayerParallaxHandler = function MultiLayerParallaxHandler($scope) {
      if (!$scope.hasClass("ha-multi-layer-parallax--yes")) return;
      var target = $scope,
        widget_id = target.data("id"),
        editor_target = target.find('#ha-multi-layer-parallax--' + widget_id),
        editMode = elementorFrontend.isEditMode() && editor_target.length > 0,
        target_dom = editMode ? editor_target : target;
      var layerSettings = target_dom.data("ha-multi-layer-parallax");
      // console.log( target );
      // console.log( layerSettings );

      if (!layerSettings && 0 == Object.keys(layerSettings).length && !layerSettings["items"]) {
        return false;
      }
      var currentDevice = elementorFrontend.getCurrentDeviceMode();
      generateMultiLayers(currentDevice);
      if (false && editMode) {
        var layerSettings = {
            repeater: 'ha_multi_layer_parallax_list',
            item: '.ha-multi-layer-parallax',
            hor: 'ha_multi_layer_parallax_hor_pos',
            ver: 'ha_multi_layer_parallax_ver_pos',
            width: 'ha_multi_layer_parallax_width',
            tab: 'section_premium_parallax',
            offset: 0,
            widgets: ["drag", "resize"]
          },
          instance = null;
        instance = new premiumEditorBehavior(target, layerSettings); // this class is diclared in premium-addon.js [ path= C:\laragon\www\happy-test\wp-content\plugins\premium-addons-pro\assets\frontend\js\premium-addons.js]
        instance.init();
      }
      function generateMultiLayers(currentDevice) {
        var mouseParallax = "",
          deviceSuffix = 'desktop' === currentDevice ? '' : '_' + currentDevice,
          mouseRate = "";
        target.find(".ha-multi-layer-parallax").remove();
        $.each(layerSettings.items, function (index, layout) {
          if (!layout.show_layer_on.includes(currentDevice)) {
            return;
          }

          // var layerHTML = getLayerHTML(layout);
          var layerHTML = '',
            imgID = '' != layout.ha_multi_layer_parallax_id ? 'id="' + layout.ha_multi_layer_parallax_id + '"' : '';
          if ('img' === layout.layer_type && null !== layout["ha_multi_layer_parallax_image"]["url"] && "" !== layout["ha_multi_layer_parallax_image"]["url"]) {
            var backgroundImage = layout["ha_multi_layer_parallax_image"]["url"],
              alt = layout['alt'];
            layerHTML = '<img ' + imgID + ' class="ha-multi-layer-parallax-img" src="' + backgroundImage + '" alt="' + alt + '">';
          }
          if ('' == layerHTML) {
            return;
          }
          var layerID = 'ha-multi-layer-parallax-' + layout._id,
            layerPosition = ' ha-multi-layer-parallax-' + layout.ha_multi_layer_parallax_hor + ' ha-multi-layer-parallax-' + layout.ha_multi_layer_parallax_ver,
            layerType = ' ha-multi-layer-parallax-' + layout.layer_type;

          // if ("yes" === layout.ha_multi_layer_parallax_mouse && "" !== layout.ha_multi_layer_parallax_rate) {
          if ("mouse_track" === layout.ha_multi_layer_parallax_effect_type && "" !== layout.ha_multi_layer_parallax_rate) {
            mouseParallax = ' data-parallax="true" ';
            mouseRate = ' data-rate="' + layout.ha_multi_layer_parallax_rate + '" ';
          } else {
            mouseParallax = ' data-parallax="false" ';
          }
          if ('img' === layout.layer_type) {
            var width = 'undefined' != typeof layout["ha_multi_layer_parallax_width" + deviceSuffix] ? layout["ha_multi_layer_parallax_width" + deviceSuffix].size : layout["ha_multi_layer_parallax_width"].size;
          }
          $('<div id="' + layerID + '"' + mouseParallax + mouseRate + ' class="ha-multi-layer-parallax elementor-repeater-item-' + layout._id + layerPosition + layerType + '">' + layerHTML + '</div>').prependTo(target).css({
            "z-index": layout["ha_multi_layer_parallax_z_index"],
            "background-size": layout["ha_multi_layer_parallax_back_size"],
            "width": 'img' === layout.layer_type ? width + "%" : "auto"
          });
          var $layer = target.find('#' + layerID);
          if ('custom' === layout.ha_multi_layer_parallax_hor) {
            var left = 'undefined' != typeof layout["ha_multi_layer_parallax_hor_pos" + deviceSuffix] ? layout["ha_multi_layer_parallax_hor_pos" + deviceSuffix].size : layout["ha_multi_layer_parallax_hor_pos"].size;
            $layer.css('left', left + '%');
          }
          if ('custom' === layout.ha_multi_layer_parallax_ver) {
            var top = 'undefined' != typeof layout["ha_multi_layer_parallax_ver_pos" + deviceSuffix] ? layout["ha_multi_layer_parallax_ver_pos" + deviceSuffix].size : layout["ha_multi_layer_parallax_ver_pos"].size;
            $layer.css('top', top + '%');
          }

          // if ( layerSettings.devices.includes(currentDevice) && 'yes' === layout['ha_multi_layer_parallax_scroll'] ) {
          if (layerSettings.devices.includes(currentDevice) && 'scroll_parallax' === layout['ha_multi_layer_parallax_effect_type']) {
            if ('yes' === layout['ha_multi_layer_parallax_scroll_hor']) {
              $layer.attr({
                'data-parallax-scroll': 'yes',
                'data-parallax-hscroll': 'yes',
                'data-parallax-hscroll_speed': layout['ha_multi_layer_parallax_speed_hor']['size'],
                'data-parallax-hscroll_start': layout['ha_multi_layer_parallax_view_hor']['sizes']['start'],
                'data-parallax-hscroll_end': layout['ha_multi_layer_parallax_view_hor']['sizes']['end'],
                'data-parallax-hscroll_direction': layout['ha_multi_layer_parallax_direction_hor']
              });
            }
            if ('yes' === layout['ha_multi_layer_parallax_scroll_ver']) {
              $layer.attr({
                'data-parallax-scroll': 'yes',
                'data-parallax-vscroll': 'yes',
                'data-parallax-speed': layout['ha_multi_layer_parallax_speed']['size'],
                'data-parallax-start': layout['ha_multi_layer_parallax_view']['sizes']['start'],
                'data-parallax-end': layout['ha_multi_layer_parallax_view']['sizes']['end'],
                // 'data-parallax-end': 200,
                'data-parallax-direction': layout['ha_multi_layer_parallax_direction']
              });
            }
          }
        });

        // target.imagesLoaded().done(function () {
        //     target.trigger("paParallaxLoaded");
        // });

        // window.PremiumSvgDrawerHandler(target, $, layerSettings.speed);

        if (-1 !== layerSettings.devices.indexOf(currentDevice)) {
          target.find('.ha-multi-layer-parallax').each(function (index, layer) {
            var data = $(layer).data();

            // console.group('happy-parallax-layer');
            // console.log( $(layer) );
            // console.log( data );
            // console.groupEnd();

            if ('yes' === data.parallaxScroll) {
              var effects = [],
                vScrollSettings = {},
                hScrollSettings = {},
                settings = {};
              if ('yes' === data.parallaxVscroll) {
                effects.push('translateY');
                vScrollSettings = {
                  speed: data.parallaxSpeed,
                  direction: data.parallaxDirection,
                  range: {
                    start: data.parallaxStart,
                    end: data.parallaxEnd
                  }
                };
              }
              if ('yes' === data.parallaxHscroll) {
                effects.push('translateX');
                hScrollSettings = {
                  speed: data.parallaxHscroll_speed,
                  direction: data.parallaxHscroll_direction,
                  range: {
                    start: data.parallaxHscroll_start,
                    end: data.parallaxHscroll_end
                  }
                };
              }
              settings = {
                elType: 'SECTION',
                vscroll: vScrollSettings,
                hscroll: hScrollSettings,
                effects: effects
              }, instance = null;

              // instance = new premiumParallaxEffects(layer, settings);
              instance = new happyParallaxEffects(layer, settings);
              instance.init();

              // instance = ParallaxEffects(layer, settings);
              // instance.initialize();
            }
          });
        }
        target.mousemove(function (e) {
          $(this).find('.ha-multi-layer-parallax[data-parallax="true"]').each(function () {
            var $this = $(this),
              resistance = $(this).data("rate");
            TweenLite.to($this, 0.2, {
              x: -((e.clientX - window.innerWidth / 2) / resistance),
              y: -((e.clientY - window.innerHeight / 2) / resistance)
            });
          });
        });
        function getLayerHTML(layer) {
          var html = '',
            imgID = '' != layer.ha_multi_layer_parallax_id ? 'id="' + layer.ha_multi_layer_parallax_id + '"' : '';
          if ('img' === layer.layer_type) {
            if (null !== layer["ha_multi_layer_parallax_image"]["url"] && "" !== layer["ha_multi_layer_parallax_image"]["url"]) {
              var backgroundImage = layer["ha_multi_layer_parallax_image"]["url"],
                alt = layer['alt'];
              html = '<img ' + imgID + ' class="ha-multi-layer-parallax-img" src="' + backgroundImage + '" alt="' + alt + '">';
            }
          } else {

            // var attributes = imgID + ' class="' + ("yes" === layer.draw_svg ? "premium-svg-drawer" : "premium-svg-nodraw") + '"';

            // if ("yes" === layer.draw_svg) {
            //     attributes += 'data-svg-reverse="' + layer.svg_reverse + '"';
            //     attributes += 'data-svg-loop="' + layer.svg_loop + '"';
            //     attributes += 'data-svg-sync="' + layer.svg_sync + '"';
            //     attributes += 'data-svg-hover="' + layer.svg_hover + '"';
            //     attributes += 'data-svg-restart="' + layer.restart_draw + '"';
            //     attributes += 'data-svg-fill="' + layer.svg_color + '"';
            //     attributes += 'data-svg-stroke="' + layer.svg_stroke + '"';
            //     attributes += 'data-svg-frames="' + layer.frames + '"';
            //     attributes += 'data-svg-yoyo="' + layer.svg_yoyo + '"';
            //     attributes += 'data-svg-point="' + (layer.svg_reverse ? layer.end_point.size : layer.start_point.size) + '"';
            // }

            // html = '<div ' + attributes + '>' + layer.ha_multi_layer_parallax_svg + '</div>';
          }
          return html;
        }
      }
    };
    elementorFrontend.hooks.addAction("frontend/element_ready/section", MultiLayerParallaxHandler);
    elementorFrontend.hooks.addAction("frontend/element_ready/container", MultiLayerParallaxHandler);
  });
})(jQuery, window);