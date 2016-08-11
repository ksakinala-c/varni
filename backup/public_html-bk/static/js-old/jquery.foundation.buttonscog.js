;(function ($, window, undefined) {
  'use strict';
  $.fn.foundationButtonsCog = function (options) {

    var $doc = $(document),
      config = $.extend({
        dropdownAsToggle:true,
        activeClass:'active'
      }, options),

    // close all dropdowns except for the dropdown passed
      closeDropdowns = function (dropdown) {
        $('.cogbtn.dropdown').find('ul').not(dropdown).removeClass('show-dropdown');
      },
    // reset all toggle states except for the button passed
      resetToggles = function (button) {
        var buttons = $('.cogbtn.dropdown').not(button);
        buttons.add($('> span.' + config.activeClass, buttons)).removeClass(config.activeClass);
      };

    // Prevent event propagation on disabled buttons
    $doc.on('click.fndtn', '.button.disabled', function (e) {
      e.preventDefault();
    });

    $('.cogbtn.dropdown > ul', this).addClass('no-hover');

    // reset other active states
    $doc.on('click.fndtn', '.cogbtn.dropdown:not(.split), .cogbtn.dropdown.split span', function (e) {
      var $el = $(this),
        button = $el.closest('.cogbtn.dropdown'),
        dropdown = $('> ul', button);

        // If the click is registered on an actual link then do not preventDefault which stops the browser from following the link
        if (e.target.nodeName !== "A"){
          e.preventDefault();
        }

      // close other dropdowns
      closeDropdowns(config.dropdownAsToggle ? dropdown : '');
      dropdown.toggleClass('show-dropdown');

      if (config.dropdownAsToggle) {
        resetToggles(button);
        $el.toggleClass(config.activeClass);
      }
    });

    // close all dropdowns and deactivate all buttons
    $doc.on('click.fndtn', 'body, html', function (e) {
      if (undefined == e.originalEvent) { return; }
      // check original target instead of stopping event propagation to play nice with other events
      if (!$(e.originalEvent.target).is('.cogbtn.dropdown:not(.split), .cogbtn.dropdown.split span')) {
        closeDropdowns();
        if (config.dropdownAsToggle) {
          resetToggles();
        }
      }
    });

    // Positioning the Flyout List
    var normalButtonHeight  = $('.cogbtn.dropdown:not(.large):not(.small):not(.tiny)', this).outerHeight() - 1,
        largeButtonHeight   = $('.cogbtn.large.dropdown', this).outerHeight() - 1,
        smallButtonHeight   = $('.cogbtn.small.dropdown', this).outerHeight() - 1,
        tinyButtonHeight    = $('.cogbtn.tiny.dropdown', this).outerHeight() - 1;

    $('.cogbtn.dropdown:not(.large):not(.small):not(.tiny) > ul', this).css('top', normalButtonHeight);
    $('.cogbtn.dropdown.large > ul', this).css('top', largeButtonHeight);
    $('.cogbtn.dropdown.small > ul', this).css('top', smallButtonHeight);
    $('.cogbtn.dropdown.tiny > ul', this).css('top', tinyButtonHeight);

    $('.cogbtn.dropdown.up:not(.large):not(.small):not(.tiny) > ul', this).css('top', 'auto').css('bottom', normalButtonHeight - 2);
    $('.cogbtn.dropdown.up.large > ul', this).css('top', 'auto').css('bottom', largeButtonHeight - 2);
    $('.cogbtn.dropdown.up.small > ul', this).css('top', 'auto').css('bottom', smallButtonHeight - 2);
    $('.cogbtn.dropdown.up.tiny > ul', this).css('top', 'auto').css('bottom', tinyButtonHeight - 2);

  };

})( jQuery, this );
