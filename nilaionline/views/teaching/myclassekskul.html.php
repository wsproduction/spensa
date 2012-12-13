<div class="box-static">
    <div>
        <div class="title fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="box-button fl-right">
            <a href="../../teaching" class="btn-blue">Keluar Kelas</a>
        </div>
        <div class="cl"></div>
    </div>
    <div class="class-info box-green">
        <table class="fl-left" cellspacing="5" cellpadding="0">
            <tr>
                <td><b>Tahun Akademik</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_period_id');
                    Form::value($class_info['period_id']);
                    Form::commit();
                    Form::create('hidden', 'hidden_semester_id');
                    Form::value($semester_info['semester_id']);
                    Form::commit();
                    echo $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - ' . $semester_info['semester_name'];
                    ?>
                </td>
            </tr>
        </table>
        <div class="cl"></div>
    </div>
    <div id="box-score" class="box-static" style="margin: 5px;padding-top: 5px;">
        <?php
        Form::begin('fFilterDailyScore', 'teaching/readdailyscore/' . $class_info['extracurricular_coach_history_id'], 'post', true);
        ?>
        <table style="width: 100%">
            <tr>
                <td style="width: 210px;">Kelas :</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <?php
                    Form::create('select', 'base_competence');
                    Form::option($option_class);
                    Form::properties(array('style' => 'width:200px;'));
                    Form::commit();
                    ?>
                </td>
                <td>
                    <?php
                    Form::create('submit');
                    Form::value('Filter');
                    Form::commit();
                    ?>
                </td>
                <td align="right">
                    <?php
                    Form::create('button', 'button_save_daily_score');
                    Form::value('Simpan');
                    Form::commit();
                    echo ' | ';
                    Form::create('button', 'button_export_daily_score');
                    Form::value('Export');
                    Form::commit();
                    echo ' ';
                    Form::create('button', 'button_import_daily_score');
                    Form::value('Import');
                    Form::commit();
                    ?>
                </td>
            </tr>
        </table>
        <?php
        Form::end();
        ?>
        <table id="list-daily-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0">
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
                            Silahkan lakukan filter data terlebih dahulu!
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

<div id="box-import-daily-score">
    <?php
    Form::begin('form-import-daily-score', 'teaching/importdailyscore', 'post', true);
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
        Form::commit();
        echo ' ';
        Form::create('button');
        Form::value('Tutup');
        Form::commit();
        ?>
    </div>

    <?php
    Form::end();
    ?>
</div>

<script type="text/javascript">
    $(function(){
        
        $("#tabs-score").tabs();
       
        $('.score_list').live('change', function() {
            var mlc = $('#hidden_mlc').val();
            var val = $(this).val();
            var order = $(this).attr('order');
            var desc = '-';
            if (val!='') {
                if (parseInt(val) > parseInt(mlc)) {
                    desc = 'Terlampaui';
                } else if (parseInt(val) == parseInt(mlc)){
                    desc = 'Tercapai';
                } else {
                    desc = 'Tidak Tercapai';
                }
            }
            
            $('.desc_' + order).html(desc);
        });
        
        var disabled_button = function(bool, button_id) {
            var $btn_save;
            for (var idx = 0; idx < button_id.length; idx++){
            
                $btn_save = $(button_id[idx]);
                
                if (bool) {
                    $btn_save.attr('disabled', 'disabled');
                    $btn_save.css({'opacity':'0.8','filter':'alpha(opacity=80)'});
                } else {
                    $btn_save.removeAttr('disabled');
                    $btn_save.css({'opacity':'1','filter':'alpha(opacity=100)'});
                }
            }
        };
        
        /* DAILY SCORE SCRIPT */
        disabled_button(true,['#button_save_daily_score','#button_export_daily_score','#button_import_daily_score']);
        
        var readDailyScore = function() {
            var link = $('#fFilterDailyScore').attr('action');
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var base_competence = $('#base_competence').val();
            var score_type = $('#score_type').val();
            var mlc = $('#hidden_mlc').val();
            
            $(this).loadingProgress('start');
            
            $.post(link, {period:period, semester:semester, base_competence:base_competence, score_type:score_type, mlc:mlc}, function (o){
                $('#list-daily-score').children('tbody').attr('count',o.count);
                $('#list-daily-score').children('tbody').html(o.row);
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_daily_score','#button_export_daily_score','#button_import_daily_score']);
                if (o.count > 0) {
                    
                }
                
            }, 'json');
        };
        
        $('#fFilterDailyScore').submit(function(){
            readDailyScore();
            return false;
        });
        
        $('#box-import-daily-score').dialog({
            title : 'Import Nilai Harian',
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
        
        $('#button_save_daily_score').live('click', function(){
            var url = $(this).attr('link');
            var id = new Array();
            var val, nis;
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var base_competence = $('#base_competence').val();
            var score_type = $('#score_type').val();
            var error_count = 0;
            var $list;
            
            $(this).loadingProgress('start');
            
            for (var i = 1 ; i <= $('#list-daily-score').children('tbody').attr('count');i++) {
                $list = $('#list-daily-score #score_list_' + i);
                nis = $list.attr('order');
                val = $list.val();
                id[i] = [nis,val];
                if ( parseInt(val) >= 0 && parseInt(val) <= 100) {
                    $list.css('border','1px solid #ccc');
                } else {
                    $list.css('border','1px solid red');
                    error_count++;
                }
            }
                
            if (error_count == 0) {
                $.post(url, {period:period, semester:semester, data:id, base_competence:base_competence, score_type:score_type}, function(o){
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
            
            error_count = 0;
        });
        
        $('#button_import_daily_score').live('click', function(){
            $("#box-import-daily-score").dialog( "open" );
        });
        
        $('#form-import-daily-score input[type=button]').live('click', function(){
            $("#box-import-daily-score").dialog( "close" );
        });
        
        $('#button_export_daily_score').live('click', function(){
            var base_competence = $('#base_competence').val();
            var score_type = $('#score_type').val();
            var semester = $('#hidden_semester_id').val();
            window.location =  $(this).attr('link') + '_' + base_competence + '_' + score_type + '_' + semester;
        });
        
        $('#base_competence').live('change', function(){
            disabled_button(true,['#button_save_daily_score','#button_export_daily_score','#button_import_daily_score']);
        });
        
        $('#score_type').live('change', function(){
            disabled_button(true,['#button_save_daily_score','#button_export_daily_score','#button_import_daily_score']);
        });
        
        $('#form-import-daily-score').live('submit',function(){
            disabled_button(true,['#form-import-daily-score input[type=button]','#form-import-daily-score input[type=submit]']);
            $(this).ajaxSubmit({
                success : function(o) {
                    
                    disabled_button(false,['#form-import-daily-score input[type=button]','#form-import-daily-score input[type=submit]']);
                    $("#box-import-daily-score").dialog( "close" );
                    readDailyScore();
                    
                    var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>','');
                    if (parOut) {
                        var obj = eval('(' + parOut +')');
                    }
                }
            });
            return false;
        });
        
    });
</script>