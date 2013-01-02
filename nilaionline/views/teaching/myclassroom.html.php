<div class="box-static">
    <div>
        <div class="title fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="box-button fl-right">
            <a href="../../teaching" class="btn-nav-grey">Daftar Siswa</a>
            <a href="../../teaching" class="btn-nav-grey">Penilaian</a> &nbsp;
            <a href="../../teaching" class="btn-blue">Keluar Kelas</a>
        </div>
        <div class="cl"></div>
    </div>
    <div class="class-info box-green">
        <table class="fl-left" cellspacing="5" cellpadding="0">
            <tr>
                <td><b>Wali Kelas</b></td>
                <td><b>:</b></td>
                <td><?php echo $class_info['employess_name']; ?></td>
            </tr>
            <tr>
                <td><b>Total Mengajar</b></td>
                <td><b>:</b></td>
                <td><?php echo $class_info['teaching_total_time'] . ' Jam'; ?></td>
            </tr>
        </table>
        <table class="fl-right" cellspacing="5" cellpadding="0">
            <tr>
                <td><b>Tahun Akademik</b></td>
                <td><b>:</b></td>
                <td>
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
                <td><b>Mata Pelajaran</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_subject_id');
                    Form::value($class_info['subject_id']);
                    Form::commit();
                    echo $class_info['subject_name'];
                    ?>
                </td>
            </tr>
        </table>
        <div class="cl"></div>
    </div>
    <div id="box-student-list" style="display: none;">
        <table class="table-list" style="width: 100%" cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td style="width: 50px;" align="center" class="first">No</td>
                    <td style="width: 100px;" align="center" >NIS</td>
                    <td style="width: 120px;" align="center" >NISN</td>
                    <td>Nama</td>
                    <td style="width: 120px;" align="center" >Jenis Kelamin</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $html_list = '';
                $no = 1;
                foreach ($student_list as $row) {
                    $html_list .= '<tr>';
                    $html_list .= '     <td align="center" class="first">' . $no . '</td>';
                    $html_list .= '     <td align="center">' . $row['student_nis'] . '</td>';
                    $html_list .= '     <td align="center">' . $row['student_nisn'] . '</td>';
                    $html_list .= '     <td>' . $row['student_name'] . '</td>';
                    $html_list .= '     <td align="center">' . $row['gender_title'] . '</td>';
                    $html_list .= '</tr>';
                    $no++;
                }
                echo $html_list;
                ?>
            </tbody>
        </table>
    </div>
    <div id="box-score">
        <div id="tabs-score" style="width: 99%;">
            <ul>
                <li><?php URL::link('#fragment-1', 'Nilai Harian') ?></li>
                <li><?php URL::link('#fragment-2', 'Tugas') ?></li>
                <li><?php URL::link('#fragment-3', 'Sikap') ?></li>
                <li><?php URL::link('#fragment-4', 'Ulangan Tengah Semester') ?></li>
                <li><?php URL::link('#fragment-5', 'Ulangan Umum') ?></li>
            </ul>
            <div id="fragment-1">
                <?php
                Form::begin('fFilterDailyScore', 'teaching/readdailyscore/' . $class_info['classgroup_id'], 'post', true);
                ?>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 210px;">Kompetensi Dasar :</td>
                        <td style="width: 60px;">Type :</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            Form::create('select', 'base_competence');
                            Form::option($option_basecompetance);
                            Form::properties(array('style' => 'width:200px;'));
                            Form::commit();
                            ?>
                        </td>
                        <td>
                            <?php
                            Form::create('select', 'score_type');
                            Form::option($option_scoretype);
                            Form::properties(array('style' => 'width:50px;'));
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
                            Form::properties(array('link' => $link_save_daily_score));
                            Form::commit();
                            echo ' | ';
                            Form::create('button', 'button_export_daily_score');
                            Form::properties(array('link' => $link_export_dailyscore));
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
            <div id="fragment-2">
                <?php
                Form::begin('fFilterTaskScore', 'teaching/readtaskscore/' . $class_info['classgroup_id'], 'post', true);
                ?>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 210px;">Keterangan Tugas :</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            Form::create('select', 'task_description');
                            Form::option($option_taskdescription);
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
                            Form::create('button', 'button_save_task_score');
                            Form::value('Simpan');
                            Form::properties(array('link' => $link_save_task_score));
                            Form::commit();
                            echo ' | ';
                            Form::create('button', 'button_export_task_score');
                            Form::properties(array('link' => $link_export_taskscore));
                            Form::value('Export');
                            Form::commit();
                            echo ' ';
                            Form::create('button', 'button_import_task_score');
                            Form::value('Import');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
                Form::end();
                ?>
                <table id="list-task-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0">
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
            <div id="fragment-3">
                <?php
                Form::begin('fFilterAttitudeScore', 'teaching/readattitudescore/' . $class_info['classgroup_id'], 'post', true);
                ?>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <?php
                            Form::create('submit');
                            Form::value('Filter');
                            Form::commit();
                            ?>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td align="right">
                            <?php
                            Form::create('button', 'button_save_attitude_score');
                            Form::value('Simpan');
                            Form::properties(array('link' => $link_save_attitude_score));
                            Form::commit();
                            echo ' | ';
                            Form::create('button', 'button_export_attitude_score');
                            Form::properties(array('link' => $link_export_attitudescore));
                            Form::value('Export');
                            Form::commit();
                            echo ' ';
                            Form::create('button', 'button_import_attitude_score');
                            Form::value('Import');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
                Form::end();
                ?>
                <table id="list-attitude-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0">
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
            <div id="fragment-4">
                <?php
                Form::begin('fFilterMidScore', 'teaching/readmidscore/' . $class_info['classgroup_id'], 'post', true);
                ?>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <?php
                            Form::create('submit');
                            Form::value('Filter');
                            Form::commit();
                            ?>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td align="right">
                            <?php
                            Form::create('button', 'button_save_mid_score');
                            Form::value('Simpan');
                            Form::properties(array('link' => $link_save_mid_score));
                            Form::commit();
                            echo ' | ';
                            Form::create('button', 'button_export_mid_score');
                            Form::properties(array('link' => $link_export_midscore));
                            Form::value('Export');
                            Form::commit();
                            echo ' ';
                            Form::create('button', 'button_import_mid_score');
                            Form::value('Import');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
                Form::end();
                ?>
                <table id="list-mid-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0">
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
            <div id="fragment-5">
                <?php
                Form::begin('fFilterFinalScore', 'teaching/readfinalscore/' . $class_info['classgroup_id'], 'post', true);
                ?>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 80px;">Type :</td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            Form::create('select', 'score_type_final');
                            Form::option($option_scoretype);
                            Form::properties(array('style' => 'width:80px;'));
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
                        <td>
                            &nbsp;
                        </td>
                        <td align="right">
                            <?php
                            Form::create('button', 'button_save_final_score');
                            Form::value('Simpan');
                            Form::properties(array('link' => $link_save_final_score));
                            Form::commit();
                            echo ' | ';
                            Form::create('button', 'button_export_final_score');
                            Form::properties(array('link' => $link_export_finalscore));
                            Form::value('Export');
                            Form::commit();
                            echo ' ';
                            Form::create('button', 'button_import_final_score');
                            Form::value('Import');
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
                Form::end();
                ?>
                <table id="list-final-score" class="table-list" style="width: 100%;margin: 5px 0;" cellspacing="0" cellpading="0">
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

