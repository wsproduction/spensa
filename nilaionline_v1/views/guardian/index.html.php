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
                <td class="sparator" >:</td>
                <td class="content" >
                    <?php
                    echo $guardian_info['period_years_start'] . '/' . $guardian_info['period_years_end'] . ' - ' . $guardian_info['semester_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label" >KELAS</td>
                <td class="sparator" >:</td>
                <td class="content" >
                    <?php
                    echo $guardian_info['grade_title'] . ' (' . $guardian_info['grade_name'] . ') ' . $guardian_info['classroom_name'];
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label" >JUMLAH SISWA</td>
                <td class="sparator" >:</td>
                <td class="content" >
                    <?php
                    echo $guardian_info['student_count'] . ' Siswa';
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="link-box">
                        [+] <?php URL::link($link_rapor, 'Cetak Laporan Hasil Belajar Siswa', true, array('id' => 'btn-guardian-page')); ?> 
                    </div>
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
                    <td rowspan="2" class="first" style="width: 40px;text-align: center;">No.</td>
                    <td rowspan="2" >Mata Pelajaran</td>
                    <td rowspan="2"  style="width: 180px;text-align: center;">Nama Guru</td>
                    <td style="text-align: center;" colspan="2">Keterangan Nilai</td>
                    <td rowspan="2" style="width: 100px;text-align: center;">Pilihan</td>
                </tr>
                <tr>
                    <td style="width: 100px;text-align: center;border-top: none;border-left: none;">Rapor Tengah Semester</td>
                    <td style="width: 100px;text-align: center;border-top: none;">Rapor Akhir Semester</td>
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
    <div style="padding: 5px;"><b>&bullet; PENGEMBANGAN DIRI</b></div>
    <div style="padding: 5px;">
        <table id="list-teaching-ekskul" style="width: 100%" class="table-list"  cellspacing="0" cellpadding="0" link_r="<?php echo $link_read_eskul; ?>">
            <thead>
                <tr>
                    <td rowspan="2" class="first" style="width: 40px;text-align: center;">No.</td>
                    <td rowspan="2" >Mata Pelajaran</td>
                    <td rowspan="2"  style="width: 180px;text-align: center;">Nama Guru</td>
                    <td style="text-align: center;" colspan="2">Keterangan Nilai</td>
                    <td rowspan="2" style="width: 100px;text-align: center;">Pilihan</td>
                </tr>
                <tr>
                    <td style="width: 100px;text-align: center;border-top: none;border-left: none;">Rapor Tengah Semester</td>
                    <td style="width: 100px;text-align: center;border-top: none;">Rapor Akhir Semester</td>
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
    });
</script>