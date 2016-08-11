var packages_licenses = [199, 201, 207];
var packages_hosted = [215, 217, 218, 219, 220, 239, 226, 221, 222, 231, 237, 236];
var tiers = {
    // licenses
    199: { min: 1, max: 9, addon_phys_id: 199, addon_vm_id: 223 },
    201: { min: 10, max: 19, addon_phys_id: 201, addon_vm_id: 224 },
    207: { min: 20, max: 300, addon_phys_id: 207, addon_vm_id: 225 },
    
    // hosted
    215: { min: 1, max: 300, addon_agents_id: 213 },
    217: { min: 1, max: 300, addon_agents_id: 213 },
    218: { min: 1, max: 300, addon_agents_id: 213 },
    219: { min: 1, max: 300, addon_agents_id: 213 },
    220: { min: 1, max: 300, addon_agents_id: 213 },
    239: { min: 1, max: 300, addon_agents_id: 213 },
    226: { min: 1, max: 300, addon_agents_id: 213 },
    221: { min: 1, max: 300, addon_agents_id: 213 },
    222: { min: 1, max: 300, addon_agents_id: 213 },
    231: { min: 1, max: 300, addon_agents_id: 213 },
    237: { min: 1, max: 300, addon_agents_id: 213 },
    236: { min: 1, max: 300, addon_agents_id: 213 },
}

function get_original_price() {
    var price = $('.prorated .value').data('original-amount');
    price = parseFloat(price);
    if (isNaN(price)) {
        return 0.0;
    }
    return price;
}

function calc_price(term) {
    var price = 0.0;
    var $pkg = get_package_el();
    
    price += parseFloat($pkg.data(term + '-pricing'));
    
    var show_addons = $pkg.data('show-addons').toString();

    $.each(show_addons.split(","), function(key, addon_id) {
        var addon = $("#package_addon_" + addon_id);
        var addon_pricing = parseFloat(addon.data(term + '-pricing'));
        var original_addon_value = parseInt($("#package_addon_" + addon_id).data('original-amount'));
        
        var addon_amount = parseInt(addon.val());
        var dis_count = parseInt(addon.data('dis-count'));
        addon_amount -= dis_count;
        if (addon_amount < 0) { addon_amount = 0; }
        
        price += addon_amount * addon_pricing;
    });
    
    return price;
}

function get_addon_tier_price(addon_id, addon_value) {
    var tiers = $('#package_addon_' + addon_id).data('tiers');
    var tier_lock = '';
    if (addon_id == 285) {
        tier_lock = $('#phys_tier_lock').val(); // 285
    }
    else if (addon_id == 296) {
        tier_lock = $('#vm_tier_lock').val(); // 296
    }
    
    var tier = false;
    $.each(tiers, function (tier_id, prop) {
        if (tier_lock == prop.name) {
            // lock ticked, force this tier pricing always
            tier = prop;
            return false; // break $.each
        }
        
        if (addon_value >= prop.min && addon_value <= prop.max) {
            tier = prop;
        }
    });
    
    var term = get_term();
    var addon_price_at_tier;
    if (term == 'monthly') {
        addon_price_at_tier = tier.pricing.monthly;
    } else {
        addon_price_at_tier = tier.pricing.annually;
    }
    
    var price = addon_price_at_tier * parseInt(addon_value);
    return price;
}

function update_prorated_due() {
    var days_remaining = $('.prorated .value').data('days-remaining');
    var original_price = get_original_price();
    var term = get_term();
    var new_price = calc_price(term);
    
    
    var total_price = 0.0;
    var $pkg = get_package_el();
    var show_addons = $pkg.data('show-addons').toString();
    $.each(show_addons.split(","), function(key, addon_id) {
        var addon = $("#package_addon_" + addon_id);
        var addon_pricing = parseFloat(addon.data(term + '-pricing'));
        var original_addon_value = parseInt($("#package_addon_" + addon_id).data('original-amount'));
        
        var addon_amount = parseInt(addon.val());
        var dis_count = parseInt(addon.data('dis-count'));
        addon_amount -= dis_count;
        if (addon_amount < 0 || isNaN(addon_amount)) { addon_amount = 0; }
        
        var original_price = get_addon_tier_price(addon_id, original_addon_value);
        // var new_price = addon_amount * addon_pricing;
        var new_price = get_addon_tier_price(addon_id, addon_amount);
        
        var prorated_price;
        if (term == 'annually') {
            prorated_price = (new_price - original_price) / 365;
        } else {
            prorated_price = (new_price - original_price) / 30;
        }
        prorated_price = prorated_price * days_remaining;
        
        if (prorated_price > 0.005) {
            total_price += prorated_price;
        }
    });
    
    // // for simplicity use 365 and 30
    // if (term == 'annually') {
    //     new_price_per_day = new_price / 365;
    //     original_price_per_day = original_price / 365;
    // } else {
    //     new_price_per_day = new_price / 30.0;
    //     original_price_per_day = original_price / 30.0;
    // }
    
    // var prorated_due = (new_price_per_day - original_price_per_day) * days_remaining;
    // if (prorated_due <= 0.009) {
    //     prorated_due = 0.0;
    // }
    var prorated_due = total_price;
    $('.prorated .value').text(money_format(prorated_due));
}

