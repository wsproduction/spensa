<div style="margin: 10px;" id="account_setting">

    <h1>Account Setting</h1>
    <br>
    <div>  
        <div class="box">

            <h2>
                Ganti Password
            </h2> 

            <br>

            <?php
            Form::begin('f_change_password', 'account/changepassword', 'post', true);
            ?>
            <div id="view-message"></div>
            <table cellpadding="5" cellspacing="5">
                <tr>
                    <td style="width: 120px;">Password Lama</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('password', 'old_password');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Password Baru</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('password', 'new_password');
                        Form::validation()->requaired();
                        Form::validation()->minLength(8);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <div id="pwdMeter" class="neutral">Very Weak</div>
                    </td>
                </tr>
                <tr>
                    <td>Ulang Password Baru</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('password', 'confirm_old_password');
                        Form::validation()->requaired();
                        Form::validation()->equalTo('#new_password');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <?php
                        Form::create('submit', 'btn_save');
                        Form::value('Simpan');
                        Form::style('btn-green');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
            <?php
            Form::end();
            ?>
        </div>
    </div>
</div>

<script>
    $(function(){
        
        $('#new_password').pwdMeter({
            displayGeneratePassword: true,
            generatePassText: 'Password Generator',
            generatePassClass: 'GeneratePasswordLink',
            RandomPassLength: 13
        });
        
        $('#f_change_password').live('submit', function(){
            
            var data = $(this).serialize();
            var url = $(this).attr('action');
                
            $.post(url, data, function(o){
                $('#f_change_password #view-message').html(o[1]);
            }, 'json');
            return false;
        });
    });
</script>