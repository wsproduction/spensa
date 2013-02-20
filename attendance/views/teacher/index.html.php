
<fieldset>
    <legend>Data Filter</legend>
    <div>
        <?php Form::begin('fFilter', 'attendance/read', 'post'); ?>
        <table>
            <tr>
                <td style="width: 80px;"><?php Form::label('Nama', 'sdate'); ?></td>
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
                <td><?php Form::label('Tanggal ', 'sdate'); ?></td>
                <td>:</td>
                <td>
                    <?php
                    Form::create('text', 'sdate');
                    Form::validation()->requaired();
                    Form::commit();

                    Form::label(' s.d ', 'fdate');

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

<script>
    $(function(){
        
        $("#name").multiselect({
            selectedText: "# of # selected"
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
                    width : 40,
                    sortable : true,
                    hide : true
                }, {
                    display : 'NIP',
                    name : 'ddc_classification_number',
                    width : 110,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'NUPTK',
                    name : 'ddc_classification_number',
                    width : 100,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Nama',
                    name : 'ddc_title',
                    width : 250,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Jenis Kelamin',
                    name : 'ddc_title',
                    width : 80,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Tanggal',
                    name : 'ddc_classification_number',
                    width : 80,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Jam Datang',
                    name : 'ddc_level',
                    width : 100,
                    sortable : true,
                    align : 'center',
                    hide : true
                }, {
                    display : 'Jam Pulang',
                    name : 'option',
                    width : 80,
                    align : 'center'
                }, {
                    display : 'Keterangan',
                    name : 'option',
                    width : 80,
                    align : 'center'
                }, {
                    display : 'Option',
                    name : 'ddc_classification_number',
                    width : 80,
                    sortable : true,
                    align : 'left'
                }],
            buttons : [ {
                    name : 'Lupa Check In / Out',
                    bclass : 'add',
                    onpress : function() {
                        window.location = $('#list').attr('link_c');
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
            sortname : "ddc_id",
            sortorder : "asc",
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
    
    });
</script>