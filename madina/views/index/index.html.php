<div id="box-content">
    &nbsp;
</div>

<div id="box-login">
    <?php
    Form::begin('frm_login', 'login/run', 'post');
    ?>
    <div class="view_message"></div>
    <table style="margin: 5px 0 0 0;">
        <tr>
            <td style="width: 100px;">
                <div class="label-ina">Nama User</div>
                <div class="label-eng">Username</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'username');
                Form::size(40);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label-ina">Kata Sandi</div>
                <div class="label-eng">Password</div>
            </td>
            <td>:</td>
            <td>
                <?php
                Form::create('password', 'password');
                Form::size(40);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <button id="btn_login">Login</button>
            </td>
        </tr>
    </table>
    <?php
    Form::end();
    ?>
</div>


<script>
    $(function() {
        var y = screen.height * 0.70;
        $('#box-content').css('min-height',  y + "px");
        
        $('#btn_login').button({
            icons: {
                primary: "ui-icon-locked"
            }
        });
        
        $('#box-login').dialog({
            title : 'Form Login',
            closeOnEscape: false,
            autoOpen: true,
            height: 250,
            width: 400,
            modal: true,
            resizable: false,
            draggable: false,
            open : function() {
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            }
        });
        
        $('#frm_login').live('submit', function(){
            var parent = $(this);
            var url = parent.attr('action');
            var data = parent.serialize();
            $.post(url, data, function(o){
                if (o[0]) {
                    window.location = o[1];
                } else {
                    $('.view_message', parent).html(o[1]);
                }
            }, 'json');
            return false;
        });
        
    });
</script>