<div class="box-static">
    <div>
        <div class="title fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="box-button fl-right">
            <a id="" href="<?php echo $link_back ?>" class="btn-red">Kembali</a>
        </div>
        <div class="cl"></div>
    </div>
    <div class="class-info box-green">
        <table class="fl-left" cellspacing="5" cellpadding="0">
            <tr>
                <td class="label">WALI KELAS</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php 
                        $guardian_name = '-';
                        if ($class_info['employees_id']!='000000000000') {
                            $guardian_name = $class_info['employess_name'];
                        }
                        echo $guardian_name; 
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">TOTAL MENGAJAR</td>
                <td class="sparator">:</td>
                <td class="content"><?php echo $class_info['teaching_total_time'] . ' Jam'; ?></td>
            </tr>
        </table>
        <table class="fl-right" cellspacing="5" cellpadding="0">
            <tr>
                <td class="label">TAHUN AKADEMIK</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    Form::create('hidden', 'hidden_period_id');
                    Form::value($class_info['period_id']);
                    Form::commit();
                    Form::create('hidden', 'hidden_semester_id');
                    Form::value($class_info['semester_id']);
                    Form::commit();
                    echo $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - ' . $class_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">MATA PELAJARAN</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    Form::create('hidden', 'hidden_subject_id');
                    Form::value($class_info['subject_id']);
                    Form::commit();
                    echo $class_info['subject_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">KKM</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    Form::create('hidden', 'hidden_mlc');
                    Form::value($class_info['mlc_value']);
                    Form::commit();
                    echo $class_info['mlc_value'];
                    ?>
                </td>
            </tr>
        </table>
        <div class="cl"></div>
    </div>
    <div id="box-score">
        <div id="tabs-score">
            <ul>
                <li><?php URL::link('#fragment-4', 'Nilai Rapor Tengah Semester') ?></li>
                <li><?php URL::link('#fragment-5', 'Nilai Rapor Akhir Semester') ?></li>
            </ul>
            <div id="fragment-4" style="background: #fff;">
                <div>
                    <div class="fl-left" style="font-weight: bold;font-style: italic;padding-top: 2px;">
                        Berikut adalah daftar Nilai Rapor Tengah Semester!
                    </div>
                    <div class="fl-right">
                        <?php
                        URL::link($link_score_save, "Simpan", true, array('id' => 'button_save_mid_score', 'class' => 'btn-blue'));
                        echo " ";
                        URL::link($link_score_export, "Export", true, array('id' => 'button_export_mid_score', 'class' => 'btn-blue'));
                        echo " ";
                        URL::link("#", "Import", true, array('id' => 'button_import_mid_score', 'class' => 'btn-blue'));
                        echo " ";
                        URL::link("#", "Refresh", true, array('id' => 'button_filter_mid_score', 'class' => 'btn-green'));
                        ?>
                    </div>
                    <div class="cl"></div>
                </div>

                <table id="list-mid-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0" action="<?php echo $link_score_read; ?>">
                    <thead>
                        <tr>
                            <td align="center" class="first" colspan="3" style="border-bottom: none;">NOMOR</td>
                            <td rowspan="2" align="center">NAMA SISWA</td>
                            <td style="width: 100px;" align="center" rowspan="2">NILAI</td>
                            <td style="width: 100px;" align="center" rowspan="2">KETERANGAN</td>
                        </tr>
                        <tr>
                            <td style="width: 40px;" align="center" class="first">URUT</td>
                            <td style="width: 80px;" align="center" >INDUK</td>
                            <td style="width: 80px;" align="center" >NISN</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="first" colspan="6">
                                <div class="information-box">
                                    Loading...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="fragment-5" style="background: #fff;">

                <div>
                    <div class="fl-left" style="font-weight: bold;font-style: italic;padding-top: 2px;">
                        Berikut adalah daftar Nilai Rapor Akhir Semester!
                    </div>
                    <div class="fl-right">
                        <?php
                        URL::link($link_score_save, "Simpan", true, array('id' => 'button_save_final_score', 'class' => 'btn-blue'));
                        echo " ";
                        URL::link($link_score_export, "Export", true, array('id' => 'button_export_final_score', 'class' => 'btn-blue'));
                        echo " ";
                        URL::link("#", "Import", true, array('id' => 'button_import_final_score', 'class' => 'btn-blue'));
                        echo " ";
                        URL::link("#", "Refresh", true, array('id' => 'button_filter_final_score', 'class' => 'btn-green'));
                        ?>
                    </div>
                    <div class="cl"></div>
                </div>

                <table id="list-final-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0"  action="<?php echo $link_score_read; ?>">
                    <thead>
                        <tr>
                            <td align="center" class="first" colspan="3" style="border-bottom: none;">NOMOR</td>
                            <td rowspan="2" align="center">NAMA SISWA</td>
                            <td style="width: 100px;" align="center" rowspan="2">NILAI</td>
                            <td style="width: 100px;" align="center" rowspan="2">KETERANGAN</td>
                        </tr>
                        <tr>
                            <td style="width: 40px;" align="center" class="first">URUT</td>
                            <td style="width: 80px;" align="center" >INDUK</td>
                            <td style="width: 80px;" align="center" >NISN</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="first" colspan="6">
                                <div class="information-box">
                                    Loading...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="box-import-mid-score">
    <?php
    Form::begin('form-import-mid-score', 'classgroup/importmidscore', 'post', true);
    ?>
    <div>File Nilai :</div>
    <div>
        <?php
        Form::create('file', 'file');
        Form::validation()->requaired();
        Form::validation()->accept('xls');
        Form::commit();
        ?>
    </div>
    <div style="margin: 5px 0;">
        <?php
        Form::create('submit');
        Form::value('Upload');
        Form::style('btn-green');
        Form::commit();
        echo ' ';
        Form::create('button');
        Form::value('Tutup');
        Form::style('btn-red');
        Form::commit();
        ?>
    </div>
    <?php
    Form::end();
    ?>
</div>

<div id="box-import-final-score">
    <?php
    Form::begin('form-import-final-score', 'classgroup/importfinalscore', 'post', true);
    ?>
    <div>File Nilai :</div>
    <div>
        <?php
        Form::create('file', 'file');
        Form::validation()->requaired();
        Form::validation()->accept('xls');
        Form::commit();
        ?>
    </div>
    <div style="margin: 5px 0;">
        <?php
        Form::create('submit');
        Form::value('Upload');
        Form::style('btn-green');
        Form::commit();
        echo ' ';
        Form::create('button');
        Form::value('Tutup');
        Form::style('btn-red');
        Form::commit();
        ?>
    </div>
    <?php
    Form::end();
    ?>
</div>

<script type="text/javascript">
    $(function(){
        var is_number = function(val) {
            var numbers = /^[0-9]+$/;
            if (numbers.test(val)) {
                return true;
            } else {
                return false;
            }
        };
        
        var is_empty = function(val) {
            if (val == '' || val == ' ' || val == null || typeof val == 'undefined') {
                return true;
            } else {
                return false;
            }
        };
        
        $("#tabs-score").tabs();
        
        var disabled_button = function(bool, button_id) {
            var $btn_save;
            for (var idx = 0; idx < button_id.length; idx++){
            
                $btn_save = $(button_id[idx]);
                
                if (bool) {
                    $btn_save.attr('disabled', 'disabled');
                } else {
                    $btn_save.removeAttr('disabled');
                }
            }
        };
        
        /* MID SCORE */
        disabled_button(true,['#button_save_mid_score','#button_export_mid_score','#button_import_mid_score']);
           
        $('#list-mid-score .score_list').live('change', function() {
            var mlc = $('#hidden_mlc').val();
            var val = $(this).val();
            var order = $(this).attr('order');
            var desc = '-';
            if (!is_empty(val)) {
                if (parseInt(val) > parseInt(mlc)) {
                    desc = 'Terlampaui';
                } else if (parseInt(val) == parseInt(mlc)){
                    desc = 'Tercapai';
                } else {
                    desc = 'Tidak Tercapai';
                }
                $(this).css('border','1px solid #ccc');
            } else {
                $(this).css('border','1px solid red');
            }
            
            $('#list-mid-score .desc_' + order).html(desc);
        });
        
        var readMidScore = function() {
            var link = $('#list-mid-score').attr('action');
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var mlc = $('#hidden_mlc').val();
            var type = 1; /* 1 : Tengah Semester */
            
            $(this).loadingProgress('start');
            
            $.post(link, {subject:subject, period:period, semester:semester, mlc:mlc, type:type}, function (o){
                $('#list-mid-score').children('tbody').attr('count',o.count);
                $('#list-mid-score').children('tbody').html(o.row); 
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_mid_score','#button_export_mid_score','#button_import_mid_score']);
                if (o.count > 0) {
                    $('#list-mid-score .score_list').numeric();
                }
            }, 'json');
        };
        
        readMidScore();
        
        $('#button_filter_mid_score').live('click',function(){
            readMidScore();
            return false;
        });
        
        $('#button_save_mid_score').live('click', function(){
            var url = $(this).attr('href');
            var id = new Array();
            var val, nis;
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var type = 1; /* 1 : Tengah Semester */
            var error_count = 0;
            var $list;
            
            for (var i = 1 ; i <= $('#list-mid-score').children('tbody').attr('count');i++) {
                $list = $('#list-mid-score #score_list_' + i);
                nis = $list.attr('order');
                val = $list.val();
                if (is_number(val)) {
                    if ( parseInt(val) >= 0 && parseInt(val) <= 100) {
                        id[i] = [nis,val];
                        $list.css('border','1px solid #ccc');
                    } else {
                        $list.css('border','1px solid red');
                        error_count++;
                    }
                } else {
                    $list.css('border','1px solid red');
                    error_count++;
                }
                
            }
                
            if (error_count == 0) {
                $(this).loadingProgress('start');
                $.post(url, {subject:subject, period:period, semester:semester, type:type, data:id}, function(o){
                    if (o) {
                        alert('Data Nilai Telah Disimpan.');
                    } else {
                        alert('Data Nilai Gagal Disimpan.');
                    }
                    $(this).loadingProgress('stop');
                }, 'json');
            } else {
                $(this).loadingProgress('stop');
            }
            
            return false;
        });
                
        $('#button_export_mid_score').live('click', function(){
            var type = 1; /* 1 : Tengah Semester */
            var conf = confirm("Anda yakin akan melakukan export data nilai?");
            if (conf) {
                window.location =  $(this).attr('href') + '.' + type;
            }  
            return false;
        });
        
        $('#box-import-mid-score').dialog({
            title : 'Import Nilai Rapor Tengah Semester',
            closeOnEscape: false,
            autoOpen: false,
            height: 180,
            width: 300,
            modal: true,
            resizable: false,
            draggable: true,
            open : function() {
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            }
        });
        
        $('#button_import_mid_score').live('click', function(){
            $("#box-import-mid-score").dialog( "open" );
            return false;
        });
        
        $('#form-import-mid-score input[type=button]').live('click', function(){
            $("#box-import-mid-score").dialog( "close" );
        });
        
        $('#form-import-mid-score').live('submit',function(){
            
            disabled_button(true,['#form-import-mid-score input[type=button]','#form-import-mid-score input[type=submit]']);
            $(this).ajaxSubmit({
                success : function(o) {
                    disabled_button(false,['#form-import-mid-score input[type=button]','#form-import-mid-score input[type=submit]']);
                    $("#box-import-mid-score").dialog( "close" );
                    readMidScore();
                }
            });
        
            return false;
        });
        
        /* FINAL SCORE */
        disabled_button(true,['#button_save_final_score','#button_export_final_score','#button_import_final_score']);
            
        $('#list-final-score .score_list').live('change', function() {
            var mlc = $('#hidden_mlc').val();
            var val = $(this).val();
            var order = $(this).attr('order');
            var desc = '-';
            if (!is_empty(val)) {
                if (parseInt(val) > parseInt(mlc)) {
                    desc = 'Terlampaui';
                } else if (parseInt(val) == parseInt(mlc)){
                    desc = 'Tercapai';
                } else {
                    desc = 'Tidak Tercapai';
                }
                $(this).css('border','1px solid #ccc');
            } else {
                $(this).css('border','1px solid red');
            }
            
            $('#list-final-score .desc_' + order).html(desc);
        });
        
        var readFinalScore = function() {
            var link = $('#list-final-score').attr('action');
            var score_type = $('#score_type_final').val();
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var mlc = $('#hidden_mlc').val();
            var type = 2; /* 1 : Tengah Semester */
            
            $(this).loadingProgress('start');
            
            $.post(link, {score_type:score_type, subject:subject, period:period, semester:semester, mlc:mlc, type:type}, function (o){
                $('#list-final-score').children('tbody').attr('count',o.count);
                $('#list-final-score').children('tbody').html(o.row);
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_final_score','#button_export_final_score','#button_import_final_score']);
                if (o.count > 0) {
                    $('#list-final-score .score_list').numeric();
                }
                
            }, 'json');
        };
        
        readFinalScore();
        
        $('#button_filter_final_score').live('click',function(){
            readFinalScore();
            return false;
        });
        
        
        $('#button_save_final_score').live('click', function(){
            var url = $(this).attr('href');
            var id = new Array();
            var val, nis;
            var score_type = $('#score_type_final').val();
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var type = 2; /* 1 : Tengah Semester */
            var error_count = 0;
            var $list;
                        
            for (var i = 1 ; i <= $('#list-final-score').children('tbody').attr('count');i++) {
                $list = $('#list-final-score #score_list_' + i);
                nis = $list.attr('order');
                val = $list.val();
                if (is_number(val)) {
                    if ( parseInt(val) >= 0 && parseInt(val) <= 100) {
                        id[i] = [nis,val];
                        $list.css('border','1px solid #ccc');
                    } else {
                        $list.css('border','1px solid red');
                        error_count++;
                    }
                } else {
                    $list.css('border','1px solid red');
                    error_count++;
                }
            }
                
            if (error_count == 0) {
                $.post(url, {score_type:score_type, subject:subject, period:period, semester:semester, type:type, data:id}, function(o){
                    if (o) {
                        alert('Data Nilai Telah Disimpan.');
                    } else {
                        alert('Data Nilai Gagal Disimpan.');
                    }
                    $(this).loadingProgress('stop');
                }, 'json');
            } else {
                $(this).loadingProgress('stop');
            }
            return false;
        });
        
        $('#button_export_final_score').live('click', function(){
            var type = 2; /* 1 : Tengah Semester */
            var conf = confirm("Anda yakin akan melakukan export data nilai?");
            if (conf) {
                window.location =  $(this).attr('href') + '.' + type;
            }  
            return false;
        });
        
        $('#box-import-final-score').dialog({
            title : 'Import Nilai Rapor Akhir Semester',
            closeOnEscape: false,
            autoOpen: false,
            height: 180,
            width: 300,
            modal: true,
            resizable: false,
            draggable: true,
            open : function() {
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            }
        });
        
        $('#button_import_final_score').live('click', function(){
            $("#box-import-final-score").dialog("open");
            return false;
        });
        
        $('#form-import-final-score input[type=button]').live('click', function(){
            $("#box-import-final-score").dialog( "close" );
        });
        
        $('#form-import-final-score').live('submit',function(){
            
            disabled_button(true,['#form-import-final-score input[type=button]','#form-import-final-score input[type=submit]']);
            $(this).ajaxSubmit({
                success : function(o) {
                    disabled_button(false,['#form-import-final-score input[type=button]','#form-import-final-score input[type=submit]']);
                    $("#box-import-final-score").dialog( "close" );
                    readFinalScore();
                }
            });
            return false;
        });
        
    });
</script>