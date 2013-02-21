<fieldset>
    <legend>Data Filter</legend>
    <div>
        <?php Form::begin('fFilter', 'attendance/read', 'post'); ?>
        <table>
            <tr>
                <td style="width: 120px;"><?php Form::label('Nama', 'sdate'); ?></td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('select', 'name');
                    Form::option($option_name);
                    Form::properties(array('multiple' => 'multiple'));
                    Form::commit();

                    Form::create('hidden', 'nameid');
                    Form::value(0);
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
                    Form::validation()->requaired();
                    Form::commit();

                    Form::label(' s.d. ', 'fdate');

                    Form::create('text', 'fdate');
                    Form::validation()->requaired();
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

<div id="box-add-attendance">
    <?php
    Form::begin('fAddAttendance', 'teacher/addattendance', 'post', true);
    ?>

    <table>
        <tr>
            <td style="width: 100px;">Nama</td>
            <td>:</td>
            <td>
                <?php
                Form::create('select', 'name');
                Form::option($option_name);
                Form::properties(array('multiple' => 'multiple'));
                Form::commit();

                Form::create('hidden', 'nameid');
                Form::value(0);
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'sdate');
                Form::validation()->requaired();
                Form::commit();
                ?>
            </td>
        </tr>
        <tr>
            <td>Jam</td>
            <td>:</td>
            <td>
                <?php
                Form::create('text', 'sdate');
                Form::validation()->requaired();
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

<div id="box-edit-description">
    <?php
    Form::begin('fEditDescription', 'teacher/editdescription', 'post', true);
    ?>

    <table>
        <tr>
            <td></td>
        </tr>
    </table>

    <?php
    Form::end();
    ?>
</div>

<script>
    $(function(){
        
        $("#fFilter #name").multiselect({
            selectedText: "# dari # dipilih",
            noneSelectedText: 'Pilih Nama Guru'
        }).multiselectfilter();
    
        $('#sdate').datepicker({
            changeMonth: true,
            changeYear: true
        });
    
        $('#fdate').datepicker({
            changeMonth: true,
            changeYear: true
        });
            
        $('#list').flexigrid({
            url : $('#list').attr('link_r'),
            dataType : 'xml',
            colModel : [ {
                    display : 'ID',
                    align : 'center',
                    width : 50
                }, {
                    display : 'NIP',
                    align : 'center',
                    width : 110
                }, {
                    display : 'NUPTK',
                    align : 'center',
                    width : 100
                    
                }, {
                    display : 'Nama',
                    align : 'left',
                    width : 250
                }, {
                    display : 'Jenis Kelamin',
                    align : 'center',
                    width : 80
                }, {
                    display : 'Tanggal',
                    align : 'center',
                    width : 80
                }, {
                    display : 'Jam Datang',
                    align : 'center',
                    width : 100
                }, {
                    display : 'Jam Pulang',
                    align : 'center',
                    width : 80
                }, {
                    display : 'Keterangan',
                    align : 'center',
                    width : 100
                }, {
                    display : 'Pilihan',
                    align : 'center',
                    width : 80
                }],
            buttons : [ {
                    name : 'Lupa Check In / Out',
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
                                $('#list' + ' .trSelected td[abbr=ddc_id] div').each(function() {
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
            
            var array_of_checked_values = $("#name").multiselect("getChecked").map(function(){
                return this.value;	
            }).get();
            
            $('#nameid').val(array_of_checked_values.join(','));
            
            $('#list').flexOptions({
                newp: 999
            }).flexReload();
            return false;
        });
        
        $('#fTReport').live('submit');
        
        $('#btnBack').live('click',function(){
            window.location = $(this).attr('link');
        });
        
        $('#box-add-attendance').dialog({
            title : 'Formulir Lupa Check In/Out',
            closeOnEscape: false,
            autoOpen: false,
            height: 300,
            width: 500,
            modal: true,
            resizable: false,
            draggable: false
        });
        
        $('#box-edit-description').dialog({
            title : 'Formulir Perbaharui Keterangan',
            closeOnEscape: false,
            autoOpen: false,
            height: 300,
            width: 500,
            modal: true,
            resizable: false,
            draggable: false
        });
        
        $('.edit').live('click',function(){
            $('#box-edit-description').dialog('open');
        });
    
    });
</script>