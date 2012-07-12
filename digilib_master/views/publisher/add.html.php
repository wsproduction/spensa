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
        Form::begin('fAdd', 'publisher/create', 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Name</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'name');
                        Form::tips('Enter Publisher Name');
                        Form::size(40);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td>Address</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'address');
                        Form::tips('Enter Publisher Address');
                        Form::size(40,4);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Phone Number</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'phoneNumber');
                        Form::tips('Enter Phone Number');
                        Form::inputType()->numeric(' ');
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
                        Form::tips('Enter Fax.');
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
                        Form::tips('Enter Publisher Email<br><i>example: myemail@domain.com</i>');
                        Form::size(50);
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
                        Form::size(50);
                        Form::tips('Enter Pubisher Website<br><i>example: www.domain.com</i>');
                        Form::commit();
                        ?>
                    </td>
                </tr>  
                <tr>
                    <td valign="top">Description</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'description');
                        Form::tips('Enter Description');
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
