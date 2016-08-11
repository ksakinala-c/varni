(function ($, window, undefined) {
  'use strict';

  var $doc = $(document),
      Modernizr = window.Modernizr;

  $(document).ready(function() {
    $.fn.foundationAlerts           ? $doc.foundationAlerts() : null;
    $.fn.foundationButtons          ? $doc.foundationButtons() : null;
    $.fn.foundationAccordion        ? $doc.foundationAccordion() : null;
    $.fn.foundationNavigation       ? $doc.foundationNavigation() : null;
    $.fn.foundationTopBar           ? $doc.foundationTopBar() : null;
    $.fn.foundationCustomForms      ? $doc.foundationCustomForms() : null;
    $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
    $.fn.foundationTabs             ? $doc.foundationTabs({callback : $.foundation.customForms.appendCustomMarkup}) : null;
    $.fn.foundationTooltips         ? $doc.foundationTooltips() : null;
    $.fn.foundationMagellan         ? $doc.foundationMagellan() : null;
    $.fn.foundationClearing         ? $doc.foundationClearing() : null;
    $.fn.placeholder                ? $('input, textarea').placeholder() : null;
  });

  if (Modernizr.touch && !window.location.hash) {
    $(window).load(function () {
      setTimeout(function () {
        window.scrollTo(0, 1);
      }, 0);
    });
  }

})(jQuery, this);

;(function ($, window, undefined) {
   'use strict';
   var timer = false;
   var areq = false;
   var timeout_level = 0;
   var backhalt = false;
   var settings = {
         timeout: 6,
         url: false,
         abortafter: 20
       };
   $.signin = {
      launch: function(options) {
         // stop autologin on browser back
         var da = false;
         if ($('#dirty').val() == '1') { da = true;  }
         $('#dirty').val('1');
 
         settings = $.extend(settings, options);
         if (settings.backhalt && da) {
            $.signin.disallow();
         } else {
            timer = window.setInterval($.signin.timeout, settings.timeout*1000);
            $(setTimeout($.signin.init, 750));
         }
      },
      init: function() {
         $('#login_status').html('Validating your credentials..');
         var req = {init: true};
         areq = $.ajax({
           url: settings.url,
           type: "POST",
           data: req,
           success: $.signin.check,
           error: $.signin.error,
           dataType: "json"
         });
      },
      check: function(rep) {
         clearTimeout(timer);
         if (!rep || !rep.success) {
            $.signin.error(rep);
         } else {
            $('#login_status').html('Sign in complete! Redirecting to the control panel..');
            $('#signin').submit();
         }
      },
      disallow: function(rep) {
         $('#login_motion, #pdesc').hide();
         clearTimeout(timer);
         $('#login_status').html('Please <a href="main" class="small secondary radius button ">Reload</a> to continue.');
      },
      error: function(rep) {
         $('#login_motion').hide();
         clearTimeout(timer);
         $('#login_status').html('An error has occurred processing your request. <a href="main" class="small secondary radius button right">Retry</a>');
      },
      timeout: function() {
         if (timeout_level == 0) {
            $('#login_status').html('Please standby, sometimes this takes a moment..');
         }
         else if (timeout_level == 1) {
            $('#login_status').html('Your request is taking longer than usual to process..');
         }
         timeout_level += 1;
         if (timeout_level >= settings.abortafter) {
            if (areq) { $('#login_motion').toggle(false); areq.abort(); }
         }
      }
   };
})(jQuery, this);

function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};

function support_attachment(obj) {
   var url = "https://s3.amazonaws.com/" + container + "/" + obj.key;
   var filename = obj.filename;
   var size = size.toString() + " " bytesToSize(obj.size);
   var html = '<div class="row"><div class="small-8 columns"><a href="' + url + '">' + filename + '</a><div class="small-2 columns">' + obj.mimetype + '</div><div class="small-2 columns">' + size + '</div></div>';
   $('#ticket-attachments').append(html);
}

;(function ($, window, undefined) {
   'use strict';
   var timer = false;
   var defaults = {
         period: 5,
         url: false
       };
   $.suspension = {
      launch: function(options) {
         defaults = $.extend(defaults, options);
         timer = window.setInterval(this.poll, defaults.period*1000);
      },
      poll: function() {
         var req = {fetch: true};
         $.ajax({
           url: defaults.url,
           type: "POST",
           data: req,
           success: $.suspension.check,
           dataType: "json"
         });
      },
      check: function(rep) {
         if (rep.suspended) return;
         clearTimeout(timer);
         $.suspension.remove();
      },
      remove: function() {
         $('#suspension_rmpending').empty();
         $('#suspension_rmpending').toggleClass('success', true);
         $('#suspension_rmpending').append('<span class="icon-happy"></span> Your account ' +
                                           'is now available. <a class="small secondary ' +
                                           'radius button right" href="main">Continue</a>');
      }
   };
})(jQuery, this);

$(document).ready(function() {
$(".pd").on("click", function() {
  $(this).css("color", "#8F8F8F");
  $(this).click(function() {
    return false
  })
});
});

(function($) {
    'use strict';
    
    //the plugin call
    $.vdate = $.fn.shake = function(options) {
        if (this.length !== 0) {
            //initialize settings & vars
            var settings = $.extend(
                {   distance:   8,
                    iterations: 2,
                    duration:   100,
                    easing:     'swing'},
                options), 
                $shakeThis = this;
            
            return $shakeThis.each(function(i, el) {
                var $el = $(el),
                    marg = ($el.parent().width() / 2) - ($el.outerWidth() / 2);
            
                $el.css('margin-left', marg);
                for (var j = 0; j < settings.iterations; j++)
                    leftRight($el, marg);
            
                $el.animate({'margin-left': marg}, settings);
            });
        }

        function leftRight($el, marg) {
            $el.animate({'margin-left': (marg - settings.distance)}, settings)
               .animate({'margin-left': (marg + settings.distance)}, settings);
        }
    };
    
})(jQuery);

$(document).ready(function() {
$(".pdup").on('click', function() {
  $('#' + $(this).data('showid')).removeClass('hide');

  $(this).click(function() {
    return false
  });
  return true;
});
});