function update_price() {
    var price_monthly = money_format(calc_price('monthly'));
    var price_annually = money_format(calc_price('annually'));
    $('.term-price.monthly').text(price_monthly);
    $('.term-price.annually').text(price_annually);
}

function change_term() {
    update_summary();
    trigger_addon_update();
}

function change_package() {
    var $pkg = get_package_el();
    var new_package_id = parseInt($pkg.val());
    var original_package_id = parseInt($pkg.parent('select').data('original-package'));
    
    if (new_package_id != original_package_id) {
        var change_desc = $pkg.text();
        $('.package_change .value').text(change_desc);
        $('.package_change').toggleClass('hide', false);
    } else {
        $('.package_change').toggleClass('hide', true);
    }
    
    // show terms for this package
    $(".package_terms").toggleClass('hide', true);
    $(".package_terms_" + new_package_id).toggleClass('hide', false);
    
    // license key
    if ($.inArray(new_package_id, packages_licenses) > -1) {
        var prop = tiers[new_package_id];
        var package_phys = $('#package_addon_' + prop.addon_phys_id);
        // var package_vm = $('#package_addon_' + prop.addon_phys_id);
        if (package_phys.val() < prop.min) {
            value_set_license_phys(prop.min);
        }
    }
    
    // hosted
    if ($.inArray(new_package_id, packages_hosted) > -1) {
        var prop = tiers[new_package_id];
        var package_agents = $('#package_addon_' + prop.addon_agents_id);
        if (package_agents.val() < prop.min) {
            //value_set_hosted_phys(prop.min);
        }
    }
    
    var show_addons = $(this).find(':selected').data('show-addons').toString();
    var show_addon_ids = show_addons.split(",");
    $.each(show_addon_ids, function(key, addon_id) {
        $('.package_addons').toggleClass('hide', true);
        $('.package_addon_' + addon_id).parent('.package_addons').toggleClass('hide', false);
    });
    
    $('.summary-package .name').text($(this).find(':selected').text());
    
    trigger_addon_update();
    update_summary();
    update_price();
}

function get_package_el() {
    var $pkg = $('.package').find(':selected');
    return $pkg;
}

function get_term() {
    var $pkg = get_package_el();
    var term = $('input[name=term_' + $pkg.val() + ']:checked');
    return term.val();
}

function update_summary_term() {
    var term = get_term();
    if (term == 'annually') {
        term = 'annual';
    }
    $('.order-term').text(ucfirst(term) + ' Term');
}

function update_summary() {
    var $pkg = get_package_el();
    var term = get_term();
    var package_price = parseFloat($pkg.data(term + '-pricing'));
    update_summary_term();
    
    var price = calc_price(term);
    $('.subtotal .value').text(money_format(price));
    
    // hide addons that have no values
    var show_addons = $pkg.data('show-addons').toString();
    $.each(show_addons.split(","), function(key, addon_id) {
        var addon = $('#package_addon_' + addon_id);
        var addon_price = parseFloat(addon.data(term + '-pricing'));
        var value = parseInt(addon.val());
        var dis_count = parseInt(addon.data('dis-count'));
        if (dis_count > 0) {
            $(".summary_addon_discount_" + addon_id).toggleClass('hide', false);
            $(".summary_addon_discount_" + addon_id).find('.dis-count-name').html('&#8627; First Server');
            $(".summary_addon_discount_" + addon_id).find('.dis-count-value').html(money_format(0.0));
        } else {
            $(".summary_addon_discount_" + addon_id).toggleClass('hide', true);
        }
        if (value == addon.data('dis-count')) {
            $(".summary_addon_" + addon_id).toggleClass('hide', true);
        } else {
            $(".summary_addon_" + addon_id).toggleClass('hide', false);
        }
        if (addon_id == 213) {
            $(".summary_addon_" + addon_id).find('.name').html('&#8627; Additional Servers');
        }
        
        // update summary
        value = value - parseInt(addon.data('dis-count'));
        cost = addon_price * value;
        $(".summary_addon_" + addon_id).find('.amount').html('&times; ' + value);
        $(".summary_addon_" + addon_id).find('.value').html(money_format(cost));
    });
    
}

