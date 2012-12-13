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
    });
</script>