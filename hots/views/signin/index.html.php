<div class="simple" style="height: 782px;">
    <center>
        <div class="form-login">
            <h2 class="no-border">SIGN IN</h2>
            <div class="cl">&nbsp;</div>
            <?php
            Form::begin('fLogin', 'signin/run', 'post', true);
            ?>
            <div class="view-message"></div>
            <div style="margin-top: 5px;">NOMOR INDUX SISWA</div>
            <div>
                <?php
                Form::create('text', 'nis');
                Form::tips('Please enter username');
                Form::commit();
                ?>
            </div>
            <div style="margin-top: 5px;">PASSWORD</div>
            <div>
                <?php
                Form::create('password', 'password');
                Form::tips('Please enter password');
                Form::commit();
                ?>
            </div>
            <div style="margin-top: 5px;">
                <?php
                Form::create('submit');
                Form::value('Login');
                Form::commit();

                echo '&nbsp; | ';

                URL::link('http://' . Web::$host . 'fogrgot', 'Forgot Password');
                ?>
            </div>
            <?php
            Form::end();
            ?>
        </div>
    </center>
    <div class="cl">&nbsp;</div>
</div>
