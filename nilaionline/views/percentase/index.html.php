<div class="box-static">

    <div class="title">
        <div class="fl-left"><?php echo Web::getTitle(false); ?></div>
        <div class="fl-right">
            <a href="#box-add-data" rel="dialog" class="btn-blue">Simpan Data</a>&nbsp;<a href="../../teaching" class="btn-blue">Kembali</a>
        </div>
        <div class="cl">&nbsp;</div>
    </div>

    <div class="class-info box-green">
        <table class="fl-left" cellspacing="5" cellpadding="0">
            <tr>
                <td style="width: 120px;"><b>Mata Pelajaran</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_subject_id');
                    Form::value($subject_info['subject_id']);
                    Form::commit();
                    echo $subject_info['subject_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Tahun Akademik</b></td>
                <td><b>:</b></td>
                <td>
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
                <td><b>Kelas</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    Form::create('hidden', 'hidden_grade_id');
                    Form::value($grade_info['grade_id']);
                    Form::commit();
                    echo $grade_info['grade_title'] . ' (' . $grade_info['grade_name'] . ')';
                    ?>
                </td>
            </tr>
        </table> 
        <div class="cl">&nbsp;</div>
    </div>

    <div style="padding: 5px;">
        <table id="list-percentase" style="width: 100%" class="table-list" cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_percentase; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;">No.</td>
                    <td>Mata Pelajaran</td>
                    <td style="width: 200px;text-align: center;">Persentase</td>
                </tr>
            </thead>
            <?php echo $recap_list; ?>
        </table>
    </div>
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
        
        $('.form_percentase').live('change', function() {
            var total = 0;
            $('.form_percentase').each(function(){
                var val = $(this).val();
                if (is_empty(val))
                    val = 0;
                total = total + parseInt(val);
            });
            $('#calculate_percentase').text(total + ' %');
        });
    });
</script>