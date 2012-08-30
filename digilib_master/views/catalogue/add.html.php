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
        Form::begin('fAdd', 'catalogue/create', 'post');

        Form::create('hidden', 'stepStatus');
        Form::value(1);
        Form::commit()
        ?>
        <div class="myTab">
            <ul class="header">
                <li id="s1">1. Book Detail</li>
                <li id="s2" style="background: #ccc;">2. Author</li>
                <li id="s3" style="background: #ccc;">3. DDC</li>
                <li id="s4" style="background: #ccc;">4. File</li>
                <li id="s5" style="background: #ccc;">5. Confirmation</li>
            </ul>
        </div>
        <div class="myTabContent">
            <table id="addStep1" style="width: 100%;">
                <tr>
                    <td style="width: 230px;">Titles *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'title');
                        Form::tips('Enter Title of Book');
                        Form::size(100);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Subtitles</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'subtitle');
                        Form::tips('Enter Subtitle of Book');
                        Form::size(100);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Publisher *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'publisher');
                        Form::tips('Select Publisher Name');
                        Form::option($publisher, ' ');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Country *</td>
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
                    <td>City *</td>
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
                <tr>
                    <td>Years *</td>
                    <td>:</td>
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
                <tr>
                    <td>Language *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'language');
                        Form::tips('Select Language of Book');
                        Form::option($language, ' ');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Edition</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'edition');
                        Form::tips('Enter Edition of Book');
                        Form::size(20);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Print-out</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'print_out');
                        Form::tips('Enter Print-out of Book');
                        Form::size(20);
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
                        Form::tips('Enter ISBN (<i>International Standar Book Number</i>)');
                        Form::size(20);
                        Form::inputType()->numeric('-');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Roman Number</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'roman_count');
                        Form::tips('Enter Page Count of Book');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Page Number</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'page_count');
                        Form::tips('Enter Page Count of Book');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Bibliography</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'bibliography');
                        Form::tips('Enter Page Count of Book');
                        Form::size(10);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr style="height: 30px;">
                    <td>Ilustration</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('checkbox', 'ilustration');
                        Form::size(10);
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
                        Form::size(10);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Size</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'width');
                        Form::tips('Enter Width');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::commit();
                        echo 'x';
                        Form::create('text', 'height');
                        Form::tips('Enter Height');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::commit();
                        echo 'Cm';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'weight');
                        Form::tips('Enter Weight');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::commit();
                        echo 'Kg';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Quantity *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'quantity');
                        Form::tips('Enter Quantity Book');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'accounting_symbol');
                        Form::tips('Select Accounting Symbol');
                        Form::option($accounting_symbol, ' ');
                        Form::commit();
                        Form::create('text', 'price');
                        Form::tips('Enter Price of Book');
                        Form::size(20);
                        Form::inputType()->numeric();
                        Form::properties(array('style' => 'text-align:right;'));
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Resouce</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'resource');
                        Form::tips('Select Resource');
                        Form::option($book_resource, ' ');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Fund</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'fund');
                        Form::tips('Select Fund');
                        Form::option($book_fund, ' ');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Reviews</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'review');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="height: 20px;">Type *</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'book_type');
                        Form::option($book_type,' ');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="height: 20px;">Lengt Borrowed</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'status');
                        Form::size(10);
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="height: 20px;">Status</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('checkbox', 'status');
                        Form::size(10);
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
                    <td style="width: 50%;" valign="top">
                        <fieldset>
                            <legend>Add Author</legend>
                            <div>
                                <div id="messageAuthor"></div>
                                <?php
                                Form::create('hidden', 'sessionAuthor');
                                Form::value(Session::id() . date('YmdHis'));
                                Form::commit();
                                ?>
                                <table>
                                    <tr>
                                        <td style="width: 150px;">First Name *</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'first_name_author');
                                            Form::tips('Enter First Name');
                                            Form::size(40);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'last_name_author');
                                            Form::tips('Enter Last Name');
                                            Form::size(40);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Front Degree</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'front_degree_author');
                                            Form::tips('Enter Front Degree<br>Exmp : Ir., Dr., DR., etc.');
                                            Form::size(10);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Back Degree</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            Form::create('text', 'back_degree_author');
                                            Form::tips('Enter Back Degree<br>Exmp : S.Pd.,S.Kom., etc.');
                                            Form::size(10);
                                            Form::commit();
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Description * </td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            Form::create('select', 'description_author');
                                            Form::tips('Enter Description');
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
                    <td style="width: 50%;" valign="top">
                        <fieldset>
                            <legend>Author List</legend>
                            <?php
                            Form::create('hidden', 'tempAuthorSelected');
                            Form::value(0);
                            Form::commit();
                            ?>
                            <table id="listAuthorSelected" class="list" style="width: 100%;" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;" class="first" >No.</th>
                                        <th>Author Name</th>
                                        <th style="width: 160px;">Description</th>
                                        <th style="width: 60px;">Action</th>
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
                                    <div style="height: 20px;" id="print_row_1">-</div>
                                    <div style="height: 20px;" id="print_row_2">WAR</div>
                                    <div style="height: 20px;" id="print_row_3">s</div>
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
                    <td style="width: 200px;">Cover</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('file', 'cover');
                        Form::commit();
                        ?>
                    </td>
                </tr>    
                <tr>
                    <td>File E-Book</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('file', 'cover');
                        Form::commit();
                        ?>
                    </td>
                </tr> 
                <tr>
                    <td colspan="3" style="text-align: right;">
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
                            <div><b>Author Catalogue</b></div>
                            <table  class="confCatalogue">
                                <tr>
                                    <td class="confCallNumber" valign="top">
                                        <div class="confRow1">00948.3</div>
                                        <div class="confRow2">SUG</div>
                                        <div class="confRow3">s</div>
                                    </td>
                                    <td valign="top">
                                        <div style="color: #fff;">000</div>
                                        <div>
                                            <div>SUGANDA, Warman</div>
                                            <div class="confContent">
                                                <span style="color: #fff;">AAA</span>
                                                Pedoman katalogisasi : cara mudah membuat  katalog perpustakaan / Yaya Suhendar. – Ed. 1, cet. 2. –  Bandung : Rosdakarya, 1990.
                                            </div>
                                            <div style="padding-left: 60px;">xi, 160 hlm. : ilus. ; 21 cm</div>
                                            <div style="padding-left: 60px;margin-top: 20px;">
                                                Biblliografi   : hlm. 135 – 136<br>
                                                Indeks<br>
                                                ISBN 979-514-005-1
                                            </div>
                                            <div style="margin-top: 30px;">
                                                <div style="float: left;width: 50%">1. KATALOG</div>
                                                <div style="float: left;width: 50%">I. Judul</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="confFrameCatalogue">
                            <div><b>Title Catalogue</b></div>
                            <table  class="confCatalogue">
                                <tr>
                                    <td class="confCallNumber" valign="top">
                                        <div class="confRow1">00948.3</div>
                                        <div class="confRow2">SUG</div>
                                        <div class="confRow3">s</div>
                                    </td>
                                    <td valign="top">
                                        <div style="color: #fff;">000</div>
                                        <div>
                                            <div>SUGANDA, Warman</div>
                                            <div class="confContent">
                                                <span style="color: #fff;">AAA</span>
                                                Pedoman katalogisasi : cara mudah membuat  katalog perpustakaan / Yaya Suhendar. – Ed. 1, cet. 2. –  Bandung : Rosdakarya, 1990.
                                            </div>
                                            <div style="padding-left: 60px;">xi, 160 hlm. : ilus. ; 21 cm</div>
                                            <div style="padding-left: 60px;margin-top: 20px;">
                                                Biblliografi   : hlm. 135 – 136<br>
                                                Indeks<br>
                                                ISBN 979-514-005-1
                                            </div>
                                            <div style="margin-top: 30px;">
                                                <div style="float: left;width: 50%">1. KATALOG</div>
                                                <div style="float: left;width: 50%">I. Judul</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="confFrameCatalogue">
                            <div><b>Subject Catalogue</b></div>
                            <table  class="confCatalogue">
                                <tr>
                                    <td class="confCallNumber" valign="top">
                                        <div class="confRow1">00948.3</div>
                                        <div class="confRow2">SUG</div>
                                        <div class="confRow3">s</div>
                                    </td>
                                    <td valign="top">
                                        <div style="color: #fff;">000</div>
                                        <div>
                                            <div>SUGANDA, Warman</div>
                                            <div class="confContent">
                                                <span style="color: #fff;">AAA</span>
                                                Pedoman katalogisasi : cara mudah membuat  katalog perpustakaan / Yaya Suhendar. – Ed. 1, cet. 2. –  Bandung : Rosdakarya, 1990.
                                            </div>
                                            <div style="padding-left: 60px;">xi, 160 hlm. : ilus. ; 21 cm</div>
                                            <div style="padding-left: 60px;margin-top: 20px;">
                                                Biblliografi   : hlm. 135 – 136<br>
                                                Indeks<br>
                                                ISBN 979-514-005-1
                                            </div>
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