function change_setup() {
    var new_addon_value = parseInt($(this).val());
    update_summary();
}

function change_addon() {
    var new_addon_value = parseInt($(this).val());
    var changed_package_id = parseInt($(this).data('package-id'));
    var changed_addon_id = parseInt($(this).data('addon-id'));
    var original_addon_value = parseInt($(this).data('original-amount'));
    
    var min_value = parseInt($(this).attr('min'));
    if (isNaN(min_value)) {
        min_value = 0;
    }
    
    if (isNaN(new_addon_value) || new_addon_value < min_value) {
        $(this).val(min_value);
        return;
    }
    
    var change_desc;
    if (original_addon_value == new_addon_value) {
        change_desc = '';
    }
    else if (original_addon_value > new_addon_value) {
        change_desc = '<em>Remove ' + (original_addon_value - new_addon_value) + '</em>';
    }
    else {
        change_desc = '<em>Add ' + (new_addon_value - original_addon_value) + '</em>';
    }
    
    $('#package_addon_change_' + changed_addon_id).text(new_addon_value);
    $('#package_addon_changedesc_' + changed_addon_id).html(change_desc);
    
    var tiers = $(this).data('tiers');
    
    var tier_lock = '';
    var has_tier_lock = false;
    if (changed_addon_id == 285) {
        tier_lock = $('#phys_tier_lock').val(); // 285
    }
    else if (changed_addon_id == 296) {
        tier_lock = $('#vm_tier_lock').val(); // 296
    }
    
    var tier = false;
    $.each(tiers, function (tier_id, prop) {
        if (tier_lock == prop.name) {
            // lock ticked, force this tier pricing always
            tier = prop;
            has_tier_lock = true;
            return false; // break $.each
        }
        
        if (new_addon_value >= prop.min && new_addon_value <= prop.max) {
            tier = prop;
        }
    });
    
    if (!tier) {
        return;
    }
    
    $(this).data('monthly-pricing', tier.pricing.monthly);
    $(this).data('annually-pricing', tier.pricing.annually);
    
    $('.summary_addon_' + changed_addon_id).find('.amount').html('&times; ' + new_addon_value);
    
    var term = get_term();
    var addon_price_desc;
    if (term == 'monthly') {
        addon_price_desc = money_format(tier.pricing.monthly);
    } else {
        addon_price_desc = money_format(tier.pricing.annually);
    }
    
    if (new_addon_value == min_value && min_value > 0) {
        addon_price_desc = addon_price_desc + ' each, first is free';
        $('.package_addon_' + changed_addon_id).find('.price-each').addClass('line-through');
    }
    else if (new_addon_value > min_value && min_value > 0) {
        addon_price_desc = addon_price_desc + ' each, first is free';
        $('.package_addon_' + changed_addon_id).find('.price-each').removeClass('line-through');
    }
    else {
        addon_price_desc = '&times; ' + addon_price_desc;
    }
    
    // show star for signifying locked/special pricing tier
    if (has_tier_lock) {
        addon_price_desc += ' <i class="fa fa-star lock-tier" title="Custom tier pricing applied"></i>';
    }
    
    $('.package_addon_' + changed_addon_id).find('.price-each').html(addon_price_desc);
    
    // license key
    if ($.inArray(changed_package_id, packages_licenses) > -1) {
        // for each tier's addons
        $.each(tiers, function(package_id, prop) {
            if (changed_addon_id == prop.addon_phys_id) {
                value_set_license_phys(new_addon_value);
            }
            else if (changed_addon_id == prop.addon_vm_id) {
                value_set_license_vm(new_addon_value);
            };
        });
    }
    
    update_summary();
    update_price();
}

function value_set_hosted_phys(new_amount) {
    var $pkg = get_package_el();
    var package_id = parseInt($pkg.val());
    var prop = tiers[package_id];
    var package_phys = $('#package_addon_' + prop.addon_agents_id);
    package_phys.val(new_amount);
}

