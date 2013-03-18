<div>
    <div class="fl-left">
        <?php Form::begin('form_login', 'login/run', 'post', false); ?>
        <div class="box-login">
            <div class="title">Formulir Login!</div>

            <div class="message" style="margin-bottom: 5px;"></div>

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
            <div style="margin-top: 5px;">
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
        <div class="box-front">
            <div class="title">
                Meshplace
            </div>
            <div class="sub-title">
                Your achievement is our pride.
            </div>
            <div class="description">
                Selamat datang wargi SMP Negeri 1 Subang, nikmati fasilitas Meshplace untuk mendukung pembelajaran. Berikut beberapa fitur yang terdapat di Meshplace :
            </div>

            <div class="box-fitur">
                <div class="fl-left">
                    <?php
                    echo Src::image('1360855682_collaboration.png');
                    ?>
                </div>
                <div class="fitur-content fl-left">
                    <div class="title">Kolaborasi Belajar</div>
                    <div class="description">
                        Dengan fitur ini memugnkinkan wargi SMP Negeri 1 Subang untuk bertukar informasi khusunya dalam hal pembelajaran.
                        <a href="#">Pelajari selengkapnya &RightArrow;</a>
                    </div>
                </div>
                <div class="cl">&nbsp;</div>
            </div>

            <div class="box-fitur">
                <div class="fl-left">
                    <?php
                    echo Src::image('1360857068_application_view_tile.png');
                    ?>
                </div>
                <div class="fitur-content fl-left">
                    <div class="title">Aplikasi</div>
                    <div class="description">
                        Aplikasi yang terdapat pada Sekolah+ diantaranya, Nilai Online, HOTS (Hight Order Thinking Skill), Test Online.
                        <a href="#">Pelajari selengkapnya &RightArrow;</a>
                    </div>
                </div>
                <div class="cl">&nbsp;</div>
            </div>

            <div class="box-fitur">
                <div class="fl-left">
                    <?php
                    echo Src::image('1360857498_folder_games.png');
                    ?>
                </div>
                <div class="fitur-content fl-left">
                    <div class="title">Hiburan</div>
                    <div class="description">
                        Fitur hiburan ini diantaranya, Game, Media Player, Cerita Bergambar.
                        <a href="#">Pelajari selengkapnya &RightArrow;</a>
                    </div>
                </div>
                <div class="cl">&nbsp;</div>
            </div>
            <div class="cl">&nbsp;</div>
        </div>

        <div class="copy-right">
            <div class="fl-left" style="margin-top: 4px;">
                <?php
                echo Src::image('icon.png', null, array('style'=>'width:32px;'));
                ?>
            </div>
            <div class="fl-left" style="margin-left: 10px;">
                <div>&copy; 2013 Mesh</div>
                <div style="font-weight: bold;">ICT SMP Negeri 1 Subang</div>
                <div>Jln. Letjen Soeprapto No. 105 Subang 41211 Telp. (0260) 411403 Fax. (0260) 411404  &nbsp; Email : ict@smpn1subang.sch.id</div>
                <div style="margin-top: 5px;padding-top: 4px;border-top: 1px dashed #ebebeb;"><b> Developer : </b> Warman Suganda | <b> Powered by : </b> WSFramework</div>
            </div>
            <div class="cl">&nbsp;</div>
        </div>
    </div>


</div>


<script type="text/javascript">
    $(function () {
        $('#username').focus();
        $('#form_login').live('submit',function(){
            var message = $('.box-login .message');
            var parent = $(this);
            var action = $(parent).attr('action');
            var data = $(parent).serialize();
            var temp_username = $('#username').val();
            
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
                            $(parent)[0].reset();
                            $('#username').val(temp_username).focus();
                        }
                    });
                }
            });
            return false;
        });
    });
</script>