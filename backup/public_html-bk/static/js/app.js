;(function ($, window, undefined) {
   'use strict';
   var timer = false;
   var areq = false;
   var timeout_level = 0;
   var backhalt = true;
   var settings = {
         timeout: 6,
         url: false,
         cptype: false,
         abortafter: 20
       };
   $.signin = {
      launch: function(options) {
         // stop autologin on browser back
         var da = false;
         if ($('#dirty').val() == '1') { da = true;  }
         $('#dirty').val('1');
 
         settings = $.extend(settings, options);
         settings.cptype = $('#signin').data('type');
         if (settings.backhalt && da) {
            $.signin.disallow();
         } else {
            //timer = window.setInterval(function() { $.signin.timeout }, settings.timeout*1000);
            if (settings.cptype == 'solusvm')
            {
                $(setTimeout(function() { $.signin.init_solusvm(); }, 750));
            } else {
                $(setTimeout(function() { $.signin.init_cpanel(); }, 750));
            }
         }
      },
      init_solusvm: function() {
         $('#login_status').html('Authenticating with the control panel..');
         var req = {init: true};
         areq = $.ajax({
           url: $('#signin').attr('action'),
           type: "POST",
           data: $('#signin').serialize(),
           success: $.signin.check_solusvm,
           error: $.signin.error_solusvm,
           xhrFields: {
             withCredentials: true
           },
           dataType: "json"
         });
      },
      init_cpanel: function() {
         $('#login_status').html('Redirecting to cPanel..');
         $('#signin').submit();
      },
      check_solusvm: function(rep) {
         //clearTimeout(timer);
         if (!rep || !rep.success || !rep.status) {
            $.signin.error_solusvm(rep);
         } else {
            $('#login_status').html('Sign in complete! Redirecting..');
            window.location="https://control.x10vps.com/home.php";
         }
      },
      disallow: function(rep) {
         $('#login_motion, .pfc').hide();
         clearTimeout(timer);
         var url = $('#reload').val();
         $('#login_status').html('<a href="' + url + '" class="small secondary radius button ">Reload</a> to continue.');
      },
      error_solusvm: function(rep, text, error) {
         // this means either the CORS is gone or that the login was successful 
         if (rep.status == 404) {
            window.location="https://control.x10vps.com/home.php";
            return;
         }
         $('#login_motion, .pfc').hide();
         clearTimeout(timer);
         var url = $('#reload').val();
         $('#login_status').html('An error has occurred processing your request. <a href="' + url + '" class="small secondary radius button right">Retry</a>');
      }
   };
})(jQuery, this);

// bound to all reveal modals' closed event within js/foundation.min.js
function event_close_reveal() {
    $('.pfc').toggle(false);
    $('.hide-on-complete').toggle(true);
    $('.show-on-complete').toggle(false);
    $("input[name='save']").removeAttr('disabled');
    $('div.notice').text('');
    return true;
} 

function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function htmlentities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function support_attachment_create(obj) {
    var url = "http://attachments.clients.x10hosting.com/" + obj.key;
    var filename = obj.filename;
    var atid = getRandomInt(1, 999);
    atid = "atrfile"+atid.toString();
    var size = bytesToSize(obj.size);
    var html = '<div class="row"><div class="small-7 columns"><p><a href="' + url + '">' + filename + '</a> (' + obj.mimetype + ', ' + size + ')</p></div><div class="small-5columns text-right"><p style="color: #E08B5B;" id="'+atid+'">File attached.</p></div></div>';
    var blob = JSON.stringify({inkurl: obj.url, filename: filename, url: url, size: obj.size, mime: obj.mimetype});
    var input = '<input type="hidden" name="attachment[]" value="' + htmlentities(blob) + '" />';

    $('#attachment-pane').append(html);
    $('#attachment-pane-hidden').html(input);
    $('#attachment-con').toggle(true);

    return false;
}

