<!-- FORM PENDAFTARAN -->
<div id="registration_page">

    <?php Form::begin('registration_form', 'registration/run', 'post'); ?>

    <div class="descrption radius_6 shadow_silver_4">
        <div class="tittle_1">
            FORM PENDAFTARAN KOPERASI DAN USAHA MIKRO, KECIL DAN MENENGAH (KUMKM) BARU
        </div>
        <div class="font_1"></div>
    </div>


    <fieldset>
        <legend class="tittle_1">DATA KUMKM</legend>
        <div class="font_1"></div>
        <table width="900" border="0" cellspacing="8" cellpadding="0">
            <tr>
                <th width="223"><?php Form::label('Company Name'); ?></th>
                <th width="18">:</th>
                <td width="627">
                    <?php
                    Form::create('text', 'company_name');
                    Form::tips('Please enter username');
                    Form::size(20);
                    Form::validation()->requaired('Username harus diisi.');
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th width="223"><?php Form::label('Address Line 1'); ?></th>
                <th width="18">:</th>
                <td width="627">
                    <?php
                    Form::create('textarea', 'address1');
                    Form::tips('Please enter street address, P.O. box, company name, c/o');
                    Form::size(40);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th width="223"><?php Form::label('Address Line 2'); ?></th>
                <th width="18">:</th>
                <td width="627">
                    <?php
                    Form::create('textarea', 'address2');
                    Form::tips('Please enter apartment, suite, unit, building, floor, etc.');
                    Form::size(40);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th width="217"><?php Form::label('Phone Number'); ?></th>
                <th width="22">:</th>
                <td width="629">
                    <?php
                    Form::create('text', 'phone');
                    Form::tips('Please enter your phone number');
                    Form::size(20);
                    Form::inputType()->numeric();
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>

        <div class="subtitle" style="margin-top:8px;border-bottom:1px dashed #CCC;">

        </div>
        <div class="font_1" align="justify"></div>
        <div class="font4" style="margin-top:4px;margin-bottom:10px;padding-top:15px;">
            <table width="900" border="0" cellspacing="8" cellpadding="0">
                <tr>
                    <th width="223"><?php Form::label('Subdomain'); ?></th>
                    <th width="18">:</th>
                    <td width="627">
                        <?php
                        Form::create('text', 'subdomain');
                        Form::tips('Please enter username');
                        Form::size(20);
                        Form::validation()->requaired();
                        Form::inputType()->alphaNumeric();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><?php Form::label('Company Web Address'); ?></th>
                    <th>:</th>
                    <th style="float:left;color:#000;"><strong>http://<span id="out_subdomain" class="font20"> </span>.<?php echo Web::$host; ?> </strong></th>
                </tr>
            </table>
        </div>
    </fieldset>


    <fieldset>

        <legend  class="tittle_1">DATA AKUN</legend>
        <div class="font_1"></div>
        <table width="900" border="0" cellspacing="8" cellpadding="0">
            <tr>
                <th width="223"><?php Form::label('Email Address'); ?></th>
                <th width="18">:</th>
                <td width="627">
                    <?php
                    Form::create('text', 'email');
                    Form::tips('Please enter your email address');
                    Form::size(40);
                    Form::validation()->requaired();
                    Form::validation()->email();
                    Form::validation()->remote('cekEmail', 'post');
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th width="223" valign="top" style="padding-top: 2px;"><?php Form::label('Password'); ?></th>
                <th width="18" valign="top" style="padding-top: 2px;">:</th>
                <td width="627">
                    <?php
                    Form::create('password', 'password');
                    Form::tips('Please enter password');
                    Form::size(20);
                    Form::validation()->requaired();
                    Form::validation()->minLength(6);
                    Form::passMeter();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th width="223"><?php Form::label('Confirm Password'); ?></th>
                <th width="18">:</th>
                <td width="627">
                    <?php
                    Form::create('password', 'confirm_password');
                    Form::tips('Please enter more password');
                    Form::size(20);
                    Form::validation()->requaired();
                    Form::validation()->equalTo('password');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <div class="requirements radius_6">
        <div class="font_1"></div>
        <div class="font_1">
            <?php
            Form::create('checkbox', 'requirements');
            Form::validation()->requaired();
            Form::commit();
            ?>
            Ya saya menyetujui.
        </div>
        <div>
            <?php
            Form::create('submit', 'btnRegister');
            Form::style('ok radius_6');
            Form::commit();
            ?>
        </div>

    </div>

    <?php Form::end(); ?>

</div>
