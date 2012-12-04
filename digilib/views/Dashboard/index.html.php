Hallow, kamu sudah login

<?php
Form::begin('fData', 'dashboard/create', 'post');
Form::create('text', 'text');
Form::tips('Please Enter text');
Form::commit();

Form::create('select', 'gender');
Form::tips('Please select your gender');
Form::option(array('m' => 'Male', 'f' => 'Female'));
Form::commit();

Form::create('optgroup', 'porduc');
Form::tips('Please select product');
Form::option(
        array('T-Shirt' => array('P001' => 'King of POP', 'P002' => 'The jungle'),
    'Pants' => array('P003' => 'Leea Jeans', 'P004' => 'Combo')), '-- Pilih Produk --');
Form::commit();

Form::create('submit');
Form::commit();
Form::end();
?>
<hr />
<div id="listData"></div>
