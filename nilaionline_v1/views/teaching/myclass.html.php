<div class="box-static">
    <div class="title">
        <div class="fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="fl-right">
            <a href="<?php echo $link_back; ?>" class="btn-red">Kembali</a>
        </div>
        <div class="cl">&nbsp;</div>
    </div>

    <div class="class-info box-green">
        <table>
            <tr>
                <td class="label" style="width: 120px;">MATA PELAJARAN</td>
                <td class="sparator" >:</td>
                <td class="content" >
                    <?php
                    Form::create('hidden', 'hidden_subject_id');
                    Form::value($subject_info['subject_id']);
                    Form::commit();
                    echo $subject_info['subject_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">TAHUN AKADEMIK</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    Form::create('hidden', 'hidden_period_id');
                    Form::value($period_info['period_id']);
                    Form::commit();
                    Form::create('hidden', 'hidden_semester_id');
                    Form::value($semester_info['semester_id']);
                    Form::commit();
                    echo $period_info['period_years_start'] . ' / ' . $period_info['period_years_end'] . ' - ' . $semester_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">KELAS</td>
                <td class="sparator">:</td>
                <td class="content">
                    <?php
                    Form::create('hidden', 'hidden_grade_id');
                    Form::value($grade_info['grade_id']);
                    Form::commit();
                    echo $grade_info['grade_title'] . ' (' . $grade_info['grade_name'] . ')';
                    ?>
                </td>
            </tr>
        </table> 
    </div>

    <div class="description">Berikut adalah daftar kelas mengajar :</div>
    <div style="padding: 5px;">
        <table id="list-class" style="width: 100%" class="table-list" cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_basecompetence; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 30px;text-align: center;">No.</td>
                    <td style="width: 80px;text-align: center;">Nama Kelas</td>
                    <td style="width: 80px;text-align: center;">Jumlah Siswa</td>
                    <td>Wali Kelas</td>
                    <td style="width: 90px;text-align: center;">Lama Mengajar</td>
                    <td style="width: 80px;text-align: center;">Last Update</td>
                    <td style="width: 150px;text-align: center;">Pilihan</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="7">
                        <div class="information-box">
                            Loading...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var read_base_competence = function() {
            var link = $('#list-class').attr('link_r');       
            var subject_id = $('#hidden_subject_id').val();
            var period_id = $('#hidden_period_id').val();
            var semester_id = $('#hidden_semester_id').val();
            var grade_id = $('#hidden_grade_id').val();            
            
            $(this).loadingProgress('start');
            
            $.post(link, { subject : subject_id,  period : period_id,  semester : semester_id, grade : grade_id}, function (o){
                $('#list-class').children('tbody').attr('count',o['count']);
                $('#list-class').children('tbody').html(o['row']);
                $(this).loadingProgress('stop');
            }, 'json');
        };
        
        read_base_competence();
    });
</script>