<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php
            Form::create('button', 'btnBack');
            Form::value('Kembali');
            Form::style('action_back');
            Form::properties(array('link' => $link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'booksource/create', 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">
                        <div class="label-ina">Keterangan Pengarang</div>
                        <div class="label-eng">Book Source Description</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'title');
                        Form::tips('Masukan keterangan sumber');
                        Form::size(40);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td>
                        <div class="label-ina">Status</div>
                    </td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'status');
                        Form::tips('Pilih status');
                        Form::option(array('0' => 'Disabled', '1' => 'Enabled'));
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

<script>

    $(function(){    
     
        /* SUBMIT ACTIONS */    
        $('#fAdd').live('submit',function(){
            frmID = $(this);
            msgID = $('#message');
            var url =  $(frmID).attr('action');
            var data =  $(frmID).serialize();
        
            $(msgID).fadeOut('slow');
            $(this).loadingProgress('start');
            $.post(url, data, function(o){
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
        $('#btnBack').live('click',function(){
            window.location = $(this).attr('link');
        });
    
    });
</script>
