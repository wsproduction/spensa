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
        Form::value(1);
        Form::commit()
        ?>
        <div class="myTab">
            <ul class="header">
                <li id="s1">1. Keterangan Buku</li>
                <li id="s2" style="background: #ccc;">2. Penanggung Jawab</li>
                <li id="s3" style="background: #ccc;">3. DDC</li>
                <li id="s4" style="background: #ccc;">4. Resensi</li>
                <li id="s6" style="background: #ccc;">5. Confirmation</li>
            </ul>
        </div>
        <div class="myTabContent">
            <table id="addStep1" style="width: 100%;">
                <tr>
                    <td style="width: 230px;">Judul *</td>
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
                    <td>Anak Judul</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'sub_title');
                        Form::tips('Masukan Anak Judul');
                        Form::size(100);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Judul Bahasa Asing</td>
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
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'desc_title');
                        Form::tips('Masukan keterangan buku.');
                        Form::size(80);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Bahasa *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'language');
                        Form::tips('Pilih Bahasa');
                        Form::option($language, ' ');
                        Form::validation()->requaired('* Bahasa harus diisi.');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Edisi</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'edition');
                        Form::tips('Masukan Edisi Buku Keberapa?');
                        Form::inputType()->numeric();
                        Form::size(5);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Cetakan</td>
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
                    <td>ISBN</td>
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
                    <td>Jumlah Halaman Romawi</td>
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
                    <td>Jumlah Halaman Angka *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'page_count');
                        Form::tips('Masukan nomor halaman angka. Contoh: 120');
                        Form::size(5);
                        Form::validation()->requaired('* Halaman angka harus diisi.');
                        Form::validation()->number('* Periksa angka dengan benar.');
                        Form::validation()->min(1);
                        Form::inputType()->numeric();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Bibliografi</td>
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
                    <td>Ilustrasi</td>
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
                    <td style="height: 30px;">Index</td>
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
                    <td>Ukuran</td>
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
                    <td>Berat</td>
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
                    <td>Jumlah Eksemplar  *</td>
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
                    <td>Harga</td>
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
                    <td>Asal / Sumber</td>
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
                    <td>Jenis Buku *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'book_type');
                        Form::option($book_type, ' ');
                        Form::tips('Pilih jenis buku');
                        Form::validation()->requaired('* Jenis buku harus diisi.');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;" valign="middle">Bentuk Buku</td>
                    <td valign="middle">:</td>
                    <td valign="middle">
                        <?php
                        Form::create('checkbox', 'hard_copy');
                        Form::size(10);
                        Form::commit();
                        echo ' Buku Cetak &nbsp;&nbsp;&nbsp;';
                        Form::create('checkbox', 'soft_copy');
                        Form::size(10);
                        Form::commit();
                        echo ' Buku Electronik';
                        ?>
                    </td>
                </tr>
                <tr >
                    <td>Lama Peminjaman * </td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'length_borrowed');
                        Form::tips('Masukan lama peminjaman');
                        Form::option($length_borrowed, ' ');
                        Form::validation()->requaired('* Lama peminjaman harus diisi.');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Cover</td>
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
                    <td>File E-Book</td>
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
                    <td style="padding: 10px 0;" valign="middle">Status Buku</td>
                    <td valign="middle">:</td>
                    <td valign="middle">
                        <?php
                        Form::create('checkbox', 'status');
                        Form::value(1);
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

            <table id="addStep2" style="display: none;width: 100%;">
                <tr>
                    <td colspan="2" style="border-bottom: 1px dashed #ccc;padding-bottom: 10px;">
                        <fieldset>
                            <legend>Keterangan Penerbit</legend>
                            <table style="width: 100%;" >
                                <tr>
                                    <td style="width: 200px;">Penerbit *</td>
                                    <td style="width: 10px;">:</td>
                                    <td style="width: 350px;">
                                        <?php
                                        Form::create('select', 'publisher');
                                        Form::tips('Select Publisher Name');
                                        Form::option($publisher, ' ');
                                        Form::validation()->requaired();
                                        Form::properties(array('link' => $link_info_publisher));
                                        Form::commit();
                                        ?>
                                    </td>
                                    <td rowspan="4" valign="top" id="view_info_publisher">
                                        <div id="info_publisher">
                                            <table style="width: 100%">
                                                <tr>
                                                    <td style="width: 128px;" valign="top">
                                                        <?php echo Src::image('128.png', null, array('id' => "publisherLogo")); ?>
                                                    </td>
                                                    <td valign="top" style="padding: 5px 10px;font-size: 11px;">
                                                        <div style="font-weight: bold"> &Lt; Nama Penerbit &Gt;</div>
                                                        <div> &Lt; Alamat &Gt;</div>
                                                        <div>Telp. : - , Fax. : -</div>
                                                        <div>Email : -</div>
                                                        <div>Website : - </div>
                                                        <div style="padding-top: 5px;">Keterangan :</div>
                                                        <div>-</div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Negara *</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                        Form::create('select', 'country');
                                        Form::tips('Select Country');
                                        Form::option($country, ' ');
                                        Form::validation()->requaired();
                                        Form::properties(array('link' => $link_city));
                                        Form::commit();
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kota *</td>
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
                                    <td style="padding-top: 8px;">Tahun *</td>
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
                    <td valign="top" style="padding-top: 10px;">
                        <fieldset>
                            <legend>Form Tambah Penanggung Jawab</legend>
                            <div>
                                <div id="messageAuthor"></div>
                                <?php
                                Form::create('hidden', 'sessionAuthor');
                                Form::value($session_id_temp);
                                Form::commit();
                                ?>
                                <table>
                                    <tr>
                                        <td style="width: 150px;">Nama Depan *</td>
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
                                        <td>Nama Belakang</td>
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
                                        <td>Gelar Depan</td>
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
                                        <td>Gelar Belakang</td>
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
                                    <tr>
                                        <td>Keterangan * </td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'description_author');
                                            Form::tips('Pilih keterangan penanggun jawab');
                                            Form::option($author_description, ' ');
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?php
                                            Form::create('button', 'btnAddAuthor');
                                            Form::value('Add');
                                            Form::style('action_save');
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </fieldset>
                    </td>
                    <td style="width: 50%;padding-top: 10px;" valign="top">
                        <fieldset>
                            <legend>Daftar Penanggung Jawab</legend>
                            <?php
                            Form::create('hidden', 'tempAuthorSelected');
                            Form::value(0);
                            Form::commit();
                            ?>
                            <table id="listAuthorSelected" class="list" style="width: 100%;" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;" class="first" >No.</th>
                                        <th>Nama</th>
                                        <th style="width: 160px;">Keterangan</th>
                                        <th style="width: 60px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="body" style="">
                                    <tr>
                                        <td colspan="4" class="first" style="text-align: center;"><i>Data Not Found</i></td>
                                    </tr>
                                </tbody>
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

            <table id="addStep3" style="width: 100%;display: none;">
                <tr>
                    <td>
                        <fieldset>
                            <legend>Level 1</legend>
                            <div id="filter_box">
                                <div class="left">
                                    <?php
                                    Form::label('Filter | ', 'keyword');
                                    Form::create('text', 'keyword');
                                    Form::tips('Type keyword');
                                    Form::size(40);
                                    Form::commit();

                                    Form::create('select', 'filterCategory');
                                    Form::tips('Type keyword');
                                    Form::option(array(1 => 'Call Number', 2 => 'Title'));
                                    Form::commit();

                                    Form::create('button', 'btnFilter');
                                    Form::value('Search');
                                    Form::style('action_search');
                                    Form::commit();

                                    Form::create('hidden', 'tempSelectId1');
                                    Form::value(0);
                                    Form::commit();
                                    ?>
                                </div>
                            </div>
                            <table id="list1" class="list" style="width: 100%;" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 250px;" class="first" >Classification Number</th>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody class="body">
                                    <?php echo $ddc_level1; ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px;">
                        <fieldset>
                            <legend>Level 2</legend>
                            <div id="filter_box">
                                <div class="left">
                                    <?php
                                    Form::label('Filter | ', 'keyword');
                                    Form::create('text', 'keyword');
                                    Form::tips('Type keyword');
                                    Form::size(40);
                                    Form::commit();

                                    Form::create('select', 'filterCategory');
                                    Form::tips('Type keyword');
                                    Form::option(array(1 => 'Call Number', 2 => 'Title'));
                                    Form::commit();

                                    Form::create('button', 'btnFilter');
                                    Form::value('Search');
                                    Form::style('action_search');
                                    Form::commit();

                                    Form::create('hidden', 'tempSelectId2');
                                    Form::value(0);
                                    Form::commit();
                                    ?>
                                </div>
                            </div>
                            <table id="list2" class="list" style="width: 100%;" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 250px;" class="first" >Classification Number</th>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody class="body">
                                    <tr>
                                        <td colspan="2" class="first" style="text-align: center;"><i>Data Not Found</i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px;">
                        <fieldset>
                            <legend>Level 3</legend>
                            <div id="filter_box">
                                <div class="left">
                                    <?php
                                    Form::label('Filter | ', 'keyword');
                                    Form::create('text', 'keyword');
                                    Form::tips('Type keyword');
                                    Form::size(40);
                                    Form::commit();

                                    Form::create('select', 'filterCategory');
                                    Form::tips('Type keyword');
                                    Form::option(array(1 => 'Call Number', 2 => 'Title'));
                                    Form::commit();

                                    Form::create('button', 'btnFilter');
                                    Form::value('Search');
                                    Form::style('action_search');
                                    Form::commit();

                                    Form::create('hidden', 'tempSelectId3');
                                    Form::value(0);
                                    Form::commit();
                                    ?>
                                </div>
                            </div>
                            <table id="list3" class="list" style="width: 100%;" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 250px;" class="first" >Classification Number</th>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody class="body">
                                    <tr>
                                        <td colspan="2" class="first" style="text-align: center;"><i>Data Not Found</i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px;">
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

            <table id="addStep4" style="display: none;width: 100%">
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

            <table id="addStep5" style="display:none;width: 100%"> 
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
        <?php
        Form::end();
        ?>
    </div>
</div>
