<div id="ws_pendaftaran_kumkm">
    <?php 
    Form::begin('registration_form', 'customer/run', 'post'); 
    
    Form::create('text','username');
    Form::Tips('Enter your username');
    Form::validation()->requaired('Harus di isi');;
    Form::inputType()->numeric();
    Form::commit();
    
    Form::create('submit','username');
    Form::value('Kirim');
    Form::commit();
    
    Form::end();
    ?>
</div>