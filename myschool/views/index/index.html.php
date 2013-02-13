<div>
    
    <div class="fl-left">
        <?php Form::begin('form_login', 'login/run', 'post', false); ?>
        <div class="box-login">
            <div class="title">LOGIN</div>
            
            <div class="message"></div>
            <?php Form::label('Username :', 'username'); ?>
            <div>
                <?php
                Form::create('text', 'username');
                Form::validation()->requaired('Username wajib diisi.');
                Form::commit();
                ?>
            </div>
            <?php Form::label('Password :', 'password'); ?>
            <div>
                <?php
                Form::create('password', 'password');
                Form::validation()->requaired('Password wajib diisi.');
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
            <div style="margin: 10px 0;">
                <?php
                URL::link('#', 'Tidak dapat mengakses akun?');
                ?>
            </div>
        </div>
        <?php Form::end(); ?>
    </div>
    
    <div class="fl-left">
        <div>
            <?php
                            echo Src::image('cover.png');
            ?>
        </div>
    </div>
    
    <div class="cl">&nbsp;</div>
</div>


<script type="text/javascript">
    $(function () {
        $('#form_login').live('submit',function(){
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
                    $(this).loadingProgress('start');
                },
                success : function(results) {
                    $(results).find('data').each(function(){
                        var status = $(this).find('status').text();
                        if (status == '1') {
                            window.location = $(this).find('direct').text();
                        } else {
                            $(this).loadingProgress('stop');
                            $(message).html($(this).find('message').text());
                        }
                    });
                }
            });
            return false;
        });
    });
</script>