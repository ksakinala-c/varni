<?php /* Smarty version Smarty-3.1.7, created on 2016-03-23 08:57:38
         compiled from "../ci/application/views/inc/footer.php" */ ?>
<?php /*%%SmartyHeaderCode:177520549056f20d2a4c9679-28439928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '582672b9ec1a40263067186fc9f6278c7e115ad3' => 
    array (
      0 => '../ci/application/views/inc/footer.php',
      1 => 1458702687,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '177520549056f20d2a4c9679-28439928',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'year' => 0,
    '_modals' => 0,
    'name' => 0,
    '_hl' => 0,
    '_extra_javascript' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f20d2a4f22a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f20d2a4f22a')) {function content_56f20d2a4f22a($_smarty_tpl) {?>          </div>
          <div class="push"></div>
        </div>

        <div class="row footer">
          <div class="small-4 columns end">
            <span class="">&copy; <?php echo $_smarty_tpl->tpl_vars['year']->value;?>
</span>
          </div>
          <div class="small-8 text-right columns">
          </div>
        </div>
      </div>
    </div>

    <div id="invoice-payment-confirm" style="display: none;">
      <div class="inline_content invoice-payment-confirm">
        <h2>Payment Confirmation</h2>
        <p>You're paying <span id="invoice-payment-balance">$0.00</span> via the <span id="invoice-payment-method"></span>.</p>
        <p>If this is not correct, please choose Cancel and then select your desired method.</p>
        <input type="submit" class="medium button invoice-payment-submit" value="Submit Payment" />
        <input type="submit" class="medium link button invoice-payment-cancel" value="Cancel" />
      </div>
    </div>

<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['name']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_modals']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
$_smarty_tpl->tpl_vars['name']->_loop = true;
?>
        <?php echo $_smarty_tpl->getSubTemplate (('inc/modal/').($_smarty_tpl->tpl_vars['name']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php } ?>
    <script src="/static/js/vendor/jquery.js"></script>
    <script src="/static/js/foundation.min.js"></script>
    <script src="/static/js/core.js"></script>
    <script src="/static/js/touch.js"></script>
    <script src="/static/js/dropdown.js"></script>
    <script src="/static/js/transition.js"></script>
    <script src="/static/js/lightbox.js"></script>
    <script src="/static/js/number.js"></script>
    <script src="/static/js/tooltip.js"></script>
    <script src="/static/js/checkbox.js"></script>
    <script src="/static/js/r1softlicenses-upgrades.js"></script>
    <script>

          // https://code.google.com/p/chromium/issues/detail?id=527343
          $(function() {
            if(navigator.userAgent.toLowerCase().indexOf('chrome/45') > -1) {
              $('table.support td').not( ".allow-ellipsis" ).css('display', 'inline');
              // setTimeout(function() {
              //   //$('td.allow-ellipsis').css('display', 'inline-block');
              //   $('td').not( ".allow-ellipsis" ).css('display', 'inline');
              // }, 50);
            }
          });

          $(document).foundation({topbar: {is_hover: true} });
          $(document).ready(function() { $('textarea.animated').autosize(); });
          
          $(document).ready(function() {
              $('select').dropdown();
              $("input[type=checkbox], input[type=radio]").checkbox();
              $('#invoice-payment-make').click(invoice_payment_make);
              $('.form-number').number();
              
              $(".contact-support").tooltip({ direction: "right", margin: -20 });
              
          });
          
          var submitted_payment = false;
          
          function invoice_payment_submit(e) {
            e.stopPropagation();
            e.preventDefault();
            if (submitted_payment) { return false; }
            submitted_payment = true;
            $('#invoice-payment-form').submit();
            $(this).attr('disabled', 'disabled');
            $(this).val('Please wait..');
            $('.invoice-payment-cancel, .fs-lightbox-close').remove();
            $('body').unbind('click touchstart');
          }
          
          function invoice_payment_make(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var pm_desc = $('#invoice-payment-source option:selected').data('pm-desc');
            $('#invoice-payment-method').text(pm_desc);
            $('#invoice-payment-balance').text('$' + $('#invoice-amount').val());
            
            var obj = $('#invoice-payment-confirm > .inline_content').clone();
            obj.children('.invoice-payment-cancel').click(function(e) { $.lightbox("close"); });
            obj.children('.invoice-payment-submit').click(invoice_payment_submit);
            
            $.lightbox(obj, {top: 100});
            return false;
          }


    </script>
    <script src="/static/js/app.js"></script>
    <script src="/static/js/jquery.autosize.js"></script>
    <script src="/static/js/jquery.payment.js"></script>
<?php if ($_smarty_tpl->tpl_vars['_hl']->value=='support'){?>
    <script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['_extra_javascript']->value){?>
    <script>
          <?php echo $_smarty_tpl->tpl_vars['_extra_javascript']->value;?>

    </script>
<?php }?>

  </body>
</html>
<?php }} ?>