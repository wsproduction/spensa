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
            <div id="message"></div>
            <?php
            Form::begin('fAdd', 'catalogue/create', 'post', true);

            Form::create('hidden', 'stepStatus');
            Form::value(0);
            Form::commit()
            ?>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">1. Keterangan Buku</a></li>
                    <li><a href="#tabs-2">2. Keterangan Penanggung Jawab</a></li>
                    <li><a href="#tabs-3">3. Klasifikasi Buku</a></li>
                    <li><a href="#tabs-4">4. Resensi Buku</a></li>
                    <li><a href="#tabs-5">5. Katalog</a></li>
                </ul>
                <div id="tabs-1">
                    <table style="width: 100%;" class="table-form">
                        <tr>
                            <td style="width: 250px;">
                                <div class="label-ina">Judul Buku</div>
                                <div class="label-eng">Book Title</div>
                            </td>
                            <td style="width: 10px;">:</td>
                            <td>
                                <?php
                                Form::create('text', 'title');
                                Form::tips('Masukan Judul Buku');
                                Form::size(100);
                                Form::validation()->requaired('* Judul harus diisi.');
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Judul Bahasa Lain</div>
                                <div class="label-eng">Foreign Title</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'foreign_title');
                                Form::tips('Masukan judul dalam bahasa asing');
                                Form::size(100);
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <div class="label-ina">Bahasa</div>
                                <div class="label-eng">Language</div>
                            </td>
                            <td valign="top" style="padding: 8px 0 0 0;">:</td>
                            <td>
                                <?php
                                Form::create('hidden', 'language_hide');
                                Form::commit();
                                
                                Form::create('select', 'language');
                                Form::tips('Pilih Bahasa');
                                Form::option($language);
                                Form::properties(array('multiple' => 'multiple'));
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Edisi</div>
                                <div class="label-eng">Edition</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'edition');
                                Form::tips('Masukan Edisi Buku Keberapa?');
                                Form::size(100);
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Cetakan</div>
                                <div class="label-eng">Copies</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'print_out');
                                Form::tips('Masukan Cetakan Buku Keberapa?');
                                Form::inputType()->numeric();
                                Form::size(5);
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">ISBN</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'isbn');
                                Form::tips('Masukan ISBN (<i>International Standard Book Number</i>)<br>* Hanya nomor dan strip yang diijinkan.<br>Contoh: 978-3-16-148410-0');
                                Form::size(20);
                                Form::inputType()->numeric('-x');
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Halaman Romawi</div>
                                <div class="label-eng">Page Romance</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'roman_count');
                                Form::tips('Masukan nomor halaman romawi terakhir. Contoh: vii');
                                Form::size(5);
                                Form::inputType()->alpha(true);
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Halaman Angka</div>
                                <div class="label-eng">Page Number</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'page_count');
                                Form::tips('Masukan nomor halaman angka. Contoh: 120');
                                Form::size(5);
                                Form::validation()->number('* Periksa angka dengan benar.');
                                Form::validation()->min(1);
                                Form::inputType()->numeric();
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Bibliografi</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'bibliography');
                                Form::tips('Masukan halaman rentang halaman bibliografi.<br>Example : 103-107');
                                Form::size(15);
                                Form::inputType()->numeric('-');
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr style="height: 30px;">
                            <td>
                                <div class="label-ina">Ilustrasi</div>
                                <div class="label-eng">Ilustration</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('checkbox', 'ilustration');
                                Form::value(1);
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 30px;">
                                <div class="label-ina">Index</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('checkbox', 'index');
                                Form::value(1);
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Ukuran</div>
                                <div class="label-eng">Size</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'width');
                                Form::tips('Masukan ukuran lebar buku.');
                                Form::size(10);
                                Form::inputType()->numeric('.');
                                Form::style('form-grey');
                                Form::commit();
                                echo 'x';
                                Form::create('text', 'height');
                                Form::tips('Masukan ukuran tinggi buku.');
                                Form::size(10);
                                Form::inputType()->numeric('.');
                                Form::style('form-grey');
                                Form::commit();
                                echo 'Cm';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Berat</div>
                                <div class="label-eng">Weight</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'weight');
                                Form::tips('Masukan berat buku.');
                                Form::size(10);
                                Form::inputType()->numeric('.');
                                Form::style('form-grey');
                                Form::commit();
                                echo 'Kg';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Eksemplar</div>
                                <div class="label-eng">Quantity</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('text', 'quantity');
                                Form::tips('Masukan jumlah eksemplar.');
                                Form::size(10);
                                Form::inputType()->numeric();
                                Form::validation()->requaired('* Jumlah eksemplar harus diisi.');
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Harga</div>
                                <div class="label-eng">Price</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('select', 'accounting_symbol');
                                Form::tips('Pilih mata uang.');
                                Form::option($accounting_symbol, ' ');
                                Form::style('form-grey');
                                Form::commit();

                                Form::create('text', 'price');
                                Form::tips('Masukan harga buku.');
                                Form::size(20);
                                Form::inputType()->numeric();
                                Form::properties(array('style' => 'text-align:right;'));
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Asal / Sumber</div>
                                <div class="label-eng">Source / Fund</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('select', 'resource');
                                Form::tips('Select Resource');
                                Form::option($book_resource, ' ');
                                Form::style('form-grey');
                                Form::commit();
                                echo ' / ';
                                Form::create('select', 'fund');
                                Form::tips('Pilih sumber dana');
                                Form::option($book_fund, ' ');
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label-ina">Tampilan Halaman Depan</div>
                                <div class="label-eng">Book Cover</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('file', 'cover');
                                Form::validation()->accept('jpg|jpeg|gif|png');
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                <div class="label-ina">Buku Elektronik</div>
                                <div class="label-eng">Electronic Book</div>
                            </td>
                            <td>:</td>
                            <td>
                                <?php
                                Form::create('file', 'file');
                                Form::validation()->accept('pdf');
                                Form::style('form-grey');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="box-button-tab">
                                    <?php
                                    Form::create('submit', 'btnStep1');
                                    Form::value('Next to Step 2');
                                    Form::style('button-mid-solid-bluesky');
                                    Form::commit();
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tabs-2">
                    <table style="width: 100%;">
                        <tr>
                            <td style="border-bottom: 1px dashed #ccc;padding-bottom: 10px;">
                                <fieldset>
                                    <legend>Keterangan Penerbit</legend>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 100px;">
                                                <div class="label-ina">Negara</div>
                                                <div class="label-eng">Country</div>
                                            </td>
                                            <td style="width: 5px;">:</td>
                                            <td style="width: 240px;">
                                                <?php
                                                Form::create('select', 'country');
                                                Form::tips('Select Country');
                                                Form::option($country, ' ');
                                                Form::validation()->requaired();
                                                Form::properties(array('link' => $link_province, 'style' => 'max-width:200px;'));
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                            </td>
                                            <td rowspan="4" valign="top" align="center" id="view_info_publisher">
                                                <?php
                                                Form::create('hidden', 'publisher');
                                                Form::validation()->requaired();
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                                <table id="publisher-list" title="Daftar Penerbit" link_r="<?php echo $link_r_publisher; ?>"></table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label-ina">Provinsi</div>
                                                <div class="label-eng">Province</div>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                Form::create('select', 'province');
                                                Form::tips('Select Country');
                                                Form::validation()->requaired();
                                                Form::properties(array('link' => $link_city, 'style' => 'max-width:200px;'));
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label-ina">Kota</div>
                                                <div class="label-eng">City</div>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                Form::create('select', 'city');
                                                Form::tips('Select City');
                                                Form::validation()->requaired();
                                                Form::properties(array('style' => 'max-width:200px;'));
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                            </td>
                                        </tr>
                                        <tr valign="top">
                                            <td style="padding-top: 8px;">
                                                <div class="label-ina">Tahun Terbit</div>
                                                <div class="label-eng">Year Published</div>
                                            </td>
                                            <td style="padding-top: 8px;">:</td>
                                            <td>
                                                <?php
                                                Form::create('select', 'year');
                                                Form::tips('Years');
                                                Form::option($years, ' ');
                                                Form::validation()->requaired();
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="padding-top: 10px;width: 500px;">
                                <fieldset>
                                    <legend>Penanggung Jawab</legend>
                                    <table style="width: 100%">
                                        <tr>
                                            <td valign="top" style="width: 348px;">
                                                <table>
                                                    <tr>
                                                        <td style="width: 100px;">
                                                            <div class="label-ina">Keterangan</div>
                                                            <div class="label-eng">Description</div>
                                                        </td>
                                                        <td style="width: 5px;">:</td>
                                                        <td style="width: 240px;">
                                                            <?php
                                                            Form::create('select', 'description_author');
                                                            Form::tips('Pilih keterangan penanggun jawab');
                                                            Form::option($author_description, ' ');
                                                            Form::properties(array('link' => $link_author, 'style' => 'max-width:200px;'));
                                                            Form::style('form-grey');
                                                            Form::commit();
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="label-ina">Nama</div>
                                                            <div class="label-eng">Name</div>
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            <?php
                                                            Form::create('select', 'option_author');
                                                            Form::tips('Pilih keterangan penanggun jawab');
                                                            Form::properties(array('style' => 'max-width:200px;'));
                                                            Form::style('form-grey');
                                                            Form::commit();
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tbody id="form-add-author">
                                                        <tr>
                                                            <td>
                                                                <div class="label-ina">Gelar Depan</div>
                                                                <div class="label-eng">Front Degree</div>
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                <?php
                                                                Form::create('text', 'front_degree_author');
                                                                Form::tips('Masukan gelar depan<br>Contoh : Ir., Dr., DR., dll.');
                                                                Form::size(10);
                                                                Form::style('form-grey');
                                                                Form::commit();
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="label-ina">Nama Depan</div>
                                                                <div class="label-eng">First Name</div>
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                <?php
                                                                Form::create('text', 'first_name_author');
                                                                Form::tips('Masukan nama depan penaggung jawab');
                                                                Form::size(30);
                                                                Form::style('form-grey');
                                                                Form::commit();
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="label-ina">Nama Belakang</div>
                                                                <div class="label-eng">Last Name</div>
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                <?php
                                                                Form::create('text', 'last_name_author');
                                                                Form::tips('Masukan nama belakang penanggung jawab');
                                                                Form::size(30);
                                                                Form::style('form-grey');
                                                                Form::commit();
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="label-ina">Gelar Belakang</div>
                                                                <div class="label-eng">Back Degree</div>
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                <?php
                                                                Form::create('text', 'back_degree_author');
                                                                Form::tips('Masukan gelar belakang<br>Contoh : S.Pd.,S.Kom., dll.');
                                                                Form::size(10);
                                                                Form::style('form-grey');
                                                                Form::commit();
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <?php
                                                            Form::create('button', 'btnAddAuthor');
                                                            Form::value('Tambah');
                                                            Form::style('button-mid-solid-green');
                                                            Form::commit();
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign="top" align="center">
                                                <table id="list-author-selected" title="Daftar Penanggung Jawab" link_r="<?php echo $link_r_author_temp; ?>" link_d="<?php echo $link_d_author_temp; ?>"></table>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="box-button-tab">
                                    <?php
                                    Form::create('button', 'btnPrev');
                                    Form::value('Back to Step 1');
                                    Form::style('button-mid-solid-bluesky');
                                    Form::commit();
                                    Form::create('submit', 'btnSave');
                                    Form::value('Next to Step 3');
                                    Form::style('button-mid-solid-bluesky');
                                    Form::commit();
                                    ?>                                    
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tabs-3">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding-top: 10px;">
                                <fieldset>
                                    <legend>Nomor Klasifikasi</legend>
                                    <table>
                                        <tr>
                                            <td style="width: 120px;">
                                                <div class="label-ina">Level 1</div>
                                            </td>
                                            <td style="width: 10px;">:</td>
                                            <td>
                                                <?php
                                                Form::create('select', 'ddcLevel1');
                                                Form::option($ddc_level1, ' ');
                                                Form::properties(array('link' => $link_ddc_level2));
                                                Form::validation()->requaired('* Level 1 harus diisi.');
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label-ina">Level 2</div>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                Form::create('select', 'ddcLevel2');
                                                Form::validation()->requaired('* Level 2 harus diisi.');
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label-ina">Kata Kunci</div>
                                                <div class="label-eng">Keyword</div>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                Form::create('select', 'keyword_categories');
                                                Form::option(array('ddc_classification_number' => 'Nomor Klasifikasi', 'ddc_title' => 'Judul Klasifikasi', 'ddc_description' => 'Keteragan Klasifikasi'));
                                                Form::style('form-grey');
                                                Form::commit();
                                                Form::create('text', 'ddckeyword');
                                                Form::size(50);
                                                Form::style('form-grey');
                                                Form::commit();
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>
                                                <?php
                                                Form::create('button', 'btnFilterDdc');
                                                Form::value('Cari');
                                                Form::style('button-mid-solid-orange');
                                                Form::commit();
                                                ?>
                                            </td>
                                        </tr>
                                    </table>

                                    <table id="list-ddc" title="Daftar Nomor Klasifikasi" link_r="<?php echo $link_r_ddc ?>"></table>

                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px;">
                                <?php
                                Form::create('hidden', 'ddcid');
                                Form::commit();
                                ?>
                                <fieldset>
                                    <legend>Call Number</legend>
                                    <div>
                                        <div id="preview_call_number">
                                            <div style="height: 20px;" class="print_row_1"></div>
                                            <div style="height: 20px;" class="print_row_2"></div>
                                            <div style="height: 20px;" class="print_row_3"></div>
                                        </div>
                                        <div id="desc_call_number">
                                            <div>&Rrightarrow; <i>Classification Number</i></div>
                                            <div>&Rrightarrow; <i>3 Digit ( Author Name / Book Title )</i></div>
                                            <div>&Rrightarrow; <i>1 Digit ( Book Title )</i></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="box-button-tab">
                                    <?php
                                    Form::create('button', 'btnPrev');
                                    Form::value('Back to Step 2');
                                    Form::style('button-mid-solid-bluesky');
                                    Form::commit();
                                    Form::create('submit', 'btnSave');
                                    Form::value('Next to Step 4');
                                    Form::style('button-mid-solid-bluesky');
                                    Form::commit();
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tabs-4">
                    <table style="width: 100%">
                        <tr>
                            <td style="text-align: center;">
                        <center>
                            <div class="resensi_editor">
                                <?php
                                Form::create('textarea', 'reviews');
                                Form::commit();
                                ?>
                            </div>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">
                                <?php
                                Form::create('button', 'btnPrev');
                                Form::value('Back to Step 3');
                                Form::style('button-mid-solid-bluesky');
                                Form::commit();
                                Form::create('submit', 'btnSave');
                                Form::value('Next to Step 5');
                                Form::style('button-mid-solid-bluesky');
                                Form::commit();
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="tabs-5">
                    <table style="width: 100%"> 
                        <tr>
                            <td>
                                <div class="confFrameCatalogue">
                                    <table  class="confCatalogue">
                                        <tr>
                                            <td class="confCallNumber" valign="top">
                                                <div style="height: 20px;" class="print_row_1"></div>
                                                <div style="height: 20px;" class="print_row_2"></div>
                                                <div style="height: 20px;" class="print_row_3"></div>
                                            </td>
                                            <td valign="top">
                                                <div>
                                                    <div class="authorName"></div>
                                                    <div class="confContent">
                                                        <span style="color: #fff;">AAA</span>
                                                        <span class="contentRow1"></span>
                                                    </div>
                                                    <div style="padding-left: 60px;" class="contentRow2">xi, 160 hlm. : ilus. ; 21 cm</div>
                                                    <div style="padding-left: 60px;margin-top: 20px;" class="contentRow3"></div>
                                                    <div style="margin-top: 30px;">
                                                        <div style="float: left;width: 50%">1. KATALOG</div>
                                                        <div style="float: left;width: 50%">I. Judul</div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="box-button-tab">
                                    <?php
                                    Form::create('button', 'btnPrev');
                                    Form::value('Back to Step 4');
                                    Form::style('button-mid-solid-bluesky');
                                    Form::commit();
                                    Form::create('submit', 'btnSave');
                                    Form::value('Save');
                                    Form::style('button-mid-solid-bluesky');
                                    Form::commit();
                                    ?>
                                </div>
                            </td>
                        </tr>                
                    </table>
                </div>
            </div>
            <?php
            Form::end();
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {

        var form_requaired_validation = function(id, status) {
            $(id).rules("add", {
                required: status
            });
        };

        var set_callnumber = function(row2, row3) {
            /* alert(row2.indexOf('.')); Mecari jumlah huruf dalam kalimat */
            $('.print_row_2').text(row2.substr(0, 3));
            $('.print_row_3').text(row3.substr(0, 1));
        };

        var setting_callnumber = function(author, title) {
            var author_count = author['count'];
            var author_primary = author['primary'];
            var author_primary_status = author_primary['status'];
            var author_primary_name = author_primary['name'];

            if (author_count > 0 && author_count <= 3) {
                set_callnumber(author_primary_name['first_name'], title);
            } else {
                set_callnumber(title, null);
            }
        };

        var generateCatalogue = function() {
            var contentRow1 = '';
            var contentRow2 = '';
            var contentRow3 = '';

            var tempJudul = $('#title').val();
            var tempAnakJudul = $('#sub_title').val();
            var tempJudulBahasaLain = $('#foreign_title').val();
            var tempEdisi = $('#edition').val();
            var tempCetakan = $('#print_out').val();
            var tempKota = $('#city option:selected').text();
            var tempPenerbit = $('#publisher option:selected').text();
            var tempTahun = $('#year option:selected').text();

            var tempHalamanRomawi = $('#roman_count').val();
            var tempHalamanAngka = $('#page_count').val();
            var tempIlustrasi = $('#ilustration').is(':checked');
            var tempLebar = $('#width').val();

            var tempBiblliografi = $('#bibliography').val();
            var tempIndex = $('#ilustration').is(':checked');
            var tempISBN = $('#isbn').val();

            var judul = tempJudul;
            var anakJudul = '';
            var judulBahasaLain = '';
            var author = '<span class="viewListAuthorTemp"></span>';
            var edisi = '';
            var cetakan = '';
            var penerbit = '';

            var halamanRomawi = '';
            var halamanAngka = '';
            var ilustrasi = '';
            var lebar = '';

            var biblliografi = '';
            var index = '';
            var ISBN = '';

            var sparator1 = '';
            var sparator2 = '';

            if (tempAnakJudul !== '')
                anakJudul = ' : ' + tempAnakJudul;

            if (tempJudulBahasaLain !== '')
                judulBahasaLain = ' = ' + tempJudulBahasaLain;

            if (tempEdisi !== '')
                edisi = '.&HorizontalLine; Ed. ' + tempEdisi;

            if (tempEdisi !== '' && tempCetakan !== '')
                sparator1 = ',';

            if (tempCetakan !== '')
                cetakan = ' cet. ' + tempCetakan;

            if (tempHalamanRomawi !== '')
                halamanRomawi = tempHalamanRomawi;

            if (tempHalamanRomawi !== '' && tempHalamanAngka != '')
                sparator2 = ',';

            if (tempHalamanAngka !== '')
                halamanAngka = ' ' + tempHalamanAngka + ' hlm.';

            if (tempIlustrasi)
                ilustrasi = ' : ilus.';

            if (tempLebar !== '')
                lebar = ' ; ' + tempLebar + ' cm&DiacriticalAcute;';

            if (tempBiblliografi !== '')
                biblliografi = 'Biblliografi : ' + tempBiblliografi + ' <br>';

            if (tempIndex)
                index = 'Indeks <br>';

            if (tempISBN !== '')
                ISBN = 'ISBN ' + tempISBN + ' <br>';

            penerbit = '.&HorizontalLine; ' + tempKota + ' : ' + tempPenerbit + ', ' + tempTahun + '. ';

            contentRow1 = judul + anakJudul + judulBahasaLain + author + edisi + sparator1 + cetakan + penerbit;

            contentRow2 = halamanRomawi + sparator2 + halamanAngka + ilustrasi + lebar;

            contentRow3 = biblliografi + index + ISBN;

            $('.contentRow1').html(contentRow1);
            $('.contentRow2').html(contentRow2);
            $('.contentRow3').html(contentRow3);
            
            /*
            $.get('getAuhtorTemp', {
                sa: $('#sessionAuthor').val()
            }, function(o) {
                $('.viewListAuthorTemp').html(o);
            }, 'json');
            */
        };

        /* Multiselect */
        $("#language").multiselect({
            selectedText: "# dari # dipilih",
            noneSelectedText: 'Pilih bahasa'
        }).multiselectfilter();

        $("#option_author").multiselect({
            multiple: false,
            selectedText: "# dari # dipilih",
            noneSelectedText: 'Pilih Author',
            selectedList: 1
        }).multiselectfilter();

        /* LIVE LANGUAGE */
        $('#language').live('change', function() {
            if ($(this).val() === -1)
                $('#otherlanguage').fadeIn('fast').val('').focus();
            else
                $('#otherlanguage').fadeOut('fast');
        });

        /* FLEXYGRID PUBLISHER */
        var listId3 = '#publisher-list';
        var title3 = $(listId3).attr('title');
        var link_r3 = $(listId3).attr('link_r');

        var option3 = {
            url: link_r3,
            dataType: 'xml',
            colModel: [{
                    display: 'ID',
                    name: 'publisher_office_id',
                    width: 40,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Nama Penerbit',
                    name: 'publisher_name',
                    width: 200,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Keterangan',
                    name: 'publisher_description',
                    width: 300,
                    align: 'left'
                }, {
                    display: 'Alamat',
                    name: 'publisher_office_address',
                    width: 400,
                    align: 'left'
                }, {
                    display: 'Kantor',
                    name: 'publisher_office_department_name',
                    width: 60,
                    sortable: true,
                    align: 'left'
                }],
            nowrap: false,
            sortname: "publisher_office_id",
            sortorder: "asc",
            usepager: true,
            title: title3,
            useRp: false,
            rp: 15,
            showTableToggleBtn: true,
            resizable: false,
            singleSelect: true,
            width: screen.width * 0.4,
            height: 150,
            onSubmit: function() {
                var dt = $('#fAdd').serializeArray();
                $(listId3).flexOptions({
                    params: dt
                });
                return true;
            }
        };

        $(listId3).flexigrid(option3);

        /* PUBLISHER FILTER */
        $('#country').live('change', function() {
            var url = $(this).attr('link');
            var id = $(this).val();
            $('#province').html('<option>Loading...</option>');
            $.get(url, {
                id: id
            }, function(o) {
                $('#province').html(o);
            }, 'json');
        });

        $('#province').live('change', function() {
            var url = $(this).attr('link');
            var id = $(this).val();
            $('#city').html('<option>Loading...</option>');
            $.get(url, {
                id: id
            }, function(o) {
                $('#city').html(o);
            }, 'json');
        });

        $('#city').live('change', function() {
            $('#publisher-list').flexOptions({
                newp: 1
            }).flexReload();
        });

        $('#publisher-list tbody tr[id*="row"]').live('click', function() {
            var id = '';
            var status = $(this).attr('class');
            if (status === 'trSelected' || status === 'erow trSelected') {
                id = $(this).attr('id').substr(3);
            }
            $('#publisher').val(id);
        });

        /* AUTHOR FILTER */
        $('#form-add-author').css('display', 'none');
        $('#description_author').live('change', function() {
            var url = $(this).attr('link');
            var id = $(this).val();
            $('#option_author').html('<option>Loading...</option>');
            $.get(url, {
                id: id
            }, function(o) {
                $('#option_author').html(o);
                $("#option_author").multiselect('refresh');
            }, 'json');
        });

        $('#option_author').live('change', function() {
            var id = $(this).val();
            if (id === "-1") {
                $('#form-add-author').fadeIn('slow');
            } else {
                $('#form-add-author').fadeOut('slow');
            }
        });

        $('#btnAddAuthor').live('click', function() {
            var id = $('#option_author').val();
            form_requaired_validation('#description_author', true);
            form_requaired_validation('#option_author', true);

            if (id === '-1') {
                form_requaired_validation('#first_name_author', true);
                if ($('#description_author').valid() && $('#option_author').valid() && $('#first_name_author').valid()) {

                    var desc_author = $('#description_author').val();
                    var first_name = $('#first_name_author').val();
                    var last_name = $('#last_name_author').val();
                    var front_degree = $('#front_degree_author').val();
                    var back_degree = $('#back_degree_author').val();

                    $.post('addauthortemp', {
                        other: 'yes',
                        desc_author: desc_author,
                        first_name: first_name,
                        last_name: last_name,
                        front_degree: front_degree,
                        back_degree: back_degree
                    }, function(o) {
                        if (o) {
                            $('#list-author-selected').flexReload();
                        } else {
                            alert('Proses Gagal.');
                        }
                    }, 'json');
                }
            } else {
                if ($('#description_author').valid() && $('#option_author').valid()) {
                    $.post('addauthortemp', {
                        other: 'no',
                        val: id
                    }, function(o) {
                        if (o) {
                            $('#list-author-selected').flexReload();
                        } else {
                            alert('Proses Gagal.');
                        }
                    }, 'json');
                }
            }
            form_requaired_validation('#description_author', false);
            form_requaired_validation('#option_author', false);
            form_requaired_validation('#first_name_author', false);
        });

        $('#list-author-selected a[href=#setprimary]').live('click', function() {
            var id = $(this).attr('rel');
            $.post('setprimaryauthor', {
                val: id
            }, function(o) {
                if (o) {
                    $('#list-author-selected').flexReload();
                } else {
                    alert('Proses Gagal.');
                }
            }, 'json');
            return false;
        });

        /* FLEXYGRID AUTHOR*/
        var listId4 = '#list-author-selected';
        var title4 = $(listId4).attr('title');
        var link_r4 = $(listId4).attr('link_r');
        var link_d4 = $(listId4).attr('link_d');

        var option4 = {
            url: link_r4,
            dataType: 'xml',
            colModel: [{
                    display: 'ID',
                    name: 'book_author_temp_id',
                    width: 40,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Nama',
                    name: 'author_name',
                    width: 250,
                    sortable: true,
                    align: 'left'
                }, {
                    display: 'Keterangan',
                    name: 'author_description_title',
                    width: 150,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Status',
                    name: 'publisher_description',
                    width: 100,
                    align: 'center'
                }, {
                    display: 'Option',
                    width: 120,
                    align: 'center'
                }],
            buttons: [{
                    name: 'Hapus',
                    bclass: 'delete',
                    onpress: function() {
                        var leng = $(listId4 + ' .trSelected').length;
                        var conf = confirm('Delete ' + leng + ' items?');

                        if (conf) {
                            if (leng > 0) {
                                var tempId = [];
                                $(listId4 + ' .trSelected td[abbr=book_author_temp_id] div').each(function() {
                                    tempId.push(parseInt($(this).text()));
                                });

                                $.post(link_d4, {
                                    id: tempId.join(',')
                                }, function(o) {
                                    if (o) {
                                        $(listId4).flexReload();
                                    } else {
                                        alert('Proses delete gagal.');
                                    }
                                }, 'json');
                            }
                        }
                    }
                }],
            nowrap: false,
            sortname: "book_author_temp_id",
            sortorder: "asc",
            usepager: true,
            title: title4,
            useRp: false,
            rp: 15,
            showTableToggleBtn: true,
            resizable: false,
            width: screen.width * 0.4,
            height: 150
        };

        $(listId4).flexigrid(option4);

        /* FLEXYGRID DDC */
        var listId5 = '#list-ddc';
        var title5 = $(listId5).attr('title');
        var link_r5 = $(listId5).attr('link_r');

        var option5 = {
            url: link_r5,
            dataType: 'xml',
            colModel: [{
                    display: 'ID',
                    name: 'ddc_id',
                    width: 80,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Nomor Klasifikasi',
                    name: 'ddc_classification_number',
                    width: 150,
                    sortable: true,
                    align: 'center'
                }, {
                    display: 'Keterangan',
                    name: 'ddc_title',
                    width: 700,
                    align: 'left'
                }],
            nowrap: false,
            sortname: "ddc_id",
            sortorder: "asc",
            usepager: true,
            title: title5,
            useRp: false,
            rp: 15,
            showTableToggleBtn: true,
            resizable: false,
            singleSelect: true,
            width: screen.width * 0.67,
            height: 300,
            onSubmit: function() {
                var dt = $('#fAdd').serializeArray();
                $(listId5).flexOptions({
                    params: dt
                });
                return true;
            }
        };

        $(listId5).flexigrid(option5);

        /* FILTER DDC */
        $('#ddcLevel1').live('change', function() {
            var id = $(this).val();
            var url = $(this).attr('link');
            $('#ddcLevel2').html('<option>Loading...</option>');
            $.get(url, {
                id: id
            }, function(o) {
                $('#ddcLevel2').html(o);
            }, 'json');
        });

        $('#btnFilterDdc').live('click', function() {
            $('#list-ddc').flexOptions({
                newp: 1
            }).flexReload();
        });

        $('#list-ddc tbody tr[id*="row"]').live('click', function() {
            var id = '';
            var class_number = '';
            var status = $(this).attr('class');
            if (status === 'trSelected' || status === 'erow trSelected') {
                id = $(this).attr('id').substr(3);
                class_number = $('#row' + id + ' td[abbr=ddc_classification_number] div').html();
            }
            $('#ddcid').val(id);
            $('#preview_call_number .print_row_1').html(class_number);
        });

        /* TABS INPUT*/
        var $tabs = $('#tabs').tabs();
        $tabs.tabs('enable', 0)
                .tabs('select', 0)
                .tabs("option", "disabled", [0, 1, 2, 3, 4])
                .tabs('enable', 0);

        var tabnavigator = function(tabIndex) {
            $tabs.tabs('enable', tabIndex)
                    .tabs('select', tabIndex)
                    .tabs("option", "disabled", [0, 1, 2, 3, 4]).tabs('enable', tabIndex);
        };


        /* WYSIWYG elRTE */
        elRTE.prototype.options.panels.web2pyPanel = [
            'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
            'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist',
            'link', 'image'
        ];
        elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel', 'tables'];

        var opts = {
            cssClass: 'el-rte',
            height: 600,
            width: screen.width * 0.67,
            toolbar: 'web2pyToolbar',
            cssfiles: ['css/elrte-inner.css']
        };

        $('#reviews').elrte(opts);

        $('#price').autoNumeric({
            aPad: false
        });

        /* ADD ACTIONS */
        $('#fAdd').live('submit', function() {

            var stepStatus = $('#stepStatus').val();
            var curentTab = 0;
            
            /* Set Language ID to hidden form #language_hidden */
            var array_of_checked_values = $("#language").multiselect("getChecked").map(function(){
                return this.value;	
            }).get();
            $('#language_hide').val(array_of_checked_values.join(','));            
            
            /* alert(stepStatus); */

            if (stepStatus === '1') {
                var publisher = $('#publisher').val();
                if (publisher === '') {
                    curentTab = 1;
                    alert('Silahkan pilih penerbit buku!');
                } else {
                    /* *
                     * Cek Author 
                     * NB : Seharusnya tab selanjutnya dibuka jika proses cek selesai.
                     * */
                    $.get('getAuhtorPrimaryTemp', function(o) {
                        setting_callnumber(o, $('#title').val());
                    }, 'json');
                    curentTab = parseInt(stepStatus) + 1;
                }
            } else if (stepStatus === '2') {
                var ddcid = $('#ddcid').val();
                if (ddcid === '') {
                    curentTab = 2;
                    alert('Silahkan tentukan nomor klasifikasi!');
                } else {
                    generateCatalogue();
                    curentTab = parseInt(stepStatus) + 1;
                }
            } else if (stepStatus === '4') {
                frmID = $(this);
                
                msgID = $('#message');
                $(frmID).ajaxSubmit({
                    success: function(o) {
                        var parOut = o.replace('<div id="LCS_336D0C35_8A85_403a_B9D2_65C292C39087_communicationDiv"></div>', '');
                        if (parOut) {
                            var obj = eval('(' + parOut + ')');
                            $(msgID).html($.base64.decode(obj.html)).fadeIn('slow');
                            $(frmID)[0].reset();
                            $('#language-list').flexReload();
                            $('#publisher-list').flexReload();
                            $('#list-author-selected').flexReload();
                            $('#list-ddc').flexReload();
                        }
                    }
                });
                
               /* frmID.submit(); */
            } else {
                curentTab = parseInt(stepStatus) + 1;
            }

            tabnavigator(curentTab);
            $('#stepStatus').val(curentTab);

            return false;
        });

        /* TAB ACTION */
        $('#btnPrev').live('click', function() {
            var stepStatus = $('#stepStatus').val();
            var curentTab = parseInt(stepStatus) - 1;
            tabnavigator(curentTab);
            $('#stepStatus').val(curentTab);
        });

        /* BUTTON ACTION */
        $('#btnBack').live('click', function() {
            window.location = $(this).attr('link');
        });
        $('#btnPrintBarcode').live('click', function() {
            window.open($(this).attr('link'), '_blank');
        });
        $('#btnPrintLabel').live('click', function() {
            window.open($(this).attr('link'), '_blank');
        });


    });
</script>
