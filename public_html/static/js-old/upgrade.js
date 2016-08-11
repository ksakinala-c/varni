var upgrade_running = false;
function change_fields() {
    $('#validatedaddr').val('0');
    $('#validatedaddrmsg').toggle(false);
    $('#purchase-review').prop('value', 'Continue');
    $(this).removeClass('invalid');
}
$(document).ready(function() {

    initialize_address();
    $('#billing-country, #billing-state, #billing-zip, #billing-street, #billing-city, #billing-country').on('keydown', change_fields);
    $('#billing-country, #billing-state, #billing-zip, #billing-street, #billing-city, #billing-country').on('focus', change_fields);
    $('.billing-cardnum').payment('formatCardNumber');
    $('.billing-cardnum').on('keyup', function() {
        var cardtype = $.payment.cardType($('.billing-cardnum').val());
        switch (cardtype) {
        case 'visa':
            $('#cardtype-img').attr('src', '/sso/static/images/cardtype-visa.gif');
            break;
        case 'mastercard':
            $('#cardtype-img').attr('src', '/sso/static/images/cardtype-mastercard.gif');
            break;
        case 'discover':
            $('#cardtype-img').attr('src', '/sso/static/images/cardtype-discover.gif');
            break;
        case 'amex':
            $('#cardtype-img').attr('src', '/sso/static/images/cardtype-amex.gif');
            break;
        default:
            $('#cardtype-img').attr('src', '/sso/static/images/cardtype-none.gif');
            break;
        }
    });
    $('.billing-exp').payment('formatCardExpiry');
    $('.billing-cvc').payment('formatCardCVC');
    $('#purchase-review').on('click', function(e) {
        e.preventDefault();
        $('input').removeClass('invalid');
        $('.validation').removeClass('passed failed');
        var cardType = $.payment.cardType($('.billing-cardnum').val());
        $('.billing-cardnum').toggleClass('invalid', !$.payment.validateCardNumber($('.billing-cardnum').val()));
        $('.billing-exp').toggleClass('invalid', !$.payment.validateCardExpiry($('.billing-exp').payment('cardExpiryVal')));
        $('.billing-cvc').toggleClass('invalid', !$.payment.validateCardCVC($('.billing-cvc').val(), cardType));
        $('.billing-name').toggleClass('invalid', !$.payment.validateCardCVC($('.billing-cvc').val(), cardType));
        if ($('input.invalid').length) {
            $('.validation').addClass('failed');
        } else {
            $('.validation').addClass('passed');
        }
        $('#billing-street').toggleClass('invalid', !($('#billing-street').val() && $('#billing-street').val().length > 2));
        $('#billing-city').toggleClass('invalid', !($('#billing-city').val() && $('#billing-city').val().length > 2));
        $('#billing-state').toggleClass('invalid', !($('#billing-state').val() && $('#billing-state').val().length > 1));
        $('#billing-zip').toggleClass('invalid', !($('#billing-zip').val() && $('#billing-zip').val().length > 2));
        $('#billing-country').toggleClass('invalid', !($('#billing-country').val() && $('#billing-country').val().length > 1));
        if ($('input.invalid').length) {
            return;
        }
        var address = $('#billing-street').val() + ", " + $('#billing-city').val() + ", " + $('#billing-state').val() + ", " + $('#billing-zip').val() + ", " + $('#billing-country').val();
        validate_address(address); // contains callback for valid or invalid address
    });
});

function purchase_review_failure(result) {
    $('#billing-street').toggleClass('invalid', true);
    $('#billing-city').toggleClass('invalid', true);
    $('#billing-state').toggleClass('invalid', true);
    $('#billing-zip').toggleClass('invalid', true);
    $('#billing-country').toggleClass('invalid', true);
    $('#address-failure').toggle(true);
}

var verified_attempts = 0;

