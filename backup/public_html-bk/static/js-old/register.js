mixpanel.track_forms("#regfinal form", "Signup Submitted");
$(document).ready(function() {
  $('#register').on('submit', function(e) { e.stopPropagation(); submit_form(); return false; });
  $('#submitregister').on('click', submit_form);
  $('#subdomain').on('keyup', check_domain);
  $('#tldomain').on('change', check_domain);
  $('.register_goback').on('click', function(e) { mixpanel.track('Signup Start Over'); start_over(); e.stopPropagation(); return false; });
  $('.register_close').on('click', function(e) {
      //$("#contregister").trigger('reveal:close');
      $("#contregister").foundation('reveal', 'close');
      e.stopPropagation();
      return false;
  });
  $('#register_submit_one').on('click', submit_pane_one);
  $('#go_to_premium').on('click', submit_gotopremium);
  $('#register_email, #register_password').on('keydown', function(e) { if (e.keyCode == 13) { submit_pane_one(); }});
  $('#register_submit_two').on('click', submit_pane_two);
  $('#register_security').on('keydown', function(e) { if (e.keyCode == 13) { e.stopPropagation(); submit_pane_two();  return false;  }  });
  $('#register_submit_final').on('click', submit_pane_final);
  $('#register_submit_premium').on('click', submit_pane_premium);
  $('#captcharefresh').on('click', update_captcha);
  $('#captcharefresh').on('mouseover', function() { $('#captcharefresh img').attr("src", "/sso/static/images/loop-on.png"); });
  $('#captcharefresh').on('mouseout', function() { $('#captcharefresh img').attr("src", "/sso/static/images/loop.png"); });
  $('#captcharefresh').on('click', function() { $('#captcharefresh img').attr("src", "/sso/static/images/loop-turn.png"); });
  $('#captcharefresh').on('mouseup', function() { $('#captcharefresh img').attr("src", "/sso/static/images/loop.png"); });
});

var domainreqs = new Array();

function submit_gotopremium() {
   window.location = "http://x10premium.com";
}

function domain_status(available) {
    if (available == 1) {
      $('#domregisterload').removeClass('hide');
      $('#domregister').removeClass('hide');
      $('#domregister').html('<img src="/sso/static/images/thumbs-up.png" /> <span>That domain is available!</span>');
      $('#domregisterload').addClass('hide');
    } else if (available == -1) {
      $('#domregisterload').removeClass('hide');
      $('#domregister').removeClass('hide');
      $('#domregister').html('<span class="notavail">Invalid domain name provided.</span>');
      $('#domregisterload').addClass('hide');
    } else if (available == -5) {
      $('#domregisterload').removeClass('hide');
      $('#domregister').removeClass('hide');
      $('#domregister').html('<span class="notavail">Domain cannot begin with WWW.</span>');
      $('#domregisterload').addClass('hide');
    } else if (available == -4) {
      $('#domregisterload').removeClass('hide');
      $('#domregister').removeClass('hide');
      $('#domregister').html('<span class="notavail">Domain cannot begin with HTTP.</span>');
      $('#domregisterload').addClass('hide');
    } else if (available == -2) {
      $('#domregisterload').removeClass('hide');
      $('#domregister').removeClass('hide');
      $('#domregister').html('<span class="notavail">Domain cannot begin with a number.</span>');
      $('#domregisterload').addClass('hide');
    } else if (available == -99) {
      $('#domregisterload').removeClass('hide');
      $('#domregister').removeClass('hide');
      $('#domregister').html('<span class="notavail">Please wait a moment..</span>');
      $('#domregisterload').addClass('hide');
    } else {
      $('#domregisterload').removeClass('hide');
      $('#domregister').removeClass('hide');
      $('#domregister').html('<img src="/sso/static/images/sad.png" /> <span class="notavail">Sorry, that domain isn\'t available.</span>');
      $('#domregisterload').addClass('hide');
    }
}

function ajax_error(xhr, type, exception) {
    if (type != 'abort') {
        $('#domregister').html('<span class="notavail">An error has occurred, please try again.</span>');
        $('#domregisterload').removeClass('hide');
        $('#domregisterload').addClass('hide');
        $('#domregister').removeClass('hide');
        $('#submitregister').removeAttr('disabled');
        $('#submitregister').val('Sign Up');
    }
}

