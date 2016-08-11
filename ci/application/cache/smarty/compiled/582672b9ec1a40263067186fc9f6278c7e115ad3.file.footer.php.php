<?php /* Smarty version Smarty-3.1.7, created on 2016-04-28 11:31:12
         compiled from "../ci/application/views/inc/footer.php" */ ?>
<?php /*%%SmartyHeaderCode:132664413756f2155e977726-40979491%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '582672b9ec1a40263067186fc9f6278c7e115ad3' => 
    array (
      0 => '../ci/application/views/inc/footer.php',
      1 => 1461820813,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '132664413756f2155e977726-40979491',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56f2155e9a080',
  'variables' => 
  array (
    '_modals' => 0,
    'name' => 0,
    '_hl' => 0,
    '_extra_javascript' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56f2155e9a080')) {function content_56f2155e9a080($_smarty_tpl) {?>
        <div class="footer">
            <div>
                &copy; 2016
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
              // $("input[type=checkbox], input[type=radio]").checkbox();
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

    <!-- Mainly scripts -->
    <script src="/static/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url('static/js/bootstrap.min.js');?>
"></script>
    <script src="<?php echo base_url('static/js/jquery.metisMenu.js');?>
"></script>
    <script src="<?php echo base_url('static/js/jquery.slimscroll.min.js');?>
"></script>

    <!-- Custom and plugin javascript-->
    <script src="<?php echo base_url('static/js/inspinia.js');?>
"></script>
    <script src="<?php echo base_url('static/js/pace.min.js');?>
"></script>

    <!-- iCheck -->
    <script src="<?php echo base_url('static/js/icheck.min.js');?>
"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    <script>
    function email_res(data) {
        var $el = $('#account-email .notice');
        $el.html(data.message);
        $el.toggle(true);
        $("input[name='save'], button[name='save']").removeAttr('disabled');
        $('.pfc').toggle(false);
        if (!data.success) {
            $el.removeClass('label-success').addClass('label label-danger');
        } else {
            $el.removeClass('label-danger').addClass('label label-success');
        }
    };

    function password_res(data) {
        var $el = $('#account-password .notice');
        $el.html(data.message);
        $el.toggle(true);
        $("input[name='save'], button[name='save']").removeAttr('disabled');
        $('.pfc').toggle(false);
        if (!data.success) {
            $el.removeClass('label-success').addClass('label label-danger');
        } else {
            $el.removeClass('label-danger').addClass('label label-success');
        }
    };

    $(document).ready(function() {
        $('#account-email form').submit(function(e) {
            e.stopPropagation();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: email_res,
                error: email_res,
                dataType: "json"});
            $('.pfc').toggle(true);
            $(".cl-hide").toggle(false);
            $("input[name='save'], button[name='save']").removeAttr('disabled');
            return false;
        });

        $('#account-password form').submit(function(e) {
            e.stopPropagation();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: password_res,
                error: password_res,
                dataType: "json"});
            $('.pfc').toggle(true);
            $(".cl-hide").toggle(false);
            $("input[name='save'], button[name='save']").removeAttr('disabled');
            return false;
        });
    });
    </script>

    <script src="/static/js/app.js"></script>
    <script src="/static/js/jquery.autosize.js"></script>
    <script src="/static/js/jquery.payment.js"></script>
<?php if ($_smarty_tpl->tpl_vars['_hl']->value=='support'){?>
    <script type="text/javascript" src="//api.filepicker.io/v2/filepicker.js"></script>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['_extra_javascript']->value){?>
    <script>
          <?php echo $_smarty_tpl->tpl_vars['_extra_javascript']->value;?>

    </script>
<?php }?>

  </body>
</html>
<?php }} ?>