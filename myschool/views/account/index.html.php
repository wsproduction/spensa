<div style="margin: 10px;">

    <h1>Account Setting</h1>
    <br>
    <div>
        <h3>
            Ganti Password
        </h3>   
        <div>
            <?php
            Form::begin('f_change_password', 'account/changepassword', 'post', true);
            ?>
            <table>
                <tr>
                    <td>Password Lama</td>
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
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Ulang Password Baru</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('password', 'confirm_old_password');
                        Form::validation()->requaired();
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