function check_domain(e) {
  if (e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40) {
    return true;
  }

  if ($('#subdomain').val().length == 0) {
    $('#domregister').html('');
    $('#domregister').addClass('hide');
    return true;
  }
  
  // cancel any pending lookups so only the latest used
  for(var i = 0; i < domainreqs.length; i++)
     domainreqs[i].abort();

  $('#domregisterload').removeClass('hide');
  $('#domregister').html('');
  $('#domregister').addClass('hide');
  var domain = $('#tldomain').val();
  var subdomain = $('#subdomain').val().replace(/\W+/g, '').toLowerCase();
  if (subdomain != $('#subdomain').val()) { $('#subdomain').val(subdomain); }
  var param = 't=domain&d=' + escape(domain) + '&s=' + subdomain;
  var req = $.ajax({
    type: "POST",
    url: '/sso/register/availability',
    data: param,
    success: check_domain_res,
    dataType: 'json',
    error: ajax_error
  });
  domainreqs.push(req);
}

function check_domain_res(httpres) {
    domain_status(httpres.available);
}

function attempt_signup(domain) {
  $('#domregisterload').removeClass('hide');
  $('#domregister').html('');
  $('#domregister').addClass('hide');
  $('#submitregister').attr('disabled', 'disabled');
  $('#submitregister').val('Loading..');
  var domain = $('#tldomain').val();
  var subdomain = $('#subdomain').val().replace(/\W+/g, '').toLowerCase();
  $('#subdomain').val(subdomain);
  var param = 't=domain&d=' + escape(domain) + '&s=' + subdomain;
  $.ajax({
    type: "POST",
    url: '/sso/register/availability',
    data: param,
    success: begin_signup,
    dataType: 'json',
    error: ajax_error
  });
}

// sets tableindex attribute to -1 for all elements that are not children of ID elid
function disable_tabindex($el) {
  $('a, input, button, select').each(function(){
    this.tabIndex = -1;
  });
  var i = 0;
  $el.find('a, input, button, select').each(function () {
    this.tabIndex = ++i;
  });
}

function begin_signup(httpres) {
    $('#register_pane_two').toggle(false);
    $('#register_pane_email').toggle(false);
    $('#register_pane_loading').toggle(false);
    $('#register_pane_three').toggle(false);
    $('#register_pane_premium').toggle(false);
    $('#register_pane_blocked').toggle(false);
    if (httpres.available == 1) {
      mixpanel.track('Signup First Pane');
      disable_tabindex($("#register_pane_one"));
      start_over();
      //$("#contregister").reveal({ animation: "none", disallowCloseFlag: function() { if ($('#regdisallowclose').val() == '1') return false; return true; }, opened: function() { $('#register_email').focus(); } }); 
      $("#contregister").foundation('reveal', 'open', {
         animation: "none",
         disallowCloseFlag: function() { if ($('#regdisallowclose').val() == '1') return false; return false; },
         opened: function() { $('#register_email').focus(); }
      }); 
    } else {
      $('#subdomain').select();
    }
    domain_status(httpres.available);
    $('#submitregister').removeAttr('disabled');
    $('#submitregister').val('Sign up');
}

function slide_left(elid) {
  var $pane = $('#'+ elid);
  $('#'+ elid).animate({ left: -$pane.outerWidth() });
}

function slide_from_left(elid) {
  $('#'+elid).toggle(true);
  var $pane = $('#'+ elid);
  $('#'+ elid).animate({ left: 0 });
}

function slide_from_right(elid) {
  $('#'+elid).toggle(true);
  var $pane = $('#'+ elid);
  $('#'+ elid).animate({ left: 0 });
}

function slide_right(elid, delay) {
  delay = typeof delay !== 'undefined' ? delay : 400;
  var $pane = $('#'+ elid);
  $pane.animate({ left: 360, duration: delay, complete: function(elid) { $('#'+elid).toggle(true); } });
}

function submit_form() {
    var domain = $('#subdomain').val() +'.'+ $('#tldomain').val();
    if ($('#subdomain').val().length == 0) {
        $('#domregister').html('<span class="notavail">You must enter a domain.</span>');
        $('#domregister').removeClass('hide');
        if (!$('#subdomain').is(":focus")) {
            $('#subdomain').focus();
        }
        return;
    }
    attempt_signup(domain);
}

function start_over(e) {
    slide_right('register_pane_two');
    slide_from_left('register_pane_one');
    $('#register_pane_loading').toggle(false);
    slide_right('register_pane_loading', 0);
    $('#register_pane_email').toggle(false);
    slide_right('register_pane_email');
    $('#register_pane_three').toggle(false);
    slide_right('register_pane_three', 0);
    disable_tabindex($("#register_pane_one"));
    $('#register_pane_blocked').toggle(false);
    $('#register_pane_premium').toggle(false);
}

