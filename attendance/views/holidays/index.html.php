<fieldset>
    <legend>Data Filter</legend>
    <div>
        <?php Form::begin('fFilter', 'attendance/read', 'post'); ?>
        <table>
            <tr>
                <td style="width: 100px;"><?php Form::label('Tahun ', 'years'); ?></td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('select', 'years');
                    Form::option($option_year, null, date('Y'));
                    Form::commit();
                    ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <?php
                    Form::create('submit', 'bSubmit');
                    Form::value('Filter');
                    Form::style('action_search');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>

        <?php Form::end(); ?>
    </div>
</fieldset>
<br>
<table id="list" title="<?php echo Web::getTitle(); ?>" link_c="<?php echo $link_c; ?>" link_r="<?php echo $link_r; ?>" link_d="<?php echo $link_d; ?>" style="display: none;">
</table>

<div>
    <?php
    Form::begin('fAdd', 'holidays/addsave');
    ?>
    
    
    
    <?php
    Form::end();
    ?>
</div>

<script>
    $(function(){
         
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID',
                    name : 'id',
                    sortable : true,
                    align : 'center',
                    width : 50
                }, {
                    display : 'Keterangan',
                    align : 'left',
                    width : 300
                }, {
                    display : 'Tanggal (dd/mm/yy)',
                    align : 'center',
                    width : 140
                    
                }, {
                    display : 'Pilihan',
                    align : 'center',
                    width : 80
                }],
            buttons : [ {
                    name : 'Tambah',
                    bclass : 'add',
                    onpress : function() {
                        $('#box-add-attendance').dialog('open');
                    }
                }, {
                    name : 'Hapus',
                    bclass : 'delete',
                    onpress : function() {
                        var leng = $('#list' + ' .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');
                
                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $('#list' + ' .trSelected td[abbr=id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });
                        
                                $.post($('#list').attr('link_d'), {
                                    id : tempId.join(',')
                                }, function(o){
                                    if (o) {
                                        $('#list').flexReload();
                                    } else {
                                        alert('Process delete failed.');
                                    }                            
                                }, 'json');
                            }
                        }
                    }
                }],
            nowrap : false,
            usepager : true,
            title : $('#list').attr('title'),
            useRp : false,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : screen.height * 0.40,
            onSubmit: function() {
                var dt = $('#fFilter').serializeArray();
                $('#list').flexOptions({
                    params: dt
                });
                return true;
            }
        });  
        
        /* Hidden Navigation Page In Footer Flexigrid */
        $('.pDiv2 .pGroup :first').css('display','none');
        $('.pDiv2 .pGroup :first').next('.btnseparator').css('display','none');
        $('.pDiv2 .pGroup :first').next('.btnseparator').next('.pGroup').css('display','none');
        $('.pDiv2 .pGroup :first').next('.btnseparator').next('.pGroup').next('.btnseparator').css('display','none');
        $('.pDiv2 .pGroup :first').next('.btnseparator').next('.pGroup').next('.btnseparator').next('.pGroup').css('display','none');
        $('.pDiv2 .pGroup :first').next('.btnseparator').next('.pGroup').next('.btnseparator').next('.pGroup').next('.btnseparator').css('display','none');
    
        $('#fFilter').live('submit',function(){            
            $('#list').flexOptions({
                newp: 999
            }).flexReload();
            return false;
        });
           
    });
</script>