/*!
 * Animation v1.1
 * Copyright (c) 2014 TemPlaza
 * support@templaza.com
 * License http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 * http://www.templaza.com/
 */

(function($) { "use strict";

  var dataanimation = {
    fadein: 'fade-in',
    fadeout: 'fade-out',
    slidedownfromtop: 'slide-down-from-top',
    slideinfromright: 'slide-in-from-right',
    slideupfrombottom: 'slide-up-from-bottom',
    slideinfromleft: 'slide-in-from-left',
    scaleup: 'scale-up',
    scaledown: 'scale-down',
    rotate: 'rotate',
    flipyaxis: 'flip-y-axis',
    flipxaxis: 'flip-x-axis'
  };

  var cssEase = {
    'ease': 'ease',
    'in': 'ease-in',
    'out': 'ease-out',
    'in-out': 'ease-in-out',
    'snap': 'cubic-bezier(0,1,.5,1)',
    // Penner equations
    'easeOutCubic': 'cubic-bezier(.215,.61,.355,1)',
    'easeInOutCubic': 'cubic-bezier(.645,.045,.355,1)',
    'easeInCirc': 'cubic-bezier(.6,.04,.98,.335)',
    'easeOutCirc': 'cubic-bezier(.075,.82,.165,1)',
    'easeInOutCirc': 'cubic-bezier(.785,.135,.15,.86)',
    'easeInExpo': 'cubic-bezier(.95,.05,.795,.035)',
    'easeOutExpo': 'cubic-bezier(.19,1,.22,1)',
    'easeInOutExpo': 'cubic-bezier(1,0,0,1)',
    'easeInQuad': 'cubic-bezier(.55,.085,.68,.53)',
    'easeOutQuad': 'cubic-bezier(.25,.46,.45,.94)',
    'easeInOutQuad': 'cubic-bezier(.455,.03,.515,.955)',
    'easeInQuart': 'cubic-bezier(.895,.03,.685,.22)',
    'easeOutQuart': 'cubic-bezier(.165,.84,.44,1)',
    'easeInOutQuart': 'cubic-bezier(.77,0,.175,1)',
    'easeInQuint': 'cubic-bezier(.755,.05,.855,.06)',
    'easeOutQuint': 'cubic-bezier(.23,1,.32,1)',
    'easeInOutQuint': 'cubic-bezier(.86,0,.07,1)',
    'easeInSine': 'cubic-bezier(.47,0,.745,.715)',
    'easeOutSine': 'cubic-bezier(.39,.575,.565,1)',
    'easeInOutSine': 'cubic-bezier(.445,.05,.55,.95)',
    'easeInBack': 'cubic-bezier(.6,-.28,.735,.045)',
    'easeOutBack': 'cubic-bezier(.175, .885,.32,1.275)',
    'easeInOutBack': 'cubic-bezier(.68,-.55,.265,1.55)'
  };

//GLOBAL TRANSITION VARIABLES
  var opacityZero = {
    'opacity': '0',
    '-ms-opacity': '0',
    '-webkit-opacity': '0',
    '-moz-opacity': '0',
    '-o-opacity': '0'
  };
  var opacityFull = {
    'opacity': '1',
    '-ms-opacity': '1',
    '-webkit-opacity': '1',
    '-moz-opacity': '1',
    '-o-opacity': '1'
  };

// DEFAULT ATTRIBUTES FOR ELEMENTS BASED ON ANIMATION TYPE
  $(document).ready(function() {
    $('html, body').css('overflow-x', 'hidden');
	$('.plazart-animate').css({'position': 'relative'});
    $('.plazart-animate').each(function() {
      var dataanimationUser = $(this).data('animation');

      if (dataanimationUser == dataanimation.fadein) {
        $(this).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.fadeout) {
        $(this).css(opacityFull);
      }

      if (dataanimationUser == dataanimation.slideinfromright) {
        $(this).css({'right': '-400px'}).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.slideinfromleft) {
        $(this).css({'left': '-400px'}).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.slideupfrombottom) {
        $(this).css({'bottom': '-200px'}).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.slidedownfromtop) {
        $(this).css({'top': '-200px'}).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.rotate) {
        $(this).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.scaleup) {
        var datastartscale = 0;
        var startScale = {
          'transform': 'scale(' + datastartscale + ')',
          '-ms-transform': 'scale(' + datastartscale + ')',
          '-webkit-transform': 'scale(' + datastartscale + ')',
          '-moz-transform': 'scale(' + datastartscale + ')',
          '-o-transform': 'scale(' + datastartscale + ')'
        };
        $(this).css(startScale).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.scaledown) {
        var datastartscale2 = 2;
        var startScale2 = {
          'transform': 'scale(' + datastartscale2 + ')',
          '-ms-transform': 'scale(' + datastartscale2 + ')',
          '-webkit-transform': 'scale(' + datastartscale2 + ')',
          '-moz-transform': 'scale(' + datastartscale2 + ')',
          '-o-transform': 'scale(' + datastartscale2 + ')'
        };
        $(this).css(startScale2).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.flipyaxis) {
        var flipY = {
          'transform': 'rotateY(180deg)',
          '-ms-transform': 'rotateY(180deg)',
          '-webkit-transform': 'rotateY(180deg)',
          '-moz-transform': 'rotateY(180deg)',
          '-o-transform': 'rotateY(180deg)'
        };
        $(this).css(flipY).css(opacityZero);
      }

      if (dataanimationUser == dataanimation.flipxaxis) {
        var flipX = {
          'transform': 'rotateX(180deg)',
          '-ms-transform': 'rotateX(180deg)',
          '-webkit-transform': 'rotateX(180deg)',
          '-moz-transform': 'rotateX(180deg)',
          '-o-transform': 'rotateX(180deg)'
        };
        $(this).css(flipX).css(opacityZero);
      }
    });
  });

  // ONSCROLL ANIMATION OF ELEMENTS
  $(window).on('scroll load', function() {
    $('.plazart-animate').each(function() {
      // GET ANIMATION TYPE FROM ELEMENT
      var dataanimationUser = $(this).data('animation');

      // CALCULATES THE TRIGGER POINT USING THE OFFSET
      var dataoffset = $(this).data('offset');
      var parsePercent = parseFloat(dataoffset);
      var decimal = parsePercent / 100;
      var triggerpoint = $(window).height() * decimal + $(window).scrollTop(); // Call point in Viewport: viewport height * decimal(%) + pixels to top of window
      var element = $(this).offset().top;

//        if (dataanimationUser == 'fade-in') {
//            alert('Window Height: '+$(window).height()+'\nDocument height: '+ $(document).height()+'\nData offset: '+ dataoffset+'\nparse Percent: '+ parsePercent+'\nscrollTop: '+ $(window).scrollTop()+'\ndecimal: '+ decimal+'\nelement: '+ element);
//        }

      if (dataanimationUser == dataanimation.slidedownfromtop) {
        element = element + 200;
      }

      if (dataanimationUser == dataanimation.slideupfrombottom) {
        element = element - 200;
      }

      if (dataanimationUser == dataanimation.scaleup) {
        element = element - $(this).height() / 2;
      }

      if (dataanimationUser == dataanimation.scaledown) {
        element = element + $(this).height() / 2;
      }

      // ASSIGNS VALUES FOR THE EASING TYPES
      var dataeasing = $(this).data('easing');
      if (cssEase[dataeasing]) {
        dataeasing = cssEase[dataeasing];
      }

      // TRANSITION OPTIONS ARE CREATED
      var datadelay = $(this).data('delay');
      var dataspeed = $(this).data('speed');
      var transitionOptions = {
        'transition-duration': dataspeed + 'ms',
        '-ms-transition-duration': dataspeed + 'ms',
        '-webkit-transition-duration': dataspeed + 'ms',
        '-moz-transition-duration': dataspeed + 'ms',
        '-o-transition-duration': dataspeed + 'ms',
        'transition-timing-function': dataeasing,
        '-ms-transition-timing-function': dataeasing,
        '-webkit-transition-timing-function': dataeasing,
        '-moz-transition-timing-function': dataeasing,
        '-o-transition-timing-function': dataeasing,
        'transition-delay': datadelay + 'ms',
        '-ms-transition-delay': datadelay + 'ms',
        '-webkit-transition-delay': datadelay + 'ms',
        '-moz-transition-delay': datadelay + 'ms',
        '-o-transition-delay': datadelay + 'ms'
      };

      // TRIGGERS THE ANIMATIONS
      if ((element < triggerpoint) || ($(window).scrollTop() + $(window).height() == $(document).height())) {
        // FADE IN
        if (dataanimationUser == dataanimation.fadein) {
          $(this).css(opacityFull).css(transitionOptions);
        }

        // FADE OUT
        if (dataanimationUser == dataanimation.fadeout) {
          $(this).css(opacityZero).css(transitionOptions);
        }

        // SLIDE DOWN FROM TOP
        if (dataanimationUser == dataanimation.slidedownfromtop) {
          $(this).css({'top': '0'}).css(opacityFull).css(transitionOptions);
        }

        // SLIDE UP FROM BOTTOM
        if (dataanimationUser == dataanimation.slideupfrombottom) {
          $(this).css({'bottom': '0'}).css(opacityFull).css(transitionOptions);
        }

        // SLIDE IN FROM RIGHT
        if (dataanimationUser == dataanimation.slideinfromright) {
          $(this).css({'right': '0'}).css(opacityFull).css(transitionOptions);
        }

        // SLIDE IN FROM LEFT
        if (dataanimationUser == dataanimation.slideinfromleft) {
          $(this).css({'left': '0'}).css(opacityFull).css(transitionOptions);
        }

        // SCALE UP
        if (dataanimationUser == dataanimation.scaleup) {
          var dataendscale = 1;
          var endScale = {
            'transform': 'scale(' + dataendscale + ')',
            '-ms-transform': 'scale(' + dataendscale + ')',
            '-webkit-transform': 'scale(' + dataendscale + ')',
            '-moz-transform': 'scale(' + dataendscale + ')',
            '-o-transform': 'scale(' + dataendscale + ')'
          };
          $(this).css(endScale).css(opacityFull).css(transitionOptions);
        }

        // SCALE DOWN
        if (dataanimationUser == dataanimation.scaledown) {
          var dataendscale2 = 1;
          var endScale2 = {
            'transform': 'scale(' + dataendscale2 + ')',
            '-ms-transform': 'scale(' + dataendscale2 + ')',
            '-webkit-transform': 'scale(' + dataendscale2 + ')',
            '-moz-transform': 'scale(' + dataendscale2 + ')',
            '-o-transform': 'scale(' + dataendscale2 + ')'
          };
          $(this).css(endScale2).css(opacityFull).css(transitionOptions);
        }

        // ROTATE
        if (dataanimationUser == dataanimation.rotate) {
          var degrees = 360;
          var rotation = {
            'transform': 'rotate(' + degrees + 'deg)',
            '-ms-transform': 'rotate(' + degrees + 'deg)',
            '-webkit-transform': 'rotate(' + degrees + 'deg)',
            '-moz-transform': 'rotate(' + degrees + 'deg)',
            '-o-transform': 'rotate(' + degrees + 'deg)'
          };
          $(this).css(rotation).css(opacityFull).css(transitionOptions);
        }

        // FLIP Y AXIS
        if (dataanimationUser == dataanimation.flipyaxis) {
          var flipY = {
            'transform': 'rotateY(360deg)',
            '-ms-transform': 'rotateY(360deg)',
            '-webkit-transform': 'rotateY(360deg)',
            '-moz-transform': 'rotateY(360deg)',
            '-o-transform': 'rotateY(360deg)'
          };
          $(this).css(flipY).css(opacityFull).css(transitionOptions);
        }

        // FLIP X AXIS
        if (dataanimationUser == dataanimation.flipxaxis) {
          var flipX = {
            'transform': 'rotateX(360deg)',
            '-ms-transform': 'rotateX(360deg)',
            '-webkit-transform': 'rotateX(360deg)',
            '-moz-transform': 'rotateX(360deg)',
            '-o-transform': 'rotateX(360deg)'
          };
          $(this).css(flipX).css(opacityFull).css(transitionOptions);
        }
      }
    });
  });
}(jQuery));