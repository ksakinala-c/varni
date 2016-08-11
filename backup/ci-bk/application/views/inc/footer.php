          </div>
          <div class="push"></div>
        </div>

        <div class="row footer">
          <div class="small-4 columns end">
            <span class="">&copy; {$year}</span>
          </div>
          <div class="small-8 text-right columns">
          </div>
        </div>
      </div>
    </div>
{literal}
    <div id="invoice-payment-confirm" style="display: none;">
      <div class="inline_content invoice-payment-confirm">
        <h2>Payment Confirmation</h2>
        <p>You're paying <span id="invoice-payment-balance">$0.00</span> via the <span id="invoice-payment-method"></span>.</p>
        <p>If this is not correct, please choose Cancel and then select your desired method.</p>
        <input type="submit" class="medium button invoice-payment-submit" value="Submit Payment" />
        <input type="submit" class="medium link button invoice-payment-cancel" value="Cancel" />
      </div>
    </div>
{/literal}
{foreach from=$_modals item=name}
        {include 'inc/modal/'|cat:$name}
{/foreach}
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
{literal}
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

{/literal}
    </script>
    <script src="/static/js/app.js"></script>
    <script src="/static/js/jquery.autosize.js"></script>
    <script src="/static/js/jquery.payment.js"></script>
{if $_hl eq 'support'}
    <script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
{/if}
{if $_extra_javascript}
    <script>
          {$_extra_javascript}
    </script>
{/if}

  </body>
</html>
