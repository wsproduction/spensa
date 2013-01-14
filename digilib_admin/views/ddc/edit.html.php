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
        Form::begin('fAdd', 'ddc/update/' . $id, 'post');
        ?>
        <div>
            <table>
                <tr>
                    <td style="width: 200px;">Classification Number</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'callNumber');
                        Form::tips('Enter Call Number');
                        Form::value($dataEdit['ddc_classification_number']);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>        
                <tr>
                    <td>Level</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'level');
                        Form::tips('Chose Level DDC');
                        Form::validation()->requaired();
                        Form::option($ddcLevel, ' ', $dataEdit['ddc_level']);
                        Form::properties(array('link'=>'#'));
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr class="sub1" style="display: none;">
                    <td>Main Class</td>
                    <td>:</td>
                    <td class="sub1">
                        <?php
                        Form::create('select', 'sub1');
                        Form::tips('Chose Level DDC');
                        Form::option($listSub1[0],'',$listSub1[1]);
                        Form::properties(array('link'=>$link_sub2));
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr class="sub2" style="display: none;">
                    <td>Sub Class</td>
                    <td>:</td>
                    <td class="sub2">
                        <?php
                        Form::create('select', 'sub2');
                        Form::tips('Chose Level DDC');
                        Form::option($listSub2[0],'',$listSub2[1]);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Title</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'title');
                        Form::tips('Enter titel DDC');
                        Form::size(40,4);
                        Form::validation()->requaired();
                        Form::value($dataEdit['ddc_title']);
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
                        Form::value($dataEdit['ddc_description']);
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
        
        if ($('#level').val()==2) {
            $('tr.sub1').fadeIn('slow');
        } else if ($('#level').val()==3) {
            $('tr.sub1').fadeIn('slow');
            $('tr.sub2').fadeIn('slow');
        }
    
        /* WYSIWYG elRTE */
        elRTE.prototype.options.panels.web2pyPanel = [
            'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
            'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist',
            'link', 'image'
        ];
        elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel', 'tables'];
    
        var opts = {
            cssClass : 'el-rte',
            height   : 180,
            width    : 600,
            toolbar  : 'web2pyToolbar',
            cssfiles : ['css/elrte-inner.css']
        };
        
        $('#description').elrte(opts);
    
        /* BUTTON ACTION */
        $('#btnBack').live('click',function(){
            window.location = $(this).attr('link');
        });
    
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
                        $('#description').elrte('val',' ');
                        $(frmID)[0].reset();
                    }
                }
                $(msgID).html(o[2]).fadeIn('slow');
            }, 'json');
        
            return false;
        });
    
        /* CHANGE VALUE ACTIONS */  
        $('#level').live('change',function(){
            var url = $(this).attr('link');
            if ($(this).val()==2) {
                $('tr.sub1 td.sub1').html('<select id="sub1"><option value="">Loading...</option></select>');
                form_tips('sub1');
                $("#fAdd #sub1").rules("add",{
                    required : true
                });
                
                $.get(url, function(o){
                    $('tr.sub1 td.sub1').html(o);
                }, 'json');
            
                $('tr.sub1').fadeIn('slow');
            } else if ($(this).val()==3) {
                $('tr.sub1 td.sub1').html('<select id="sub1"><option value="">Loading...</option></select>');
                form_tips('sub1');
                $("#fAdd #sub1").rules("add",{
                    required : true
                });
                
                $.get(url, function(o){
                    $('tr.sub1 td.sub1').html(o);
                }, 'json');
            
            
                var sub2  = '<select id="sub2" name="sub2" tips="Chose Level DDC">';
                sub2 += '   <option value="" selected></option>';
                sub2 += '</select>';
                $('tr.sub2 td.sub2').html(sub2);
                form_tips('sub2');
                $("#fAdd #sub2").rules("add",{
                    required : true
                });
            
                $('tr.sub1').fadeIn('slow');
                $('tr.sub2').fadeIn('slow');
            } else {
                $("#fAdd #sub1").rules("add",{
                    required : false
                });
                $("#fAdd #sub2").rules("add",{
                    required : false
                });
                $('tr.sub1').fadeOut('slow');
                $('tr.sub2').fadeOut('slow');
            }
        });
        $('#sub1').live('change',function(){
            var url = $(this).attr('link');
            $('tr.sub2 td.sub2').html('<select id="sub2"><option value="">Loading...</option></select>');
            
            form_tips('sub2');
            $("#fAdd #sub2").rules("add",{
                required : true
            });
            
            $.get(url,{
                id:$(this).val()
            }, function(o){
                $('tr.sub2 td.sub2').html(o);
            }, 'json');
        
        });
    });
</script>
