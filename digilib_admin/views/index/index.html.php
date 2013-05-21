<center>
    <div class="signin">
        <div>
            <?php
            echo Src::image('logo.png');
            ?>
        </div>
        <div id="message"></div>
        <div>
            <?php
            Form::begin('fLogin', 'login/run', 'post');
            ?>
            <div>
                <?php
                Form::create('text', 'username');
                Form::size(30);
                Form::validation()->requaired();
                Form::commit();
                ?>
            </div>
            <div>
                <?php
                Form::create('password', 'password');
                Form::size(30);
                Form::validation()->requaired();
                Form::commit();
                ?>
            </div>
            <div>
                <?php
                Form::create('submit', 'btnLgoin');
                Form::value('SIGN IN');
                Form::commit();
                ?>
            </div>
            <div class="keepme">
                <?php
                Form::create('checkbox', 'btnLgoin');
                Form::commit();
                echo 'Keep me sign in'
                ?>
            </div>
            <?php
            Form::end();
            ?>
        </div>
    </div>
</center>

<script>
    $(function() {
        $('#username').focus();
        $('#fLogin').live('submit', function() {
            frmID = $(this);
            msgID = $('#message');
            var url = $(frmID).attr('action');
            var data = $(frmID).serialize();
            $(this).loadingProgress('start');
            $(msgID).fadeOut('slow');
            $.post(url, data, function(o) {
                if (o[0]) {
                    window.location = o[1];
                } else {
                    $(frmID)[0].reset();
                    $(this).loadingProgress('stop');
                    $(msgID).html(o[1]).fadeIn('slow');
                    $('#username').focus();
                }
            }, 'json');
            return false;
        });
    });
</script>