function update_captcha() {
  mixpanel.track('Signup Refresh Captcha');
  d = new Date();
  $('#captchaimg').attr("src", "/sso/captcha/generate/g.png?"+d.getTime());
}

function submit_pane_one() {
  
  // validate fields filled before continuing
  var email = $('#register_email').val();
  var preexisting = $('#register_email').data('preexisting') == '1';
  var password = $('#register_password').val();
  
  if (email.length == 0) { 
    $('#register_one_msg').html('<span class="notavail">Please enter your email.</span>');
    $('#register_email').focus();
    return;
  }

  if (!preexisting && password.length == 0) { 
    $('#register_one_msg').html('<span class="notavail">Please enter a password.</span>');
    $('#register_password').focus();
    return;
  }
  
  if (!preexisting && password.length < 7) { 
    $('#register_one_msg').html('<span class="notavail">Your password must be longer!</span>');
    $('#register_password').focus();
    return;
  }

  $('#register_one_msg').html('<img src="/sso/static/images/thumbs-up.png" /> <span>Your selected domain is available!</span>');
  $('#register_pane_loading').toggle(true);
  slide_left('register_pane_one');
  slide_from_right('register_pane_loading');

  var potuser = ($('#subdomain').val() + $('#tldomain').val()).replace(/\W+/g, '').toLowerCase();
  var email = $('#register_email').val();
  var password = $('#register_password').val();
  var param = 't=email&e=' + escape(email) +'&p=' + escape(password) + '&u=' + escape(potuser);
  $.ajax({
    type: "POST",
    url: '/sso/register/availability',
    data: param,
    success: submit_pane_one_res,
    dataType: 'json',
    error: ajax_error
  });
}

function submit_pane_two() {
  // validate fields filled before continuing
  var register_security = $('#register_security').val();
  var register_terms = $('#register_terms').is(':checked');
  if (register_security.length == 0) { 
    $('#register_two_msg').html('<span class="notavail">Enter the security word.</span>');
    $('#register_security').focus();
    return;
  }

  if (!register_terms) { 
    $('#register_two_msg').html('<span class="notavail">You must agree to our Terms.</span>');
    return;
  }

  slide_left('register_pane_two');
  slide_from_right('register_pane_loading');

  var param = 't=security&c=' + escape(register_security);
  $.ajax({
    type: "POST",
    url: '/sso/register/availability',
    data: param,
    success: submit_pane_two_res,
    dataType: 'json',
    error: ajax_error
  });
}

function submit_pane_final() {
    $('#register_submit_final').attr('disabled', 'disabled');
    $('#register_submit_final').val('Submitting Sign up..');
    $('#final_slide').slideUp();
    // disallow clicking or esc to close reveal
    $('.reveal-modal-bg').unbind();
    $('body').unbind();
    $('.reveal-modal-bg').on('click', function() { return false; });
    $('.reveal-modal-bg').addClass('dark');
    $('.panecon').animate({ height: 80 });
    $('#final_goback').toggle(false);
    $('#final_standby').toggle(true);
    $('#regfinal').submit();
}

