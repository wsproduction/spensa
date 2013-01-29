<div id="cb-period">
    <a id="cb-period-parent" class="slide-of" href="#cb-period-child">
        <span class="fl-left"><b>Tahun Akademik :</b></span>
        <span class="fl-right">2012 / 2013 - Semester 1</span>
    </a>
    <div class="cl">&nbsp;</div>
    <ul id="cb-period-child">
        <?php
        $list_period = '';
        foreach ($option_period as $keyperiod => $rowperiod) {
            $list_period .= '<li>';
            $list_period .= '   <a href="#' . $keyperiod . '">';
            $list_period .= '       <span id="201220131" class="fl-right">' . $rowperiod . '</span>';
            $list_period .= '   </a>';
            $list_period .= '</li>';
        }
        echo $list_period;
        ?>
    </ul>
</div>

<div class="hr"></div>

<div>
    <?php
    Form::begin('fStudentCheck', 'score/check', 'post', true);
    ?>
    <table class="frame-form">
        <tr>
            <td><b>Nomor Indux Siswa :</b></td>
            <td><b>PIN :</b></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <?php
                Form::create('text', 'semester');
                Form::commit();
                ?>
            </td>
            <td>
                <?php
                Form::create('text', 'semester');
                Form::commit();
                ?>
            </td>
            <td>
                <?php
                Form::create('submit', '');
                Form::value('Cek');
                Form::commit();
                ?>
            </td>
        </tr>
    </table>
    <?php
    Form::end();
    ?>
</div>

<div class="box-score" style="margin-top: 5px;">
    <div class="header">
        <table class="fl-left">
            <tr>
                <td class="label">NAMA</td>
                <td class="sparator">:</th>
                <td class="content">WARMAN SUGANDA</td>
            </tr>
            <tr>
                <td class="label">NIS</td>
                <td class="sparator">:</th>
                <td class="content">121307001</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="sparator">:</th>
                <td class="content">9884983083939</td>
            </tr>
        </table>
        <table class="fl-left">
            <tr>
                <td class="label">TAHUN AKADEMIK</td>
                <td class="sparator">:</th>
                <td class="content">2012/2013 - SEMESTER 2</td>
            </tr>
            <tr>
                <td class="label">KELAS</td>
                <td class="sparator">:</th>
                <td class="content">IX A</td>
            </tr>
            <tr>
                <td class="label">WALI KELAS</td>
                <td class="sparator">:</th>
                <td class="content">MISJUM KOMARUDIN, S.Pd.Mat</td>
            </tr>
        </table>
        <div class="cl">&nbsp;</div>
        <div class="link-box">
            [+] <?php URL::link('#', 'Cetak Raport') ?> &nbsp; [-] <?php URL::link('#', 'Tutup') ?> 
        </div>
    </div>
    <div class="box-score-check">
        <div class="fl-left box-frame-check">
            <?php
            Form::begin('fScoreCheck', 'score/check', 'post', true);
            ?>
            <table class="frame-form">
                <tr>
                    <td><b>Pilih Rekap Nilai :</b></td>
                    <td><b>Pilih Mata Pelajaran :</b></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <?php
                        Form::create('select', 'semester');
                        Form::option($option_recapitulation);
                        Form::commit();
                        ?>
                    </td>
                    <td>
                        <?php
                        Form::create('select', 'semester');
                        Form::option($option_subject);
                        Form::commit();
                        ?>
                    </td>
                    <td>
                        <?php
                        Form::create('submit', '');
                        Form::value('Preview');
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
    <div class="view-score">
        <div id="box-score-list">
            <table id="list-score" link_r="<?php echo $link_r; ?>"  link_p="<?php echo $link_p; ?>"></table>
        </div>
        <div id="box-score-report">
            <iframe id="frame-report" frameborder="0"></iframe>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var listId = '#list-score';
        var title = 'Score List';
        var link_r = $(listId).attr('link_r');
        var link_p = $(listId).attr('link_p');
    
        var option = {
            url : link_r,
            dataType : 'xml',
            colModel : [ {
                    display : 'ID', 
                    name : 'language_id', 
                    width : 80,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Subject',
                    name : 'language_name',
                    width : 210,
                    sortable : true,
                    align : 'left'
                }, {
                    display : 'Teacher',
                    name : 'language_status',
                    width : 200,
                    sortable : true,
                    align : 'left',
                    hide : true
                }, {
                    display : 'KKM',
                    name : 'language_entry',
                    width : 45,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Score',
                    name : 'language_entry',
                    width : 45,
                    sortable : true,
                    align : 'center'
                }, {
                    display : 'Note',
                    name : 'language_entry_update',
                    width : 104,
                    sortable : true,
                    align : 'center'
                }],
            buttons : [ {
                    name : 'Cetak Rekapitulasi Nilai',
                    bclass : 'print',
                    onpress : function() {
                        $('#frame-report').attr('src',link_p);
                        $('#box-score-list').slideUp('slow');
                        $('#box-score-report').slideDown('slow');
                    }
                }],
            searchitems : [ {
                    display : 'ID',
                    name : 'language_id',
                    isdefault : true
                }, {
                    display : 'Subject',
                    name : 'language_name'            
                } ],
            nowrap : false,
            sortname : "language_id",
            sortorder : "asc",
            usepager : true,
            title : title,
            useRp : false,
            rp : 15,
            showTableToggleBtn : false,
            resizable : false,
            width : '100%',
            height : 300,
            onSubmit: function() {
                var dt = $('#fScoreCheck').serializeArray();
                $(listId).flexOptions({
                    params: dt
                });
                return true;
            }
        };
    
        $(listId).flexigrid(option);
        
        $('#fScoreCheck').live('submit',function(){
            $('#box-score-list').slideDown('slow');
            $('#box-score-report').slideUp('slow');
            $(listId).flexOptions({
                newp: 1
            }).flexReload();
            return false;
        });
        
        
        $('#cb-period-parent').live('click',function(){
            var source = $(this);
            var tempClass = $(source).attr('class');
            var target = $(source).attr('href');
        
            if (tempClass=='slide-on') {
                $(source).removeClass('slide-on').addClass('slide-of');
                $(target).slideUp('fast');
            } else {
                $(source).removeClass('slide-of').addClass('slide-on');
                $(target).slideDown('fast');
            }
            return false;
        });
        
        $('#cb-period-child a').live('click',function() {
            var id = $(this).attr('href');
            var sel = $(id).html();
            $('#cb-period-parent span.fl-right').html(sel);
            $('#cb-period-parent').removeClass('slide-on').addClass('slide-of');
            $($('#cb-period-parent').attr('href')).slideUp('fast');
            return false;
        });
        
        $('body').live('click',function() {
            $('#cb-period-parent').removeClass('slide-on').addClass('slide-of');
            $($('#cb-period-parent').attr('href')).slideUp('fast');
        });
        
    });
</script>