<div id="cb-period">
    <?php
    $default_option_period_key = '';
    $default_option_period_value = '';
    if (count($option_period) > 0) {
        reset($option_period);
        $default_option_period_key = key($option_period);
        $default_option_period_value = current($option_period);
    }
    Form::create('hidden', 'hidden_option_period');
    Form::value($default_option_period_key);
    Form::commit();
    ?>
    <a id="cb-period-parent" class="slide-of">
        <span class="fl-left"><b>Tahun Akademik :</b></span>
        <span class="fl-right"><?php echo $default_option_period_value; ?></span>
    </a>
    <div class="cl">&nbsp;</div>
    <ul id="cb-period-child">
        <?php
        $list_period = '';
        foreach ($option_period as $keyperiod => $rowperiod) {
            $list_period .= '<li>';
            $list_period .= '   <a href="' . $keyperiod . '">';
            $list_period .= '       <span class="fl-right">' . $rowperiod . '</span>';
            $list_period .= '   </a>';
            $list_period .= '</li>';
        }
        echo $list_period;
        ?>
    </ul>
</div>

<div class="hr"></div>

<div class="box-static">
    <div class="title"><?php echo Web::getTitle(false); ?></div>
    <div class="description">Berikut adalah daftar persentase nilai : </div>
    <div style="padding: 5px;">
        <table id="list-percentase" style="width: 100%" class="table-list" cellspacing="0" cellpadding="0" link_r="<?php echo $link_r_percentase; ?>">
            <thead>
                <tr>
                    <td class="first" style="width: 50px;text-align: center;">No.</td>
                    <td>Mata Pelajaran</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="first" colspan="2">
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
        
        /* Checkbox Period */
        $('#cb-period').live('click',function(){
            $(this).children('#cb-period-parent').removeClass().addClass('slide-on');
            $(this).children('#cb-period-child').slideDown('fast');
        }).mouseleave(function(){
            $(this).children('#cb-period-parent').removeClass().addClass('slide-of');
            $(this).children('#cb-period-child').slideUp('fast');
        });
        
        $('#cb-period #cb-period-child li a').live('click',function(){
            var oldid = $('#hidden_option_period').val();
            var newid = $(this).attr('href');
            
            $('#hidden_option_period').val(newid);
            $('#cb-period-parent').children('.fl-right').html($(this).children('.fl-right').html());
            
            $('#cb-period').children('#cb-period-parent').removeClass().addClass('slide-of');
            $('#cb-period').children('#cb-period-child').slideUp('fast');
            
            if (newid != oldid) {
            }
            
            return false;
        });
        
        var readPercentase = function() {
            var link = $('#list-percentase').attr('link_r');       
            var period = $('#hidden_option_period').val();
            
            var period_split = period.split('_');
            
            $(this).loadingProgress('start');
            
            $.post(link, { p : period_split[0],  s : period_split[1]}, function (o){
                $('#list-percentase').children('tbody').attr('count',o['count']);
                $('#list-percentase').children('tbody').html(o['row']);
                
                $(this).loadingProgress('stop');
                
            }, 'json');
        };
        
        /* Auto Load */
        readPercentase(); 
    });
</script>