function submit_pane_one_res(httpres) {
    if (httpres.available == 1) {
      mixpanel.track('Signup Email Validated');
      slide_left('register_pane_loading');
      $('#register_pane_two').toggle(false);
      $('#register_pane_email').toggle(false);
      $('#register_pane_blocked').toggle(false);
      $('#register_pane_three').toggle(false);
      slide_from_right('register_pane_two');
      disable_tabindex($("#register_pane_two"));
      setTimeout(function() { $('#register_pane_loading').toggle(false); slide_right('register_pane_loading', 0); }, 1000);
      setTimeout(function() { $('#register_security').focus(); }, 100);
      $('#update_captcha').trigger('click');
    } else if (httpres.available == -9) {
      // already in use
      mixpanel.track('Signup IP Issue');
      slide_left('register_pane_loading');
      slide_from_right('register_pane_blocked'); 
      $('#register_block_msg').html('<span class="notavail">'+httpres.message+'</span>');
      disable_tabindex($("#register_pane_blocked"));
      $('.reveal-modal-bg').unbind();
      $('body').unbind();
      $('.reveal-modal-bg').on('click', function() { return false; });
      $('.reveal-modal-bg').addClass('dark');
    } else if (httpres.available == 0) {
      // already in use
      mixpanel.track('Signup Email In Use');
      slide_left('register_pane_loading');
      slide_from_right('register_pane_email'); 
      disable_tabindex($("#register_pane_email"));
    } else if (httpres.available == -2) {
      // already in use
      mixpanel.track('Signup Already Have Account');
      slide_left('register_pane_loading');
      slide_from_right('register_pane_email'); 
      disable_tabindex($("#register_pane_email"));
      $('#register_pane_email_desc').toggle(true);
    } else if (httpres.available == -3) {
      // bad password
      mixpanel.track('Signup Bad Password');
      slide_right('register_pane_two', 0);
      slide_from_left('register_pane_one');
      disable_tabindex($("#register_pane_one"));
    
      $('#register_pane_loading').toggle(false);
      slide_right('register_pane_loading');

      $('#register_pane_email').toggle(false);
      slide_right('register_pane_email');

      $('#register_pane_three').toggle(false);
      slide_right('register_pane_three', 0);

      $('#register_one_msg').html('<span class="notavail">' + httpres.message + '</span>');
      $('#register_password').focus();
    } else if (httpres.available == -4) {
      // bad password
      mixpanel.track('Signup Failed Email Not Allowed');
      slide_right('register_pane_two', 0);
      slide_from_left('register_pane_one');
      disable_tabindex($("#register_pane_one"));
    
      $('#register_pane_loading').toggle(false);
      slide_right('register_pane_loading');

      $('#register_pane_email').toggle(false);
      slide_right('register_pane_email');

      $('#register_pane_three').toggle(false);
      slide_right('register_pane_three', 0);

      $('#register_one_msg').html('<span class="notavail">Sorry, your email provider is not allowed.</span>');
      $('#register_email').focus();
     } else {
      mixpanel.track('Signup Email Invalid');
      slide_right('register_pane_two', 0);
      slide_from_left('register_pane_one');
      disable_tabindex($("#register_pane_one"));
    
      $('#register_pane_loading').toggle(false);
      slide_right('register_pane_loading');

      $('#register_pane_email').toggle(false);
      slide_right('register_pane_email');

      $('#register_pane_three').toggle(false);
      slide_right('register_pane_three', 0);

      $('#register_one_msg').html('<span class="notavail">Invalid email address provided.</span>');
      $('#register_email').focus();
    }
}

function submit_pane_two_res(httpres) {
    if (httpres.available == 1) {
      mixpanel.track('Signup Third Pane Upsell');
      var fulldomain = $('#subdomain').val() +'.'+ $('#tldomain').val();
      var subdomain = $('#subdomain').val();
      var domain = $('#tldomain').val();
      var email = $('#register_email').val();
      var password = $('#register_password').val();
      var security = $('#register_security').val();
      var terms = $('#register_terms').is(':checked') ? '1' : '0';

      $('#regsum_domain').html(fulldomain);
      $('#regsum_email').html(email);
      $('#final_standby').toggle(false);

      // form values
      $('#regfinal_email').val(email);
      $('#regfinal_password').val(password);
      $('#regfinal_terms').val(terms);
      $('#regfinal_subdomain').val(subdomain);
      $('#regfinal_domain').val(domain);
      $('#regfinal_security').val(security);

      // animate
      $('#register_pane_premium').toggle(true);
      slide_left('register_pane_loading');
      slide_from_right('register_pane_premium'); 
      $('#register_pane_email').toggle(false);
      $('#register_two_msg').html('');
      disable_tabindex($("#register_pane_premium"));
      $('.panecon').animate({ height: 520 });
      $('#contregister').animate({ width: 480 });
      $('#premiumexpand').animate({ width: 415 });
      $('#contregister').animate({ width: 480, marginLeft: -240 });
    } else {
      // wrong code
      mixpanel.track('Signup Invalid Captcha');
      slide_right('register_pane_loading');
      slide_from_left('register_pane_two'); 
      disable_tabindex($("#register_pane_two"));
      $('#register_two_msg').html('<span class="notavail">Invalid security code.</span>');
    }
}

function submit_pane_premium() {
      // animate
      mixpanel.track('Signup Summary');
      $('#register_pane_three').toggle(true);
      slide_left('register_pane_premium');
      slide_from_right('register_pane_three'); 
      $('#register_pane_email').toggle(false);
      $('#register_two_msg').html('');
      disable_tabindex($("#register_pane_three"));
      $('.panecon').animate({ height: 330 });
      $('#contregister').animate({ width: 340 });
      $('#premiumexpand').animate({ width: 340 });
      $('#contregister').animate({ width: 410, marginLeft: -205 });
}

