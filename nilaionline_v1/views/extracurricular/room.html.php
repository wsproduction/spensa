<div class="box-static">
    <div>
        <div class="title fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="box-button fl-right">
            <a id="" href="<?php echo $link_back ?>" class="btn-red">Kembali</a>
        </div>
        <div class="cl"></div>
    </div>
    <div class="class-info box-green">
        <table cellspacing="5" cellpadding="0">
            <tr>
                <td class="label">TAHUN AKADEMIK</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $class_info['period_years_start'] . ' / ' . $class_info['period_years_end'] . ' - ' . $class_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">NAMA KEGIATAN</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $class_info['extracurricular_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">TOTAL JAM</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $class_info['extracurricular_coach_history_totaltime'] . ' Jam';
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
    Form::begin('form-import-mid-score', 'extracurricular/importscore/1', 'post', true);
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
    Form::begin('form-import-final-score', 'extracurricular/importscore/2', 'post', true);
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
        
        var mlc = 80;
        
        /* Read Score */
        var readScore = function(table, mlc, type, button_list) {
            var link = $(table).attr('action');
            
            $(this).loadingProgress('start');
            
            $.post(link, {mlc:mlc, type:type}, function (o){
                
                $(table).children('tbody').attr('count', o.count);
                $(table).children('tbody').html(o.row); 
                
                $(this).loadingProgress('stop');
                disabled_button(false, button_list);
                if (o.count > 0) {
                    $(table + ' .score_list').numeric();
                }
            }, 'json');
        };
        
        /* Change Score */
        var changeScore = function(table, list_class, mlc) {
            $(table + ' ' + list_class).live('change', function() {
                var val = $(this).val();
                var order = $(this).attr('order');
                var desc = '-';
                if (!is_empty(val)) {
                    if (val == 'A') {
                        desc = 'Sangat Baik';
                    } else if (val == 'B'){
                        desc = 'Baik';
                    } else {
                        desc = 'Cukup';
                    }
                    $(this).css('border','1px solid #ccc');
                } else {
                    $(this).css('border','1px solid red');
                }
            
                $(table + ' .desc_' + order).html(desc);
            });
        };
        
        /* Import Dialog */
        var importDialog = function(id, title) {
            $(id).dialog({
                title : title,
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
        };
        
        /* Save Score */
        var saveScore = function(url, type, table) {
            var id = new Array();
            var val, nis;
            var error_count = 0;
            var $list;
            
            for (var i = 1 ; i <= $(table).children('tbody').attr('count');i++) {
                $list = $(table + ' #score_list_' + i);
                nis = $list.attr('order');
                val = $list.val();
                if (!is_empty(val)) {
                    id[i] = [nis,val];
                    $list.css('border','1px solid #ccc');
                } else {
                    $list.css('border','1px solid red');
                    error_count++;
                }
                
            }
                
            if (error_count == 0) {
                $(this).loadingProgress('start');
                $.post(url, {type:type, data:id}, function(o){
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
        };
        
        /* MID SCORE */
        var table_midscore = '#list-mid-score';
        var listclass_midscore = '.score_list';
        var type_midscore = 1;
        var button_list_midscore = ['#button_save_mid_score','#button_export_mid_score','#button_import_mid_score'];
        var import_dialog_midscore = '#box-import-mid-score';
        
        disabled_button(true ,button_list_midscore);
        readScore(table_midscore, mlc, type_midscore, button_list_midscore);
        changeScore(table_midscore, listclass_midscore, mlc);
        importDialog(import_dialog_midscore, 'Import Nilai Rapor Tengah Semester');
        
        $('#button_filter_mid_score').live('click',function(){
            readScore(table_midscore, mlc, type_midscore, button_list_midscore);
            return false;
        });
        
        $('#button_save_mid_score').live('click', function(){
            saveScore($(this).attr('href'), type_midscore, table_midscore);
            return false;
        });
                
        $('#button_export_mid_score').live('click', function(){
            var conf = confirm("Anda yakin akan melakukan export data nilai?");
            if (conf) {
                window.location =  $(this).attr('href') + '.' + type_midscore;
            }  
            return false;
        });
        
        
        $('#button_import_mid_score').live('click', function(){
            $(import_dialog_midscore).dialog("open");
            return false;
        });
        
        $('#form-import-mid-score input[type=button]').live('click', function(){
            $(import_dialog_midscore).dialog("close");
        });
        
        $('#form-import-mid-score').live('submit',function(){
            
            disabled_button(true, button_list_midscore);
            $(this).ajaxSubmit({
                success : function(o) {
                    disabled_button(false, button_list_midscore);
                    $("#box-import-mid-score").dialog( "close" );
                    if (o == 'true') {
                        readScore(table_midscore, mlc, type_midscore, button_list_midscore);
                    } else if (o == 'error') {
                        alert('Format data tidak sesuai');
                    } else {
                        alert('Prposes Import Gagal');
                    }
                }
            });
        
            return false;
        });
        
        /* FINAL SCORE */
        var table_finalscore = '#list-final-score';
        var listclass_finalscore = '.score_list';
        var type_finalscore = 2;
        var button_list_finalscore = ['#button_save_final_score','#button_export_final_score','#button_import_final_score'];
        var import_dialog_finalscore = '#box-import-final-score';
        
        disabled_button(true ,button_list_finalscore);
        readScore(table_finalscore, mlc, type_finalscore, button_list_finalscore);
        changeScore(table_finalscore, listclass_finalscore, mlc);
        importDialog(import_dialog_finalscore, 'Import Nilai Rapor Akhir Semester');
        
        $('#button_filter_final_score').live('click',function(){
            readScore(table_finalscore, mlc, type_finalscore, button_list_finalscore);
            return false;
        });
        
        $('#button_save_final_score').live('click', function(){
            saveScore($(this).attr('href'), type_finalscore, table_finalscore);
            return false;
        });
        
        $('#button_export_final_score').live('click', function(){
            var conf = confirm("Anda yakin akan melakukan export data nilai?");
            if (conf) {
                window.location =  $(this).attr('href') + '.' + type_finalscore;
            }  
            return false;
        });
                
        $('#button_import_final_score').live('click', function(){
            $(import_dialog_finalscore).dialog("open");
            return false;
        });
        
        $('#form-import-final-score input[type=button]').live('click', function(){
            $(import_dialog_finalscore).dialog( "close" );
        });
        
        $('#form-import-final-score').live('submit',function(){
            disabled_button(true, button_list_finalscore);
            $(this).ajaxSubmit({
                success : function(o) {
                    disabled_button(false, button_list_finalscore);
                    $(import_dialog_finalscore).dialog( "close" );
                    if (o == 'true') {
                        readScore(table_finalscore, mlc, type_finalscore, button_list_finalscore);
                    } else if (o == 'error') {
                        alert('Format data tidak sesuai');
                    } else {
                        alert('Proses Import Gagal.');
                    }
                }
            });
            return false;
        });
        
    });
</script>