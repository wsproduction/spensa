<?php Form::begin('form_login', 'login/run', 'post', false); ?>
<div class="box-login">
    <div class="message"></div>
    <?php Form::label('Username :', 'username'); ?>
    <div>
        <?php
        Form::create('text', 'username');
        Form::validation()->requaired();
        Form::commit();
        ?>
    </div>
    <?php Form::label('Password :', 'password'); ?>
    <div>
        <?php
        Form::create('password', 'password');
        Form::validation()->requaired();
        Form::commit();
        ?>
    </div>
    <div>
        <?php
        Form::create('submit', 'button_login');
        Form::value('Login');
        Form::commit();
        ?>
    </div>
</div>
<?php Form::end(); ?>

<script type="text/javascript">
    $(function () {
        $('#form_login').live('submit',function(){
            var loading = $('#loading-progress');
            var message = $('.box-login .message');
            var parent = $(this);
            var action = $(parent).attr('action');
            var data = $(parent).serialize();
        
            $.ajax({
                url : action,
                data : data,
                type : 'post',
                dataType : 'xml',
                beforeSend : function() {
                    $(loading).slideDown('fast');
                },
                success : function(results) {
                    $(loading).slideUp('fast');
                    $(results).find('data').each(function(){
                        var status = $(this).find('status').text();
                        if (status == '1') {
                            window.location = $(this).find('direct').text();
                        } else {
                            $(message).html($(this).find('message').text());
                        }
                    });
                }
            });
            return false;
        });
    });
</script>