<div style="font-size: 18px;font-weight: bold;">Kritik dan Saran</div>
<div>
    <?php
    Form::begin('fTestimony', 'guest/savetestimony', 'post', true);
    ?>

    <div>
        <?php
        Form::create('textarea', 'testimony');
        Form::commit();
        ?>
    </div>

    <div style="margin-top: 5px;">
        <?php
        Form::create('submit');
        Form::style('btn-green');
        Form::value('KIRIM');
        Form::properties(array('style' => 'font-size:14px;'));
        Form::commit();
        ?>
    </div>

    <?php
    Form::end();
    ?>
</div>


<script>

    $(function(){  
        /* WYSIWYG elRTE */
        elRTE.prototype.options.panels.web2pyPanel = [
            'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
            'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist',
            'link', 'image'
        ];
        elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel', 'tables'];
    
        var opts = {
            cssClass : 'el-rte',
            height   : 200,
            width    : 770,
            toolbar  : 'web2pyToolbar',
            cssfiles : ['css/elrte-inner.css']
        };
        
        $('#testimony').elrte(opts);
        
        $('#fTestimony').live('submit', function(){
            frmID = $(this);
            msgID = $('#message');
            var url =  $(frmID).attr('action');
            var data =  $(frmID).serialize();
            
            var conf = confirm("Anda yakin akan mengirim");
            if (conf) {
                $(this).loadingProgress('start');
                $.post(url, data, function(o){
                    $(this).loadingProgress('stop');
                    if (o) {
                        alert('Terimakasih, kritik dan saran anda sudah disimpan.');
                    } else {
                        alert('Maaf kritik saran anda tidak tersimpan.');
                    }
                }, 'json');
            }
            
            return false;
        });
    });
</script>