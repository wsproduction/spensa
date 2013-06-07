<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'user/updateaccount', 'post');
            ?>
            <div>
                <table>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Password Sekarang</div>
                            <div class="label-eng">Current Password</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('password', 'curent_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->remote('cekcurentpassword', 'post');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Password Baru</div>
                            <div class="label-eng">New Password</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('password', 'new_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->rangeLength(6, 30);
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">
                            <div class="label-ina">Ulang Password Baru</div>
                            <div class="label-eng">Confirm New Password</div>
                        </td>
                        <td>:</td>
                        <td>
                            <?php
                            Form::create('password', 'confirm_new_password');
                            Form::tips("<div class='tips-ina'>Masukan Nama Lengkap</div><div class='tips-eng'>Enter Fullname</div>");
                            Form::size(40);
                            Form::validation()->requaired();
                            Form::validation()->rangeLength(6, 30);
                            Form::validation()->equalTo('#new_password');
                            Form::style('form-grey');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            Form::create('submit', 'btnSave');
                            Form::value('Save');
                            Form::style('button-mid-solid-blue');
                            Form::commit();
                            Form::create('reset', 'btnReset');
                            Form::value('Reset');
                            Form::style('button-mid-solid-red');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            Form::end();
            ?>
        </div>
    </div>
</div>

<script>
    $(function() {

        /* SUBMIT ACTIONS */
        $('#fAdd').live('submit', function() {
            frmID = $(this);
            msgID = $('#message');
            var url = $(frmID).attr('action');
            var data = $(frmID).serialize();

            $(msgID).fadeOut('slow');
            $(this).loadingProgress('start');
            $.post(url, data, function(o) {
                $(this).loadingProgress('stop');
                if (o[0]) {
                    if (o[1]) {
                        $(frmID)[0].reset();
                    }
                }
                $(msgID).html(o[2]).fadeIn('slow');
            }, 'json');

            return false;
        });

        /* BUTTON ACTION */
        $('#btnBack').live('click', function() {
            window.location = $(this).attr('link');
        });

    });
</script>
