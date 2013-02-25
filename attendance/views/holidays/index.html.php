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

<div id="box-add">
    <?php
    Form::begin('fAdd', 'holidays');
    ?>
    <div id="view-message"></div>
    <table>
        <tr>
            <td style="width: 200px;"><?php Form::label('Keterangan ', 'description'); ?></td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'description');
                Form::size(55);
                Form::validation()->requaired('*');
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td><?php Form::label('Tanggal ', 'sdate'); ?> <font color="#999">(mm/dd/yy)</font></td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'sdate');
                Form::validation()->requaired('*');
                Form::commit();

                Form::label(' s.d ', 'fdate');

                Form::create('text', 'fdate');
                Form::validation()->requaired('*');
                Form::validation()->largerDateFrom('#sdate');
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
                Form::value('Simpan');
                Form::style('action_save');
                Form::commit();
                ?>
            </td>
        </tr>
    </table>

    <?php
    Form::end();
    ?>
</div>

<script>
    $(function(){
        
        var action = 'create';
        var f_title = 'Formulir Tambah Daftar Hari Libur';
        var f_desc = '';
        var f_sdate = '';
        var f_fdate = '';
        
        var set_form = function(title, desc, sdate, fdate) {
            f_title = title;
            f_desc = desc;
            f_sdate = sdate;
            f_fdate = fdate;
        };
         
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
                    display : 'Tanggal <font color="#999"> (mm/dd/yy)</font>',
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
                        action = 'create';
                        set_form('Formulir Tambah Daftar Hari Libur','','','');
                        $('#box-add').dialog('open');
                    }
                }, {
                    name : 'Hilangkan Seleksi',
                    bclass : 'add',
                    onpress : function() {
                        $('#list tbody tr').removeClass('trSelected');
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
                                        $('#list').flexOptions({
                                            newp: 999
                                        }).flexReload();
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
                
        $('.edit').live('click', function(){
            
            var rel = $(this).attr('rel');
            var desc = $('#row' + rel).children('td:first').next('td').text();
            var sdate = $('#row' + rel).children('td:first').next('td').next('td').children('div').children('.start_date').text();
            var fdate = $('#row' + rel).children('td:first').next('td').next('td').children('div').children('.finish_date').text();
            
            action = 'update/' + rel;
            
            set_form('Formulir Edit Daftar Hari Libur', desc, sdate, fdate);
            
            $('#list tbody tr').removeClass('trSelected');
            $('#box-add').dialog('open');
        });
        
        /* ADD SCRIPT */        
        $('#box-add').dialog({
            title : '',
            closeOnEscape: false,
            autoOpen: false,
            height: 300,
            width: 500,
            modal: true,
            resizable: false,
            draggable: false,
            open : function() {
                $('.ui-dialog-title').text(f_title);
                $('#box-add #view-message').html('');
                $('#fAdd #description').val(f_desc);
                $('#fAdd #sdate').val(f_sdate);
                $('#fAdd #fdate').val(f_fdate);
            }
        });
        
        $('#fAdd #sdate').datepicker({
            changeMonth: true,
            changeYear: true
        });
    
        $('#fAdd #fdate').datepicker({
            changeMonth: true,
            changeYear: true
        });

        $('#fAdd').live('submit',function(){
            var parent = $(this);
            var url = $(parent).attr('action') + '/' + action;
            var data = $(parent).serializeArray();
            
            $.post(url, data, function(o){
                if (o[0]) {
                    if (o[1]) {
                        $(parent)[0].reset();
                    }
                }
                $('#view-message', parent).html(o[2]).fadeIn('slow');
            }, 'json');
            return false;
        });
        
    });
</script>