function purchase_review_verified(result) {
    var valid_addr = false;
    verified_attempts++;
    if (verified_attempts > 3) {
        $('#skipverifymsg').on('click', function() {
            $('#validatedaddr').val('1');
            $('#validatedaddrmsg').toggle(false);
            $('#skipverifymsg').html('Thank you for letting us know about the problem.  You may now continue your order.');
            $('#purchase-review').prop('value', 'Continue');
        });
        $('#skipverifymsg').toggle(true);
    }
    if (result) {
        valid_addr = true;
    }
    $('#billing-street').toggleClass('invalid', false);
    $('#billing-city').toggleClass('invalid', false);
    $('#billing-state').toggleClass('invalid', false);
    $('#billing-zip').toggleClass('invalid', false);
    $('#billing-country').toggleClass('invalid', false);
    $('#address-failure').toggle(false);
    var city = false;
    var street = false;
    var zip = false;
    var state = false;
    var street_num = false;
    var street_route = false;
    var street_pre = false;
    var country = false;
    var country_code = false;
    $.each(result.address_components, function(idx, value) {
        if (value.types[0] == 'locality') {
            city = value.long_name;
        }
        if (value.types[0] == 'country') {
            country = value.long_name;
            country_code = value.short_name;
        }
        if (value.types[0] == 'postal_code') {
            zip = value.long_name;
        }
        if (value.types[0] == 'route') {
            street_route = value.long_name;
        }
        if (value.types[0] == 'street_number') {
            street_num = value.long_name;
        }
        if (value.types[0] == 'street_address') {
            street_pre = value.long_name;
        }
        if (value.types[0] == 'administrative_area_level_1') {
            state = value.long_name;
        }
    });
    if (street_pre) {
        street = street_pre;
    } else if (street_num && street_route) {
        street = street_num + ' ' + street_route;
    } else if (street_num) {
        street = street_num;
    } else if (street_route) {
        street = street_route;
    } else {
        if (!city) {
            $('#billing-street').toggleClass('invalid', true);
            return;
        }
    }
    if (street.length > 1) {
     //   $('#billing-street').val(street);
    }
    $('#billing-city').val(city);
    $('#billing-state').val(state);
    $('#billing-zip').val(zip);
    $('#billing-country').val(country);
    $('#billing-countrycode').val(country_code);
    if ($('#validatedaddr').val() == "0") {
        $('#validatedaddr').val('1');
        $('#validatedaddrmsg').toggle(true);
        $('#purchase-review').prop('value', 'Yes, Address is Correct');
    } else {
        continue_order();
    }
}

function continue_order() {

    if ($('#validatedaddr').val() != "1") return;

      var cycle = false;
      var cost = false;
      if ($('#billing-type').val() == 'prime') {
      cycle = $('input[name=primecycle]').filter(':checked').val();
      cost = 0;
      switch (cycle) {
        case "6": 
           cost = '4.95';
           break;
        case "12": 
           cost = '7.95';
           break;
        default:
           cycle = "3";
           cost = '2.95';
           break;
      }
    } else {
      cycle = '60'
      cost = '60.00';
    }

    $('#final-billing-street').val($('#billing-street').val());
    $('#final-billing-city').val($('#billing-city').val());
    $('#final-billing-state').val($('#billing-state').val());
    $('#final-billing-zip').val($('#billing-zip').val());
    $('#final-billing-country').val($('#billing-country').val());
    $('#final-billing-countrycode').val($('#billing-countrycode').val());
    $('#final-billing-cardnum').val($('.billing-cardnum').val());
    $('#final-billing-cvc').val($('.billing-cvc').val());
    $('#final-billing-expiry').val($('.billing-exp').val());
    $('#final-billing-name').val($('.billing-name').val());

    $('#final-upgrade-type').val($('#billing-type').val());
    $('#final-upgrade-cycle').val(cycle);

    $('.upgrade-agree-billing-street').html($('#billing-street').val());
    $('.upgrade-agree-billing-city').html($('#billing-city').val());
    $('.upgrade-agree-billing-zip').html($('#billing-zip').val());
    $('.upgrade-agree-billing-country').html($('#billing-country').val());
    $('.upgrade-agree-billing-state').html($('#billing-state').val());

    $('.upgrade-agree-billing-type').attr('src', '/sso/static/images/cardtype-' + $.payment.cardType($('.billing-cardnum').val()) + '.png');

    var cardnum = $('.billing-cardnum').val();
    $('.upgrade-agree-billing-last4').html($('.billing-cardnum').val().substr( - 4));
    $('.upgrade-agree-billing-expiry').html($('.billing-exp').val());
    $('.upgrade-agree-billing-name').html($('.billing-name').val());

    $('#upgrade-agree-type').html(ucfirst($('#billing-type').val()));
    $('.upgrade-agree-billing-cost').html(cost);
    $('#upgrade-agree-duration').html(cycle);

    $('#upgrade-agree').reveal({
      animation: 'fadeAndPop',
      closeOnBackgroundClick: false
    });
    return false;
}