function support_attachment(obj) {
   var url = "http://attachments.clients.x10hosting.com/" + obj.key;
   var filename = obj.filename;
   var atid = getRandomInt(1, 999);
   atid = "atrfile"+atid.toString()
   var size = bytesToSize(obj.size);
   var html = '<div class="row"><div class="small-7 columns"><p><a href="' + url + '">' + filename + '</a> (' + obj.mimetype + ', ' + size + ')</p></div><div class="small-5columns text-right"><p style="color: #E08B5B;" id="'+atid+'">Please wait..</p></div></div>';
   var blob = JSON.stringify({inkurl: obj.url, filename: filename, url: url, size: obj.size, mime: obj.mimetype});
   var input = '<input type="hidden" name="attachment[]" value="' + htmlentities(blob) + '" />';
   
    $('#attachment-pane').append(html);
    $('#attachment-pane-hidden').html(input);
    $('#attachment-con').toggle(true);
    var req = $('#attachment-form').serialize();
    
    $.ajax({type: "POST",
            url: $('#attachment-form').attr('action'),
            data: req,
            success: function(a) { $('#'+atid).html('Attached file.'); },
            error: function(a) { $('#'+atid).html('Error! Please try again.'); },
            dataType: "json" });
    return false;
}

(function($) {
    'use strict';
    
    $.vdate = $.fn.shake = function(options) {
        if (this.length !== 0) {
            //initialize settings & vars
            var settings = $.extend(
                {   distance:   8,
                    iterations: 1,
                    duration:   50,
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

function former() {
    $('.former').each(function(index, element)
    {
        var pel = $(this);
        var fn_name = $(this).data('action');
        var fn = window[fn_name];
        if (!fn) {
            return;
        }
        pel.find("input[name='cancel']").on('click', fn);
        pel.find("input[name='save']").on('click', fn);
    });
}

function funds(e) {
    var req = $('#account-funds form:first').serialize();

    $.ajax({type: "POST",
            url: '/account/update',
            data: req,
            success: former_funds_res,
            error: former_funds_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $(".cl-hide").toggle(false);
    $("input[name='save']").attr('disabled', 'disabled');
    return false;
}

function former_funds_res(data, textStatus, jqXHR) {
    var notice = $('#account-funds div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
        $('#invoice-ln').attr('href', '/invoice/' + data.data.invoiceid);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function password(e) {
    var req = $('#account-password form:first').serialize();
    $.ajax({type: "POST",
            url: '/account/update',
            data: req,
            success: former_password_res,
            error: former_password_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $(".cl-hide").toggle(false);
    $("input[name='save']").attr('disabled', 'disabled');
    return false;
}

function former_password_res(data, textStatus, jqXHR) {
    var notice = $('#account-password div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function licensenickname(e) {
    var req = $('#service-license-nickname form:first').serialize();
    var notice = $('#service-license-nickname div.notice:first');
    $.ajax({type: "POST",
            url: '/services/nickname',
            data: req,
            success: former_licensenickname_res,
            error: former_licensenickname_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='save']").attr('disabled', 'disabled');
    notice.toggle(false);
    $('.cancel-button').toggle(false);
    $('.cl-hide').toggle(false);
    return false;
}

function former_licensenickname_res(data, textStatus, jqXHR) {
    var notice = $('#service-license-nickname div.notice:first');
    var message = data.message;
    if (typeof data.message == 'undefined') { message = 'An error has occurred.'; }

    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    
      if (data.success) {
          var msg = 'Your license nickname has been saved.';
          notice.html('<span class="m">'+msg+'</span>');
          notice.toggle(true);
          var nn = $('#nickname').val();
          if (nn.length == 0) { nn = 'None'; }
          $('.nickname-up').text(nn);
          $('#nickname-button').toggle(false);
          $('.cancel-button').text('Close');
          $('.cancel-button').removeClass('cl-hide');
          $('.cancel-button').on('click', close_nickname);
          $('.cancel-button').toggle(true);
          $('.hide-on-complete').toggle(false);
      } else {
          notice.html(message);
          notice.toggle(true);
      }
}

function close_nickname(e) {
    $('#service-license-nickname a.close-reveal-modal:first').click();
    
    var notice = $('#service-license-nickname div.notice:first');
    notice.html('');
    e.stopPropagation();
    $('.cancel-button').text('Cancel');
    $('.cancel-button').addClass('cl-hide');
    
    $('.cl-hide').toggle(true);
    $('.hide-on-complete').toggle(true);
    $('#nickname-button').toggle(true);
    notice.toggle(false);
    return false;
}

function email(e) {
    var req = $('#account-email form:first').serialize();
    $.ajax({type: "POST",
            url: '/account/update',
            data: req,
            success: former_email_res,
            error: former_email_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $(".cl-hide").toggle(false);
    $("input[name='save']").attr('disabled', 'disabled');
    return false;
}

function former_email_res(data, textStatus, jqXHR) {
    var notice = $('#account-email div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function servicepassword(e) {
    var req = $('#service-password form:first').serialize();
    $.ajax({type: "POST",
            url: '/services/password',
            data: req,
            success: former_servicepassword_res,
            error: former_servicepassword_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $(".cl-hide").toggle(false);
    $("input[name='save']").attr('disabled', 'disabled');
    return false;
}

function former_servicepassword_res(data, textStatus, jqXHR) {
    var notice = $('#service-password div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function cancel(e) {
    var req = $('#service-cancel form:first').serialize();
    $.ajax({type: "POST",
            url: '/services/cancel',
            data: req,
            success: former_cancel_res,
            error: former_cancel_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='cancel']").attr('disabled', 'disabled');
    return false;
}

function former_cancel_res(data, textStatus, jqXHR) {
    var notice = $('#service-cancel div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='cancel']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function whois(e) {
    var req = $('#domain-whois form:first').serialize();
    $.ajax({type: "POST",
            url: '/domain/update',
            data: req,
            success: former_whois_res,
            error: former_whois_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='save']").attr('disabled', 'disabled');
    $(".cl-hide").toggle(false);
    return false;
}

function former_whois_res(data, textStatus, jqXHR) {
    var notice = $('#domain-whois div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function privacy(e) {
    var req = $('#domain-privacy form:first').serialize();
    $.ajax({type: "POST",
            url: '/domain/update',
            data: req,
            success: former_privacy_res,
            error: former_privacy_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='save']").attr('disabled', 'disabled');
    $(".cl-hide").toggle(false);
    return false;
}

function former_privacy_res(data, textStatus, jqXHR) {
    var notice = $('#domain-privacy div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function renew(e) {
    var req = $('#domain-renew form:first').serialize();

    $.ajax({type: "POST",
            url: '/domain/update',
            data: req,
            success: former_renew_res,
            error: former_renew_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='save']").attr('disabled', 'disabled');
    $(".cl-hide").toggle(false);
    return false;
}

function former_renew_res(data, textStatus, jqXHR) {
    var notice = $('#domain-renew div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function lock(e) {
    var req = $('#domain-lock form:first').serialize();

    $.ajax({type: "POST",
            url: '/domain/update',
            data: req,
            success: former_lock_res,
            error: former_lock_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='save']").attr('disabled', 'disabled');
    $(".cl-hide").toggle(false);
    return false;
}

function former_lock_res(data, textStatus, jqXHR) {
    var notice = $('#domain-lock div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function key(e) {
    var req = $('#domain-key form:first').serialize();
    $.ajax({type: "POST",
            url: '/domain/update',
            data: req,
            success: former_key_res,
            error: former_key_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='save']").attr('disabled', 'disabled');
    $(".cl-hide").toggle(false);
    return false;
}

function former_key_res(data, textStatus, jqXHR) {
    var notice = $('#domain-key div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function nameservers(e) {
    var req = $('#domain-nameservers form:first').serialize();

    $.ajax({type: "POST",
            url: '/domain/update',
            data: req,
            success: former_nameservers_res,
            error: former_nameservers_res,
            dataType: "json" });
    $('.pfc').toggle(true);
    e.stopPropagation();
    $("input[name='save']").attr('disabled', 'disabled');
    $(".cl-hide").toggle(false);
    return false;
}

function former_nameservers_res(data, textStatus, jqXHR) {
    var notice = $('#domain-nameservers div.notice:first');
    notice.html(data.message);
    notice.toggle(true);
    $("input[name='save']").removeAttr('disabled');
    $('.pfc').toggle(false);
    if (data.success) {
        $('.hide-on-complete').toggle(false);
        $('.show-on-complete').toggle(true);
    } else {
        $(".cl-hide").toggle(true);
    }
}

function support() {
    // ticket reply texarea, detect change and show submit button
    $('.support textarea.message').keydown(function() {
        if (!$('#message-reply-submit').is(":visible")) {
            $('#message-reply-submit').toggle($(this).val() != "");
        }
    });
}

$(document).ready(former);
$(document).ready(support);

$(document).ready(function() {

    if ($('.billing-cardnum').data('focus')) {
        $('.billing-cardnum').focus();
    }

    $('.billing-cardnum').payment('formatCardNumber');
    $('.billing-cardnum').on('keyup', function() {
        var cardtype = $.payment.cardType($('.billing-cardnum').val());
        $('.billing-cardnum').removeClass('notype visa mastercard amex discover');
        switch (cardtype) {
        case 'visa':
            $('.billing-cardnum').addClass('visa');
            break;
        case 'mastercard':
            $('.billing-cardnum').addClass('mastercard');
            break;
        case 'discover':
            $('.billing-cardnum').addClass('discover');
            break;
        case 'amex':
            $('.billing-cardnum').addClass('amex');
            break;
        default:
            $('.billing-cardnum').addClass('notype');
            break;
        }
    });
    
    $('.billing-exp').payment('formatCardExpiry');
    $('.billing-cvc').payment('formatCardCVC');
    
    function display_loader_overlay() {
        $('.preload-overlay-container, .preload-overlay-container-head').animate({
            opacity: .15
        }, 500);
        $('.preload-overlay-container').parent().append('<div class="preloader"></div>');
        $('a').css('cursor', 'default').click(false);
    }
    
    var form_trigger = false;
    
    $('.set-pm').on('click', function(e) {
        if (form_trigger) return;
        var pel = $(this).parent('span.method');
        if (pel.hasClass('disallow')) {
            return false;
        }
        $(this).text('Please wait..');
        $(this).css('display', 'inline-block');
        $(this).siblings('.delete-pm').css('display', 'none');
        display_loader_overlay();
        $('#sm-ref').val(pel.data('ref'));
        $('#sm-form').submit();
        return false;
    });
    
    $('.name-pm').on('click', function(e) {
        var el = $(this).siblings('.set-pm, .delete-pm');
        el.css('display', 'inline-block');
        e.stopPropagation();
        e.preventDefault();
        return false;
    });
    
    $('#change-method').on('change', function (e) {
        if (form_trigger) return;
        if ($(this).val() == 'choose') return;
        $('.preload-overlay-container').animate({
            opacity: .25
        }, 1000, function () {
            $(this).parent().append("<div class='preloader'></div>");
        });
        $('#um-method').val($(this).val());
        $('#um-form').submit();
    });
    
    function do_ppec_submit() {
        if ($('#do-ppec-submit').val() != 'true') return;
        $('.preload-overlay-container').animate({
            opacity: .25
        }, 1000, function () {
            $(this).parent().append("<div class='preloader'></div>");
        });

        $('#paypal_ec_paynow').click();
        $('#paypal_ec_paynow').val('Processing payment..');
        $('#paypal_ec_paynow').attr('disabled', 'disabled');
    }

    if ($('#do-ppec-submit').length > 0) {
        do_ppec_submit();
    }

    $('#card-pay').on('click', function(e) {
        var icvc;
        var cardtype = $('#billing-cvc').data("type");
        icvc = !$.payment.validateCardCVC($('.billing-cvc').val(), cardtype);
        $('.billing-cvc').toggleClass('invalid', icvc);
        if (icvc) {
            e.stopPropagation();
            return false;
        }
    });
    
    var card_submitted = false;
    
    $('#save-card').on('click', function(e) {
        var inum, iexp, icvc;
        var cardtype = $.payment.cardType($('.billing-cardnum').val());
        inum = !$.payment.validateCardNumber($('.billing-cardnum').val());
        iexp = !$.payment.validateCardExpiry($('.billing-exp').payment('cardExpiryVal'));
        icvc = !$.payment.validateCardCVC($('.billing-cvc').val(), cardtype);
        inam = ($('.billing-name').val().length < 3);
        $('.billing-cardnum').toggleClass('invalid', inum);
        $('.billing-exp').toggleClass('invalid', iexp);
        $('.billing-cvc').toggleClass('invalid', icvc);
        $('.billing-name').toggleClass('invalid', inam);
        $('label[for=billing-cardnum]').toggleClass('error', inum);
        $('label[for=billing-exp]').toggleClass('error', iexp);
        $('label[for=billing-cvc]').toggleClass('error', icvc);
        $('label[for=billing-name]').toggleClass('error', inam);
        if (inum || iexp || icvc || inam) {
            e.stopPropagation();
            return false;
        }
        if (card_submitted) return false;
        
        card_submitted = true;
        
        $(this).val('Validating, please wait..');
        $('.ln-cancel').toggle(false);
        return true;
    });

    $('.billing-cardnum, .billing-cvc, .billing-name, .billing-exp').on('keydown', function() { $(this).removeClass('invalid'); $(this).siblings('label').removeClass('error'); });

    if ($('#save-card')) { $('.billing-cardnum').focus(); }

    if (window.location.hash === "#funds") {
        $('#account-funds-ln').trigger('click');
    }

    // card-pay
    $('#card-pay').closest("form").one("submit", prevent_duplicate);
    $('#message-reply-submit').closest("form").one("submit", prevent_duplicate);

    var timer = false;
    
    $('.show-password').on('click', function() {
        var pid=$(this).data("passid");
        var pass=$(this).data("pass");
        if (timer) {
            clearTimeout(timer);
        }
        if($("#sh"+pid).text()=="••••••••"){
            $("#sh"+pid).html(pass);
            $("#shtxt"+pid).html("Hide");
            timer = setTimeout(hide_pass, 30000, pid);
        }else{
            $("#sh"+pid).html("&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;");
            $("#shtxt"+pid).html("Show");
        }
    });

    function hide_pass(pid) {
                $("#sh"+pid).html("&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;");
                $("#shtxt"+pid).html("Show");
    }

    $('#amount').payment('restrictNumeric');

    $('#do_close').click(function (e) {
        e.stopPropagation();
        close_ticket();
        return false;
    });
    
    $('#tld-selected').on('change', update_domain_durations);
    $('#tld-selected').ready(update_domain_durations);
    
    $('#renew-selection').on('change', update_domain_renewal_available);
    $('#renew-selection').on('change', update_domain_durations);
    
    $('#domain-order-type').on('change', function() {
        $('#not-renewable').toggle(false);
        $('#review-button').toggle(true);
        if ($('#domain-order-type').val() == 'register') {
            $('.domain-reg-tran').toggle(true);
            $('.domain-renew').toggle(false);
            $('.domain-order-register').toggle(true);
            $('.domain-order-transfer').toggle(false);
        } else if ($('#domain-order-type').val() == 'renew') {
            $('.domain-reg-tran').toggle(false);
            $('.domain-renew').toggle(true);
            update_domain_renewal_available();
        } else {
            $('.domain-reg-tran').toggle(true);
            $('.domain-renew').toggle(false);
            $('.domain-order-register').toggle(false);
            $('.domain-order-transfer').toggle(true);
        }
        update_domain_durations();
    });
    
    $('#show-more-nameservers').on('click', function(e) { $('#more-nameservers').toggle(true); $(this).toggle(false); e.stopPropagation(); return false; } );
});

function update_domain_durations() {
    if ($('#tld-selected').length < 1) {
        return;
    }
    var tld = $('#tld-selected').val();
    var cost = Math.round(tld_price[tld] * 100) / 100;
    var cost2 = Math.round(cost * 2 * 100) / 100;
    var cost3 = Math.round(cost * 3 * 100) / 100;
    cost = cost.toFixed(2);
    cost2 = cost2.toFixed(2);
    cost3 = cost3.toFixed(2);
    
    if ($('#domain-order-type').val() == 'transfer') {

        if (tld == '.co.uk') {
            $('#domain-cost-2').text('2 years for $' + cost);
            $('#domain-cost-1').toggle(false);
            $('#domain-cost-2').toggle(true);
            $('#domain-cost-3').toggle(false);
            $('#domain-cost-2').prop('selected', true); 
        } else {
            $('#domain-cost-1').prop('selected', true); 
            $('#domain-cost-1').text('1 year for $' + cost);
            $('#domain-cost-1').toggle(true);
            $('#domain-cost-2').toggle(false);
            $('#domain-cost-3').toggle(false);
        }
    } else {

        if ($('#domain-order-type').val() == 'renew') {
            var tld = $('#renew-selection').find(":selected").data('tld');
            var cost = Math.round(tld_price[tld] * 100) / 100;
            var cost2 = Math.round(cost * 2 * 100) / 100;
            var cost3 = Math.round(cost * 3 * 100) / 100;
            cost = cost.toFixed(2);
            cost2 = cost2.toFixed(2);
            cost3 = cost3.toFixed(2);
        }
        
        if (tld == '.co.uk') {
            $('#domain-cost-2').text('2 years for $' + cost);
            $('#domain-cost-1').toggle(false);
            $('#domain-cost-2').toggle(true);
            $('#domain-cost-3').toggle(false);
            $('#domain-cost-2').prop('selected', true); 
        } else {   
            $('#domain-cost-1').text('1 year for $' + cost);
            $('#domain-cost-2').text('2 years for $' + cost2);
            $('#domain-cost-3').text('3 years for $' + cost3);
            $('#domain-cost-1').toggle(true);
            $('#domain-cost-2').toggle(true);
            $('#domain-cost-3').toggle(true);
        }
    }
}

function update_domain_renewal_available() {
        var a = $('#renew-selection').find(":selected").data('renewable');
        if (a == '0') {
            $('#not-renewable').toggle(true);
            $('#review-button').toggle(false);
            $('#domain-duration').toggle(false);
        } else {
            $('#not-renewable').toggle(false);
            $('#review-button').toggle(true);
            $('#domain-duration').toggle(true);
        }
}

function close_ticket() {
    if ($('#do_close').val() == 'Close Ticket') {
        $('#do_close').val('Are you sure?');
    } else {
        $(document).find(":submit").each(function (i, el) {
            $(el).val("Processing..");
            $(el).attr("disabled", "disabled");
        });
        $('#tc-form').submit();
    }
}

function prevent_duplicate()
{
    $(this).submit(function() {
        return false;
    });
    $(this).find(":submit").each(function (i, el) {
        $(el).val("Processing..");
        $(el).attr("disabled", "disabled");
    });
    return true;
}

function poll_session_status() {
    $.ajax({
        url: '/login/verify_active',
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (!res || !res.success) {
                window.location = '/signout';
            }
        },
        error: function (res) {
            if (!res || !res.success) {
                window.location = '/signout';
            }
        }
    });
}

function remove_paymentmethod(e) {
    e.stopPropagation();
    var pmtoken = $(this).parent('span.method').data('ref');
    
    var should_confirm = $(this).text() == 'Remove';
    if (should_confirm) {
        $(this).text('Are you sure? Click again to remove.');
        return false;
    }
    if ($(this).data('removing') == '1') {
        return false;
    }
    $(this).text('Please wait..');
    $(this).data('removing', 1);
    $(this).css('display', 'inline-block');
    $(this).css('color', '#FF0000');
    $(this).off('mouseout');
    var el = $(this);
    $('#clear_pmtoken').val(pmtoken);
    console.log('set #pmtoken to ' + pmtoken);
    $.ajax({
        url: $('#clear_pmtoken').parent('form').attr('action'),
        type: "POST",
        data: $('#clear_pmtoken').parent('form').serialize(),
        dataType: 'json',
        success: function (res) {
            if (!res.success) {
                el.text('Failure removing source, contact support.');
            } else {
                el.parent('span.method').remove();
            }
        },
        error: function (res) {
            
            el.text('Failure removing source, contact support.');
        }
    });
}

function remove_paymentmethod_cancel(e) {
    $(this).text('Remove');
}

$(document).ready(function () {
    $("form.custom").find('input[type="checkbox"]').each(function () {            
        $(this).removeClass('hidden-field');
        $(this).next('span.custom.checkbox').remove();
    });
    if ($('#do_login').length < 1) {
        setInterval(function () {
            poll_session_status();
        }, 120000);
    }
    
    $('.delete-pm').on('click', remove_paymentmethod);
    $('.delete-pm').on('mouseout', remove_paymentmethod_cancel);
    
});
