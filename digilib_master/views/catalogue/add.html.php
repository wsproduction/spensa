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
        ?>
        <div class="myTab">
            <ul class="header">
                <li>1. Book Detail</li>
                <li>2. DDC</li>
                <li>3. File</li>
                <li>4. Confirmation</li>
            </ul>
        </div>
        <div class="myTabContent">
            <table>
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
                    <td style="width: 200px;">Subtitles</td>
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
                    <td style="width: 200px;">Author</td>
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
                    <td style="width: 200px;">ISBN</td>
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
                    <td style="width: 200px;">Publisher</td>
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
                    <td style="width: 200px;">Country</td>
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
                    <td style="width: 200px;">City</td>
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
                    <td style="width: 200px;">Years</td>
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
                    <td style="width: 200px;">Language</td>
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
                    <td style="width: 200px;">Page Count</td>
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
                    <td style="width: 200px;">Size</td>
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
                    <td style="width: 200px;">Weight</td>
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
                    <td style="width: 200px;">Quantity</td>
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
                    <td style="width: 200px;">Price</td>
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
                    <td style="width: 200px;">Resouce</td>
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
                    <td style="width: 200px;">Fund</td>
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
                        Form::create('submit', 'btnSave');
                        Form::value('Next');
                        Form::style('action_next');
                        Form::commit();
                        Form::create('reset', 'btnReset');
                        Form::value('Reset');
                        Form::style('action_cancel');
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
