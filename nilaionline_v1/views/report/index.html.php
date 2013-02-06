<div class="box-static">
    <div class="title">
        <div class="fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="fl-right">
            <a href="<?php echo $link_back; ?>" class="btn-red">Kembali</a>
        </div>
        <div class="cl">&nbsp;</div>
    </div>
    <div class="class-info box-green">
        <table id="teacher-information" cellspacing="6" cellpadding="5" style="width: 100%;">
            <tr>
                <td class="label" style="width: 120px;">TAHUN AKADEMIK</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $guardian_info['period_years_start'] . '/' . $guardian_info['period_years_end'] . ' - ' . $guardian_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">KELAS</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $guardian_info['grade_title'] . ' (' . $guardian_info['grade_name'] . ') ' . $guardian_info['classroom_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">JUMLAH SISWA</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    echo $guardian_info['student_count'] . ' Siswa';
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="box-score-check" style="margin: 0 5px;">
        <div class="box-frame-check">
            <?php
            Form::begin('fScoreCheck', 'report/preview', 'post', true);
            Form::create('hidden', 'hidden_classgroup');
            Form::value($guardian_info['classgroup_id']);
            Form::commit();
            ?>
            <table class="frame-form">
                <tr>
                    <td><b>Nama Siswa :</b></td>
                    <td><b>Keterangan Rapor :</b></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <?php
                        Form::create('select', 'student');
                        Form::option($optionStudent);
                        Form::properties(array('style' => 'width:250px;'));
                        Form::commit();
                        ?>
                    </td>
                    <td>
                        <?php
                        Form::create('select', 'report_description');
                        Form::option(array('ts'=>'Tengah Semester', 'as' => 'Akhir Semester'));
                        Form::properties(array('style' => 'width:120px;'));
                        Form::commit();
                        ?>
                    </td>
                    <td>
                        <?php
                        Form::create('submit', 'btn_preview');
                        Form::style('btn-green');
                        Form::value('Pratinjau');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
            <?php
            Form::end();
            ?>
        </div>
        <div class="cl">&nbsp;</div>
    </div>
    <div class="view-score"  style="border: 1px solid #ccc;margin: 0 5px 5px 5px;">
        <div class="information-box" style="margin: 5px;">
            Untuk melihat laporan hasil belajar siswa silahkan pilih nama siswa dan keterangan rapor kemudian klik tombol pratampil.
        </div>
        <iframe id="frame-report" frameborder="0" style="margin: 5px;width: 755px;height: 500px;"></iframe>
    </div>

</div>

<script type="text/javascript">
    $(function(){
        var read_subject = function() {
            var link = $('#list-teaching').attr('link_r');
            $(this).loadingProgress('start');
            
            $.post(link, {id:1}, function (o){
                $('#list-teaching').children('tbody').html(o);
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        var read_eskul = function() {
            var link = $('#list-teaching-ekskul').attr('link_r');
            $(this).loadingProgress('start');
            
            $.post(link, {id:1}, function (o){
                $('#list-teaching-ekskul').children('tbody').html(o);
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        read_subject();
        read_eskul();
        
        $("#btn-rapor").live('click', function() {
            window.location = $(this).attr('link');
        });
        
        $('#fScoreCheck').live('submit', function() {
            var action = $(this).attr('action');
            var classgroup = $('#hidden_classgroup').val();
            var student = $('#student').val();
            $('#frame-report').attr('src', action + '/' + classgroup + '.' + student);
            return false;
        });
    });
</script>