function value_set_license_phys(new_amount) {
    $.each(tiers, function(package_id, prop) {
        var package_phys = $('#package_addon_' + prop.addon_phys_id);
        package_phys.val(new_amount);
    });
}

function value_set_license_vm(new_amount) { 
    $.each(tiers, function(package_id, prop) {
        var package_phys = $('#package_addon_' + prop.addon_vm_id);
        package_phys.val(new_amount);
    });
}

function trigger_addon_update() {
    var $pkg = get_package_el();
    var show_addons = $pkg.data('show-addons').toString();
    $.each(show_addons.split(","), function(key, addon_id) {
        $(".package_addon_" + addon_id).find('input.addon').change();
    });
}

$(document).ready(function() {
    $('.package').change(change_package);
    $('.package').change(update_prorated_due);
    $('.addon').change(change_addon);
    $('.addon').change(update_prorated_due);
    $('.term').change(change_term);
    $('.review-changes').click(show_review);
    $('.make-changes').click(show_form);
    
    $('.submit-changes').closest('form').submit(function (e) { disable_submits() });
    $('.package').change();
    
    var $pkg = get_package_el();
    if ($pkg.length > 0) {
        var show_addons = $pkg.data('show-addons').toString();
        $.each(show_addons.split(","), function(key, addon_id) {
            var $addon = $('#package_addon_' + addon_id);
            $addon.change();
        });
    }
});

var $step_form = $('.step-form');
var $step_review = $('.step-review');

function show_form(e) {
    e.stopPropagation();
    $step_form.toggleClass('hide', false);
    $step_review.toggleClass('hide', true);
    return false;
}

function disable_submits(e)
{
    $('.button').each(function(index) {
        var original = $(this).val();
        $(this).val("Please wait..");
        $(this).data('original-value', original);
        $(this).attr("disabled", "disabled");
    });
    return true;
}

function enable_submits()
{
    $('.button').each(function( index ) {
        var original = $(this).data('original-value');
        $(this).val(original);
        $(this).removeAttr("disabled");
    });
    // var original = $('.button').data('original-value');
    // $('.button').val(original);
    // $('.button').removeAttr("disabled");
}

function show_review(e) {
    e.stopPropagation();
    e.preventDefault();
    
    var $pkg = get_package_el();
    var show_addons = $pkg.data('show-addons').toString();
    var show_addon_ids = show_addons.split(",");
    
    // verify something was changed
    var has_change = false;
    $.each(show_addon_ids, function(key, addon_id) {
        var addon_value = $('#package_addon_' + addon_id).val();
        var original_addon_value = $('#package_addon_' + addon_id).data('original-amount');
        if (addon_value != original_addon_value) {
            has_change = true;
        }
    });
    
    var new_package_id = parseInt($pkg.val());
    var original_package_id = parseInt($pkg.parent('select').data('original-package'));
    if (new_package_id != original_package_id) {
        has_change = true;
    }
    
    if (!has_change) {
        $('.review-error').text('Please make a change!');
        setTimeout(function() { $('.review-error').text(''); }, 3000);
        return false;
    }
    
    disable_submits();
    $('.review-error').text('');
    // $('.step-review').closest("form").one("submit", prevent_duplicate_form);
    // $('.step-form').closest("form").one("submit", prevent_duplicate_form);
    
    setTimeout(function() {
        hide_loader_overlay();
        $step_form.toggleClass('hide', true);
        $step_review.toggleClass('hide', false);
        enable_submits();
    }, 150);
    
    display_loader_overlay();
    return false;
}

function display_loader_overlay() {
    $('.preload-overlay-container, .preload-overlay-container-head').animate({
        opacity: .15
    }, 1);
    $('.preload-overlay-container').parent().append('<div class="preloader"></div>');
}

function hide_loader_overlay() {
    $('.preload-overlay-container, .preload-overlay-container-head').css('opacity', 1);
    $('.preload-overlay-container').parent().find('.preloader').remove();
}

function money_format(float_amount) {
    var amount = Math.round(float_amount * 100) / 100;
    amount = pad_zeros(amount, 2);
    return '$' + amount;
}

function pad_zeros(b, c)
{
    var d = b.toString(),
        a = d.indexOf(".");
    if (a == -1)
    {
        decimal_part_length = 0;
        d += c > 0 ? "." : ""
    }
    else
    {
        decimal_part_length = d.length - a - 1
    }
    a = c - decimal_part_length;
    if (a > 0)
    {
        for (var e = 1; e <= a; e++)
        {
            d += "0";
        }
    }
    return d;
}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
