<div class="container">
    <div class="col-md-6 offset-md-3 mt-2">
        <span class="anchor" id="formChangePassword"></span>

        <!-- form card change password -->
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Change Mobile Number</h3>
            </div>
            <div class="card-body p-4">
                <form class="form" id="change_phone" action="" method="POST" role="form" autocomplete="off">
                    <div class="form-group">
                        <label for="oldPhone">Current Mobile</label>
                        <input type="text" class="form-control" id="oldPhone" maxlength="10" name="oldPhone" required="">
                    </div>
                    <div class="form-group">
                        <label for="newPhone">New Mobile Number</label>
                        <input type="text" class="form-control" id="newPhone" maxlength="10" name="newPhone" required="">
                        <span class="form-text small alert_message"></span>
                        <span class="form-text small success_message"></span>
                    </div>
                    <div class="form-group" id="otp_block" style="display: none;">
                        <label for="otp">OTP</label>
                        <input type="text" class="form-control" id="otp" maxlength="4" name="verifyotp" required="">
                        <span class="form-text small" id="otp_alert"></span>
                    </div>
                    <div class="form-group" id="send_btn">
                        <button type="button" id="send_otp" class="btn btn-success btn-lg float-right">Send OTP</button>
                    </div>
                    <div class="form-group" id="verify_btn" style="display: none;">
                        <button type="button" id="verifyBtn" class="btn btn-success btn-lg float-right">Verify</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /form card change password -->
    </div>
</div>
<script>
    function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = "";
        }
        });
    });
    }
    setInputFilter(document.getElementById("newPhone"), function(value) {
    return /^-?\d*$/.test(value); });
    setInputFilter(document.getElementById("oldPhone"), function(value) {
    return /^-?\d*$/.test(value); });                                                                    
   
    $(function() {
        $("#send_otp").on('click', function(e) {
            e.preventDefault();

            var change_phone = $("#change_phone");

            $.ajax({
                url: '<?= base_url('member/send_otp');?>',
                type: 'post',
                data: change_phone.serialize(),
                success: function(response){
                    if(response.status == 'success') {
                        $('#otp_block').show();
                        $('#send_otp').hide();
                        $('#verify_btn').show();
                        $(".success_message").html(response.message);
                        setTimeout(function(){ 
                            $(".success_message").html("");
                        }, 5000);
                    }else{
                        $(".alert_message").html(response.message);
                        setTimeout(function(){ 
                            $(".alert_message").html("");
                        }, 5000);
                    }
                }
            });
        });
    });

    $(function() {
        $("#verifyBtn").on('click', function(e) {
            e.preventDefault();

            var change_phone = $("#change_phone");

            $.ajax({
                url: '<?= base_url('member/UpdatePhoneNumber');?>',
                type: 'post',
                data: change_phone.serialize(),
                success: function(response){
                    if(response.status == 'success') {
                        $('#otp_block').hide();
                        $('#send_otp').show();
                        $('#verify_btn').hide();
                        $(".success_message").html(response.message);
                        setTimeout(function(){ 
                            $(".success_message").html("");
                        }, 5000);
                        $("#change_phone")[0].reset()
                    }else{
                        $(".alert_message").html(response.message);
                        setTimeout(function(){ 
                            $(".success_message").html("");
                        }, 5000);
                    }
                }
            });
        });
    });
</script>