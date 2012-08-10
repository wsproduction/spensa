<div id="box">
    <div id="box_title">
        <div class="left"><?php echo Web::getTitle(); ?></div>
        <div class="right">
            <?php            
            Form::create('button', 'btnBack');
            Form::value('Back');
            Form::style('action_back');
            Form::properties(array('link'=>$link_back));
            Form::commit();
            ?>
        </div>
    </div>
    <div id="box_content">
        <div id="message"></div>
        <?php
        Form::begin('fAdd', 'catalogue/create', 'post');
            
            Form::create('hidden','stepStatus');
            Form::value(1);
            Form::commit()
        ?>
        <div class="myTab">
            <ul class="header">
                <li id="s1">1. Book Detail</li>
                <li id="s2" style="background: #ccc;">2. DDC</li>
                <li id="s3" style="background: #ccc;">3. File</li>
                <li id="s4" style="background: #ccc;">4. Confirmation</li>
            </ul>
        </div>
        <div class="myTabContent">
            <table id="addStep1" style="display: none;">
                <tr>
                    <td style="width: 200px;">Titles</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'title');
                        Form::tips('Enter Title of Book');
                        Form::size(70);
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
                        Form::size(70);
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Author</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'author');
                        Form::tips('Enter Author Name');
                        Form::size(40);
                        Form::validation()->requaired();
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
                    <td>Publisher</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'publisher');
                        Form::tips('Select Publisher Name');
                        Form::option($publisher,' ');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'country');
                        Form::tips('Select Country');
                        Form::option($country,' ');
                        Form::validation()->requaired();
                        Form::properties(array('link'=>$link_city));
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>City</td>
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
                    <td>Years</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'year');
                        Form::tips('Years');
                        Form::option($years,' ');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Language</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('select', 'language');
                        Form::tips('Select Language of Book');
                        Form::option($language,' ');
                        Form::validation()->requaired();
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Page Count</td>
                    <td>:</td>
                    <td>
                        <?php
                        Form::create('text', 'page_count');
                        Form::tips('Enter Page Count of Book');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::validation()->requaired();
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
                        Form::validation()->requaired();
                        Form::commit();
                        echo 'x';
                        Form::create('text', 'height');
                        Form::tips('Enter Height');
                        Form::size(10);
                        Form::inputType()->numeric();
                        Form::validation()->requaired();
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
                        Form::validation()->requaired();
                        Form::commit();
                        echo 'Kg';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Quantity</td>
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
                        Form::option($accounting_symbol,' ');
                        Form::validation()->requaired();
                        Form::commit();
                        Form::create('text', 'price');
                        Form::tips('Enter Price of Book');
                        Form::size(20);
                        Form::inputType()->numeric();
                        Form::properties(array('style'=>'text-align:right;'));
                        Form::validation()->requaired();
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
                        Form::option($book_resource,' ');
                        Form::validation()->requaired();
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
                        Form::option($book_fund,' ');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Reviews</td>
                    <td valign="top">:</td>
                    <td>
                        <?php
                        Form::create('textarea', 'profile');
                        Form::commit();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php
                        Form::create('submit', 'btnStep1');
                        Form::value('Next');
                        Form::style('action_next');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
            
            <table id="addStep2" style="width: 100%;">
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
                                    
                                    Form::create('hidden','tempSelectId1');
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
                                    
                                    Form::create('hidden','tempSelectId2');
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
                                        <td colspan="2" class="first" style="text-align: center;">Data Not Found</td>
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
                                    
                                    Form::create('hidden','tempSelectId3');
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
                                        <td colspan="2" class="first" style="text-align: center;">Data Not Found</td>
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
                                    <div id="print_row_1">-</div>
                                    <div id="print_row_2">WAR</div>
                                    <div id="print_row_3">s</div>
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
                        <?php
                        Form::create('button', 'btnPrev');
                        Form::value('Prev');
                        Form::style('action_prev');
                        Form::commit();
                        Form::create('submit', 'btnSave');
                        Form::value('Next');
                        Form::style('action_next');
                        Form::commit();
                        ?>
                    </td>
                </tr>
            </table>
            
            <table id="addStep3" style="display: none;">
                <tr>
                    <td>Cover</td>
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
                    <td></td>
                    <td></td>
                    <td>
                        <?php
                        Form::create('button', 'btnPrev');
                        Form::value('Prev');
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
