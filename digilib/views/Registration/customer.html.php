<!-- FORM PENDAFTARAN -->
<div id="registration_page">

    <?php Form::begin('registration_form', 'customer/run', 'post'); ?>

    <div class="descrption radius_6 shadow_silver_4">
        <div class="tittle_1">
            CUSTOMER REGISTRATION
        </div>
        <div class="font_1" ></div>
    </div>

    <fieldset>
        <legend class="tittle_1">PROFILE</legend>
        <div class="font_1"></div>
        <table width="900" border="0" cellspacing="8" cellpadding="0">
            <tr>
                <th width="223"><?php Form::label('Full Name'); ?></th>
                <th width="18">:</th>
                <td width="627">
                    <?php
                    Form::create('text', 'full_name');
                    Form::tips('Please enter your full name');
                    Form::size(40);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php Form::label('Gender'); ?></th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('select', 'gender');
                    Form::tips('Please select your gender');
                    Form::option($genderList, '-- Select --');
                    Form::validation()->requaired();
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
                <th><?php Form::label('City'); ?></th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('text', 'city');
                    Form::tips('Please enter your city');
                    Form::size(40);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php Form::label('State / Province / Region'); ?></th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('text', 'state');
                    Form::tips('Please enter your state / province / region');
                    Form::size(40);
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th width="223"><?php Form::label('Zip Code'); ?></th>
                <th width="18">:</th>
                <td width="627">
                    <?php
                    Form::create('text', 'zip_code');
                    Form::tips('Please enter zip code');
                    Form::size(6);
                    Form::maxlength(6);
                    Form::inputType()->numeric();
                    Form::validation()->requaired();
                    Form::validation()->maxLength(5);
                    Form::validation()->minLength(5);
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php Form::label('Country'); ?></th>
                <th>:</th>
                <td>
                    <?php
                    Form::create('select', 'country');
                    Form::tips('Please select your country');
                    Form::option($countryList, '-- Select --');
                    Form::validation()->requaired();
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <th width="223"><?php Form::label('Phone Number'); ?></th>
                <th width="18">:</th>
                <td width="627">
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
    </fieldset>


    <fieldset>
        <legend class="tittle_1">ACCOUNT</legend>
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
        <div class="font_1">
            Apakah adnda menyetujui persyaratan yang sudah di tentukan, jika anda sjudah yakin silahkan centang cekbox dibawah ini :
        </div>
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
            Form::create('submit','btnRegister');
            Form::style('ok radius_6');
            Form::commit();
            ?>
        </div>
        	
    </div>

    <?php Form::end(); ?>
</div>
