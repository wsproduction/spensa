<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link' => $link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
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
                <table style="width: 100%;">
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
                            Form::tips('Masukan Judul Bahasa Asing');
                            Form::size(100);
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
                            <div>
                                <?php
                                Form::create('select', 'language');
                                Form::tips('Pilih Bahasa');
                                Form::option($language, ' ');
                                Form::commit();
                                Form::create('text', 'otherlanguage');
                                Form::properties(array('style' => 'display:none;'));
                                Form::commit();
                                Form::create('button', 'btnAddLanguage');
                                Form::value('Tambah');
                                Form::style('action_add');
                                Form::commit();
                                ?>
                            </div>
                            <div style="padding: 0 0 0 2px;">
                                <table id="language-list" title="Daftar Pilihan Bahasa" link_r="<?php echo $link_r_language; ?>" link_d="<?php echo $link_d_language ?>"></table>
                            </div>
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
                            Form::commit();
                            echo 'x';
                            Form::create('text', 'height');
                            Form::tips('Masukan ukuran tinggi buku.');
                            Form::size(10);
                            Form::inputType()->numeric('.');
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
                            Form::commit();

                            Form::create('text', 'price');
                            Form::tips('Masukan harga buku.');
                            Form::size(20);
                            Form::inputType()->numeric();
                            Form::properties(array('style' => 'text-align:right;'));
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
                            Form::commit();
                            echo ' / ';
                            Form::create('select', 'fund');
                            Form::tips('Pilih sumber dana');
                            Form::option($book_fund, ' ');
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
                            Form::commit();
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">
                            <?php
                            Form::create('submit', 'btnStep1');
                            Form::value('Next to Step 2');
                            Form::style('action_next');
                            Form::commit();
                            ?>
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
                                <table style="width: 100%;" >
                                    <tr>
                                        <td style="width: 120px;">
                                            <div class="label-ina">Negara</div>
                                            <div class="label-eng">Country</div>
                                        </td>
                                        <td style="width: 5px;">:</td>
                                        <td style="width: 280px;">
                                            <?php
                                            Form::create('select', 'country');
                                            Form::tips('Select Country');
                                            Form::option($country, ' ');
                                            Form::validation()->requaired();
                                            Form::properties(array('link' => $link_province));
                                            Form::commit();
                                            ?>
                                        </td>
                                        <td rowspan="4" valign="top" id="view_info_publisher">
                                            <?php
                                            Form::create('hidden', 'publisher');
                                            Form::validation()->requaired();
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
                                            Form::properties(array('link' => $link_city));
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
                                <table>
                                    <tr>
                                        <td valign="top" style="width: 410px;">
                                            <table>
                                                <tr>
                                                    <td style="width: 120px;">
                                                        <div class="label-ina">Keterangan</div>
                                                        <div class="label-eng">Description</div>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                        Form::create('select', 'description_author');
                                                        Form::tips('Pilih keterangan penanggun jawab');
                                                        Form::option($author_description, ' ');
                                                        FOrm::properties(array('link' => $link_author));
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
                                                            Form::size(40);
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
                                                            Form::size(40);
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
                                                        Form::style('action_add');
                                                        Form::commit();
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top">
                                            <table id="list-author-selected" title="Daftar Penanggung Jawab" link_r="<?php echo $link_r_author_temp; ?>" link_d="<?php echo $link_d_author_temp; ?>"></table>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <?php
                            Form::create('button', 'btnPrev');
                            Form::value('Back to Step 1');
                            Form::style('action_prev');
                            Form::commit();
                            Form::create('submit', 'btnSave');
                            Form::value('Next to Step 3');
                            Form::style('action_next');
                            Form::commit();
                            ?>
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
                                            Form::option($ddc_level1,' ');
                                            Form::properties(array('link'=>$link_ddc_level2));
                                            Form::validation()->requaired('* Level 1 harus diisi.');
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
                                            Form::option(array('ddc_classification_number'=>'Nomor Klasifikasi','ddc_title'=>'Judul Klasifikasi','ddc_description'=>'Keteragan Klasifikasi'));
                                            Form::commit();
                                            Form::create('text', 'ddckeyword');
                                            Form::size(50);
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
                                            Form::style('action_search');
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
                            Form::create('hidden','ddcid');
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
                        <td style="text-align: right;">
                            <?php
                            Form::create('button', 'btnPrev');
                            Form::value('Back to Step 2');
                            Form::style('action_prev');
                            Form::commit();
                            Form::create('submit', 'btnSave');
                            Form::value('Next to Step 4');
                            Form::style('action_next');
                            Form::commit();
                            ?>
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
                            Form::style('action_prev');
                            Form::commit();
                            Form::create('submit', 'btnSave');
                            Form::value('Next to Step 5');
                            Form::style('action_next');
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
                        <td style="text-align: right;">
                            <?php
                            Form::create('button', 'btnPrev');
                            Form::value('Back to Step 4');
                            Form::style('action_prev');
                            Form::commit();
                            Form::create('submit', 'btnSave');
                            Form::value('Save');
                            Form::style('action_next');
                            Form::commit();
                            ?>
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
