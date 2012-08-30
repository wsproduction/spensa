<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php            
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link'=>$link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'members/create', 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Full Name</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'full_name');
                        Form::tips('Enter Full Name');
                        Form::size(40);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Gender</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'gender');
                        Form::tips('Select Gender');
                        Form::option(array('L'=>'Laki-Laki','P'=>'Perempuan'),' ');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Birth Place & Date</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'birthplace');
                        Form::tips('Enter Birth Place');
                        Form::size(40);
                        Form::commit();
                        for ($i=1;$i<=31;$i++) {
                            $date[$i] = $i;
                        }
                        Form::create('select', 'birth_date');
                        Form::tips('Select Date');
                        Form::option($date,' ');
                        Form::commit();
                        $month = array(
                                    1=>'Januari',
                                    2=>'Februari',
                                    3=>'Maret',
                                    4=>'April',
                                    5=>'Mei',
                                    6=>'Juni',
                                    7=>'Juli',
                                    8=>'Agustus',
                                    9=>'September',
                                    10=>'Oktober',
                                    11=>'November',
                                    12=>'Desember'
                            );
                        Form::create('select', 'birth_month');
                        Form::tips('Select Month');
                        Form::option($month,' ');
                        Form::commit();
                        for ($i=1970;$i<=date('Y');$i++)
                            $years[$i] = $i;
                        Form::create('select', 'birth_years');
                        Form::tips('Select Years');
                        Form::option($years,' ');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Address</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'address');
                        Form::tips('Enter Address');
                        Form::size(40, 4);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Email</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'email');
                        Form::tips('Enter Email<br>Expm: username@domain.com');
                        Form::validation()->email();
                        Form::size(40);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Photo</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('file', 'photo');
                        Form::size(40);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Status</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'status');
                        Form::tips('Select Status');
                        Form::option(array(1 => 'Enabled',0 => 'Disabled'),' ');
                        Form::validation()->requaired();
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
                        Form::style('action_save');
                        Form::commit();
                        Form::create('reset', 'btnReset');
                        Form::value('Reset');
                        Form::style('action_cancel');
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
