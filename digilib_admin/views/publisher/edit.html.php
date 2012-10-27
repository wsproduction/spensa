<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php            
            Form::create('button', 'btnBack');
            Form::value('Kembali');
            Form::style('action_back');
            Form::properties(array('link'=>$link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'publisher/update/' . $id, 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Nama</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'name');
                        Form::tips('Masukan nama penerbit');
                        Form::size(40);
                        Form::value($dataEdit['publisher_name']);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td valign="top">Alamat</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'address');
                        Form::tips('Masukan alamat penerbit');
                        Form::size(60,4);
                        Form::value($dataEdit['publisher_address']);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. Telephone</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'phoneNumber');
                        Form::tips('Masukan nomor telephone');
                        Form::inputType()->numeric(' ');
                        Form::value($dataEdit['publisher_phone']);
                        Form::commit();
                        ?>
                    </td>
                </tr>  
                <tr>
                    <td style="width: 200px;">Fax.</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'fax');
                        Form::tips('Masukan Fax.');
                        Form::inputType()->numeric(' ');
                        Form::value($dataEdit['publisher_fax']);
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
                        Form::tips('Masukan email<br><i>Contoh: myemail@domain.com</i>');
                        Form::size(50);
                        Form::value($dataEdit['publisher_email']);
                        Form::validation()->email();
                        Form::commit();
                        ?>
                    </td>
                </tr>  
                <tr>
                    <td style="width: 200px;">Website</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'website');
                        Form::tips('Masukan website<br><i>Contoh: www.domain.com</i>');
                        Form::size(50);
                        Form::value($dataEdit['publisher_website']);
                        Form::commit();
                        ?>
                    </td>
                </tr>  
                <tr>
                    <td valign="top">Keterangan</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'description');
                        Form::tips('Masukan keterangan.');
                        Form::value($dataEdit['publisher_description']);
                        Form::size(80,4);
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
