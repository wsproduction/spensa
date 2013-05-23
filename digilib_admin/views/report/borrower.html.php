<div class="maincontent">
    <div class="maincontentinner">

        <div class="headtitle">
            <div class="widgettitle"><?php echo Web::getTitle(); ?></div>
            <div class="btn-group">
                <a href="#" class="dropdown">Aksi</a>
                <ul>
                    <li><a href="<?php echo $link_back; ?>">Kembali</a></li>
                </ul>
            </div>
            <div class="cls">&nbsp;</div>
        </div>

        <div class="widgetcontent">
            <div style="margin: 10px 0;">
                <fieldset>
                    <legend>Filter Data</legend>
                    <?php Form::begin('fReportFilter', 'report/readborrower', 'post'); ?>
                    <table>
                        <tr>
                            <td width="150">
                                <div class="label-ina">Periode Laporan</div>
                                <div class="label-eng">Report Period</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('select', 'month');
                                Form::properties(array('style' => 'width:120px;'));
                                Form::option($month_option);
                                Form::commit();
                                echo ' ';
                                Form::create('select', 'year');
                                Form::properties(array('style' => 'width:80px;'));
                                Form::option($year_option);
                                Form::commit();
                                echo ' ';
                                Form::create('submit', 'bSubmit');
                                Form::value('Cari');
                                Form::style('action_search');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                    </table>
                    <?php Form::end(); ?>
                </fieldset>
            </div>

            <div id="container" style="min-width: 400px; margin: 10px 5px 0 0">
                <iframe style="width: 100%" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#container iframe').css('height', screen.height * 0.55);
        $('#fReportFilter').live('submit', function() {
            var link = $(this).attr('action');
            var month = $('#month').val();
            var year = $('#year').val();
            $('#container iframe').attr('src', link + '/' + month + year);
            return false;
        });
    });
</script>