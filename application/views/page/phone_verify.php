<div class="container">
    <div class="col-md-6 offset-md-3 mt-2">
        <span class="anchor" id="formChangePassword"></span>

        <!-- form card change password -->
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Mobile Verifiation</h3>
            </div>
            <div class="card-body p-4">
                <form class="form" id="change_phone" action="" method="POST" role="form" autocomplete="off">
                    <div class="form-group">
                        <p id="sent_msg">An OTP has been send on your given number : +91 <?= $this->phone;?></p>
                        <p class="success_message"></p>
                        <p class="alert_message"></p>
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
    $(function() {
        $("#send_otp").on('click', function(e) {
            e.preventDefault();

           
            $.ajax({
                url: '<?= base_url('member/send_otp');?>',
                type: 'post',
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
                url: '<?= base_url('member/VerifyPhoneNumber');?>',
                type: 'post',
                data: change_phone.serialize(),
                success: function(response){
                    if(response.status == 'success') {
                        $('#otp_block').hide();
                        $('#verify_btn').hide();
                        $('#sent_msg').hide();
                        $(".success_message").html(response.message);
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