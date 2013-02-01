<div class="box-static">
    <div class="title"><?php echo Web::getTitle(false); ?></div>
    <div class="class-info box-green">
        <table id="teacher-information" cellspacing="6" cellpadding="5" style="width: 100%;">
            <tr>
                <td style="width: 120px;"><b>Tahun Akademik</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    echo $guardian_info['period_years_start'] . '/' . $guardian_info['period_years_end'] . ' - ' . $guardian_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Kelas</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    echo $guardian_info['grade_title'] . ' (' . $guardian_info['grade_name'] . ') ' . $guardian_info['classroom_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>Jumlah Siswa</b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                    echo $guardian_info['student_count'] . ' Siswa';
                    ?>
                </td>
            </tr>
        </table>
        <div class="cl"></div>
    </div>
    <div class="description">Berikut adalah daftar tugas mengajar : </div>
    <div style="padding: 5px;"><b>&bullet; MATA PELAJARAN</b></div>
    <div>
        <table id="list-teaching" cellspacing="0" cellpadding="0" link_r="<?php echo $link_read_subject; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 40px;text-align: center;">No.</td>
                    <td>Mata Pelajaran</td>
                    <td style="width: 240px;text-align: center;">Nama Guru</td>
                    <td style="width: 100px;text-align: center;">Keterangan Nilai</td>
                    <td style="width: 100px;text-align: center;">Pilihan</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="4">
                        <div class="information-box">
                            Loading...
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="padding: 5px;"><b>&bullet; PENDIDIKAN BERBASIK KEUNGGULAN LOKAL (PBKL)</b></div>
    <div style="padding: 5px;">
        <table id="list-teaching-pbkl" style="width: 100%" class="table-list"  cellspacing="0" cellpadding="0" link_r="<?php echo $link_read_pbkl; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;">No.</td>
                    <td>Nama PBKL</td>
                    <td style="width: 100px;text-align: center;">Total Mengajar</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="3">
                        <div class="information-box">
                            Data mengajar tidak ditemukan.
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="padding: 5px;"><b>&bullet; PENGEMBANGAN DIRI</b></div>
    <div style="padding: 5px;">
        <table id="list-teaching-ekskul" style="width: 100%" class="table-list"  cellspacing="0" cellpadding="0" link_r="<?php echo $link_read_eskul; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;">No.</td>
                    <td>Nama Kegiatan</td>
                    <td style="width: 100px;text-align: center;">Total Mengajar</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="3">
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
    });
</script>