<div id="box-import-task-score">
    <?php
    Form::begin('form-import-task-score', 'teaching/importtaskscore', 'post', true);
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

<div id="box-import-attitude-score">
    <?php
    Form::begin('form-import-attitude-score', 'teaching/importattitudescore', 'post', true);
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

<div id="box-import-mid-score">
    <?php
    Form::begin('form-import-mid-score', 'teaching/importmidscore', 'post', true);
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

<div id="box-import-final-score">
    <?php
    Form::begin('form-import-final-score', 'teaching/importfinalscore', 'post', true);
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
        
        var is_empty = function(val) {
            if (val == '' || val == ' ' || val == null) {
                return true;
            } else {
                return false;
            }
        };
        
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
            var base_competence = $('#base_competence');
            if (is_empty(base_competence.val())) {
                base_competence.css('border-color','red');
            } else {
                base_competence.css('border-color','#ccc');
                readDailyScore();
            }
            
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
        
        /* TASK SCORE */
        disabled_button(true,['#button_save_task_score','#button_export_task_score','#button_import_task_score']);
        
        var readTaskScore = function() {
            var link = $('#fFilterTaskScore').attr('action');
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var task_description = $('#task_description').val();
            var mlc = $('#hidden_mlc').val();
            
            $(this).loadingProgress('start');
            
            $.post(link, {period:period, semester:semester, task_description:task_description, mlc:mlc}, function (o){
                $('#list-task-score').children('tbody').attr('count',o.count);
                $('#list-task-score').children('tbody').html(o.row);
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_task_score','#button_export_task_score','#button_import_task_score']);
                if (o.count > 0) {
                    
                }
                
            }, 'json');
        };
        
        $('#fFilterTaskScore').submit(function(){
            var task_description = $('#task_description');
            alert(task_description.val());
            if (is_empty(task_description.val())) {
                task_description.css('border-color','red');
            } else {
                task_description.css('border-color','#ccc');
                readTaskScore();
            }
            return false;
        });
        
        $('#task_description').live('change', function(){
            disabled_button(true,['#button_save_task_score','#button_export_task_score','#button_import_task_score']);
        });
        
        $('#button_save_task_score').live('click', function(){
            var url = $(this).attr('link');
            var id = new Array();
            var val, nis;
            var task_description = $('#task_description').val();
            var error_count = 0;
            var $list;
            
            $(this).loadingProgress('start');
            
            for (var i = 1 ; i <= $('#list-task-score').children('tbody').attr('count');i++) {
                $list = $('#list-task-score #score_list_' + i);
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
                $.post(url, {task_description:task_description, data:id}, function(o){
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
        
        $('#button_export_task_score').live('click', function(){
            var task_description = $('#task_description').val();
            window.location =  $(this).attr('link') + '_' + task_description;
        });
        
        $('#box-import-task-score').dialog({
            title : 'Import Nilai Tugas',
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
        
        $('#button_import_task_score').live('click', function(){
            $("#box-import-task-score").dialog( "open" );
        });
        
        $('#form-import-task-score input[type=button]').live('click', function(){
            $("#box-import-task-score").dialog( "close" );
        });
        
        $('#form-import-task-score').live('submit',function(){
            disabled_button(true,['#form-import-task-score input[type=button]','#form-import-task-score input[type=submit]']);
            $(this).ajaxSubmit({
                success : function(o) {
                    disabled_button(false,['#form-import-task-score input[type=button]','#form-import-task-score input[type=submit]']);
                    $("#box-import-task-score").dialog( "close" );
                    readTaskScore();
                }
            });
            return false;
        });
        
        /* ATTITUDE SCORE */
        disabled_button(true,['#button_save_attitude_score','#button_export_attitude_score','#button_import_attitude_score']);
        
        var readAttitudeScore = function() {
            var link = $('#fFilterAttitudeScore').attr('action');
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var mlc = $('#hidden_mlc').val();
            
            $(this).loadingProgress('start');
            
            $.post(link, {subject:subject, period:period, semester:semester, mlc:mlc}, function (o){
                $('#list-attitude-score').children('tbody').attr('count',o.count);
                $('#list-attitude-score').children('tbody').html(o.row);
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_attitude_score','#button_export_attitude_score','#button_import_attitude_score']);
                if (o.count > 0) {
                    
                }
                
            }, 'json');
        };
        
        $('#fFilterAttitudeScore').submit(function(){
            readAttitudeScore();
            return false;
        });
        
        $('#button_save_attitude_score').live('click', function(){
            var url = $(this).attr('link');
            var id = new Array();
            var val, nis;
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var error_count = 0;
            var $list;
            
            $(this).loadingProgress('start');
            
            for (var i = 1 ; i <= $('#list-attitude-score').children('tbody').attr('count');i++) {
                $list = $('#list-attitude-score #score_list_' + i);
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
                $.post(url, {subject:subject, period:period, semester:semester, data:id}, function(o){
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
        
        $('#button_export_attitude_score').live('click', function(){
            var semester = $('#hidden_semester_id').val();
            window.location =  $(this).attr('link') + '_' + semester;
        });
        
        $('#box-import-attitude-score').dialog({
            title : 'Import Nilai Sikap',
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
        
        $('#button_import_attitude_score').live('click', function(){
            $("#box-import-attitude-score").dialog( "open" );
        });
        
        $('#form-import-attitude-score input[type=button]').live('click', function(){
            $("#box-import-attitude-score").dialog( "close" );
        });
        
        $('#form-import-attitude-score').live('submit',function(){
            disabled_button(true,['#form-import-attitude-score input[type=button]','#form-import-attitude-score input[type=submit]']);
            $(this).ajaxSubmit({
                success : function(o) {
                    disabled_button(false,['#form-import-attitude-score input[type=button]','#form-import-attitude-score input[type=submit]']);
                    $("#box-import-attitude-score").dialog( "close" );
                    readAttitudeScore();
                }
            });
            return false;
        });
        
        /* MID SCORE */
        disabled_button(true,['#button_save_mid_score','#button_export_mid_score','#button_import_mid_score']);
        
        var readMidScore = function() {
            var link = $('#fFilterMidScore').attr('action');
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var mlc = $('#hidden_mlc').val();
            
            $(this).loadingProgress('start');
            
            $.post(link, {subject:subject, period:period, semester:semester, mlc:mlc}, function (o){
                $('#list-mid-score').children('tbody').attr('count',o.count);
                $('#list-mid-score').children('tbody').html(o.row);
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_mid_score','#button_export_mid_score','#button_import_mid_score']);
                if (o.count > 0) {
                    
                }
                
            }, 'json');
        };
        
        $('#fFilterMidScore').submit(function(){
            readMidScore();
            return false;
        });
        
        $('#button_save_mid_score').live('click', function(){
            var url = $(this).attr('link');
            var id = new Array();
            var val, nis;
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var error_count = 0;
            var $list;
            
            $(this).loadingProgress('start');
            
            for (var i = 1 ; i <= $('#list-mid-score').children('tbody').attr('count');i++) {
                $list = $('#list-mid-score #score_list_' + i);
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
                $.post(url, {subject:subject, period:period, semester:semester, data:id}, function(o){
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
                
        $('#button_export_mid_score').live('click', function(){
            var semester = $('#hidden_semester_id').val();
            window.location =  $(this).attr('link') + '_' + semester;
        });
        
        $('#box-import-mid-score').dialog({
            title : 'Import Nilai UTS',
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
        
        var readFinalScore = function() {
            var link = $('#fFilterFinalScore').attr('action');
            var score_type = $('#score_type_final').val();
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var mlc = $('#hidden_mlc').val();
            
            $(this).loadingProgress('start');
            
            $.post(link, {score_type:score_type, subject:subject, period:period, semester:semester, mlc:mlc}, function (o){
                $('#list-final-score').children('tbody').attr('count',o.count);
                $('#list-final-score').children('tbody').html(o.row);
                
                $(this).loadingProgress('stop');
                disabled_button(false,['#button_save_final_score','#button_export_final_score','#button_import_final_score']);
                if (o.count > 0) {
                    
                }
                
            }, 'json');
        };
        
        $('#fFilterFinalScore').submit(function(){
            readFinalScore();
            return false;
        });
        
        
        $('#button_save_final_score').live('click', function(){
            var url = $(this).attr('link');
            var id = new Array();
            var val, nis;
            var score_type = $('#score_type_final').val();
            var subject = $('#hidden_subject_id').val();
            var period = $('#hidden_period_id').val();
            var semester = $('#hidden_semester_id').val();
            var error_count = 0;
            var $list;
            
            $(this).loadingProgress('start');
            
            for (var i = 1 ; i <= $('#list-final-score').children('tbody').attr('count');i++) {
                $list = $('#list-final-score #score_list_' + i);
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
                $.post(url, {score_type:score_type, subject:subject, period:period, semester:semester, data:id}, function(o){
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
        
        $('#button_export_final_score').live('click', function(){
            var score_type = $('#score_type_final').val();
            var semester = $('#score_type_final').val();
            window.location =  $(this).attr('link') + '_' + semester + '_' + score_type;
        });
        
        $('#box-import-final-score').dialog({
            title : 'Import Nilai ULUM',
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
            $("#box-import-final-score").dialog( "open" );
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