function ucfirst(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}
var upgrade_submitted = false;
$(document).ready(function() {

    $('#cancel-button-premium').on('click', function() {
        $('#upgrade-premium').trigger('reveal:close');
        return false;
    });
    $('#cancel-button-prime, #cancel-complete-prime').on('click', function() {
        $('#upgrade-prime').trigger('reveal:close');
        return false;
    });
    $('#cancel-button-illuminated, #cancel-complete-illuminated').on('click', function() {
        $('#upgrade-illuminated').trigger('reveal:close');
        return false;
    });
    $('#agree-form').on('submit', function(e) {
      // disallow clicking or esc to close reveal
      upgrade_submitted = true;
      $('.reveal-modal-bg').unbind();
      $('.reveal-modal-bg').css('cursor', 'wait');
      $('body').unbind();
      $('.reveal-modal-bg').on('click', function() {
          return false;
      });
      $('.reveal-modal-bg').addClass('dark');
      $('#upgrade-agree-info').toggle(false);
      $('#upgrade-agree-submitted').toggle(true);
      upgrade_running = true;
    });

    $('#upgrade-agree-cancel').on('click', function() {
        $('#billing-info').reveal({
            animation: 'fadeAndPop',
            closeOnBackgroundClick: false
        });
        return false;
    });
    $('#cancel-button-premium').on('click', function() {
        $('#upgrade-premium').trigger('reveal:close');
        return false;
    });
    $('#purchase-button-prime').on('click', function(e) {
        $('#validatedaddr').val('0');
        $('.billing-info-header').html('Prime Upgrade');
        $('#validatedaddrmsg').toggle(false);
        $('#purchase-review').prop('value', 'Continue');
        $('#billing-type').val('prime');
        $('#billing-info').reveal({
            animation: 'fadeAndPop',
            closeOnBackgroundClick: false
        });
        return false;
    });
    $('#purchase-button-illuminated').on('click', function(e) {
        $('#validatedaddr').val('0');
        $('#validatedaddrmsg').toggle(false);
        $('.billing-info-header').html('Illuminated Upgrade');
        $('#purchase-review').prop('value', 'Continue');
        $('#billing-type').val('illuminated');
        $('#billing-info').reveal({
            animation: 'fadeAndPop',
            closeOnBackgroundClick: false
        });
        return false;
    });
    $('#goback-billing').on('click', function(e) {
        var type = $('#billing-type').val();
        if (type == 'illuminated') {
            $('#upgrade-illuminated').reveal();
        } else {
            $('#upgrade-prime').reveal();
        }
        return false;
    });
    $('#purchase-complete-illuminated').on('click', function(e) {
        if (upgrade_submitted) {
            return false;
        }
        submitilluminated();
    });
    $('#purchase-complete-prime').on('click', function(e) {
        if (upgrade_submitted) {
            return false;
        }
        submitprime();
    });
    $(document).keydown(function(e) {
        if (upgrade_submitted && e.keyCode == 27) return false;
    });
});

function submitilluminated() {
    // disallow clicking or esc to close reveal
    upgrade_submitted = true;
    $('.reveal-modal-bg').unbind();
    $('body').unbind();
    $('.reveal-modal-bg').on('click', function() {
        return false;
    });
    $('.reveal-modal-bg').addClass('dark');
    $('.upgrade-illuminated-submitted').animate({
        height: 80
    });
    $('#upgrade-illuminated-info').toggle(false);
    $('#upgrade-illuminated-submitted').toggle(true);
    $('#upgrade-illuminated-agree').toggle(false);
}

function submitprime() {
    // disallow clicking or esc to close reveal
    upgrade_submitted = true;
    $('.reveal-modal-bg').unbind();
    $('body').unbind();
    $('.reveal-modal-bg').on('click', function() {
        return false;
    });
    $('.reveal-modal-bg').addClass('dark');
    $('.upgrade-prime-submitted').animate({
        height: 80
    });
    $('#upgrade-prime-info').toggle(false);
    $('#upgrade-prime-submitted').toggle(true);
    $('#upgrade-prime-agree').toggle(false);
}
var geocoder, map, marker;
var defaultLatLng = new google.maps.LatLng(30, 0);

function initialize_address() {
    geocoder = new google.maps.Geocoder();
    var mapOptions = {
        zoom: 0,
        center: defaultLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(
    document.getElementById("map_canvas"), mapOptions);
    marker = new google.maps.Marker();
}

function validate_address(addr) {
    clearResults();
    console.log(addr);
    geocoder.geocode({
        'address': addr
    }, function(results, status) {
        switch (status) {
        case google.maps.GeocoderStatus.OK:
            console.log(results[0]);
            mapAddress(results[0]);
            purchase_review_verified(results[0]);
            break;
        case google.maps.GeocoderStatus.ZERO_RESULTS:
            purchase_review_failure(results[0]);
            break;
        default:
            break;
        }
    });
}

function clearResults() {
    map.setCenter(defaultLatLng);
    map.setZoom(0);
    marker.setMap(null);
}

function mapAddress(result) {
    marker.setPosition(result.geometry.location);
    marker.setMap(map);
    map.fitBounds(result.geometry.viewport);
}