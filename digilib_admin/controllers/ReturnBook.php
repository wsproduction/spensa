<?php

class ReturnBook extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Pengambalian Buku');
        $this->view->link_r = $this->content->setLink('returnbook/read');
        $this->view->link_c = $this->content->setLink('returnbook/add');
        $this->view->link_d = $this->content->setLink('returnbook/delete');
        $this->view->render('returnbook/index');
    }

    public function add() {
        Web::setTitle('Tambah Data Pengambalian Buku');
        $this->view->link_rbh = $this->content->setLink('returnbook/readborrowhistory');
        $this->view->link_dbh = $this->content->setLink('returnbook/deleteborrowhistory');
        $this->view->link_rct = $this->content->setLink('returnbook/readreturncart');
        $this->view->link_dct = $this->content->setLink('returnbook/deletereturncart');
        $this->view->link_checkout = $this->content->setLink('returnbook/checkout');
        $this->view->link_invoice = $this->content->setLink('returnbook/invoice');
        $this->view->render('returnbook/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit Data Penerbit');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('publisher');
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->render('publisher/edit');
        } else {
            $this->view->render('default/message/pnf');
        }
    }

    public function create() {
        if ($this->model->createSave()) {
            $ket = array(1, 1, $this->message->saveSucces()); // sucess, reset, message
        } else {
            $ket = array(0, 0, $this->message->saveError()); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

    public function read() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllBorrowed($page);
            $total = $this->model->countAllBorrowed();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                $foreign_title = '';
                if (!empty($row['book_foreign_title']))
                    $foreign_title = ' / ' . $row['book_foreign_title'];

                $pinalty = '-';
                if ($row['borrowed_history_penalty'] > 0)
                    $pinalty = 'Rp. ' . $row['borrowed_history_penalty'];

                $author = $this->content->parsingAuthor($row['book_id']);
                $callnumber_extention = $this->content->callNumberExtention($author, $row['book_title']);

                $description = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
                $description .= '<br><b>' . $row['book_title'] . $foreign_title . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';


                $xml .= "<row id='" . $row['borrowed_history_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_book'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $description . "]]></cell>";
                $xml .= "<cell><![CDATA[<b>" . $row['members_id'] . '</b><br> ' . $row['members_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_type_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<font color='blue'>" . date('d.m.Y', strtotime($row['borrowed_history_star'])) . '</font> s/d  <font color="blue">' . date('d.m.Y', strtotime($row['borrowed_history_finish'])) . "</font>]]></cell>";
                $xml .= "<cell><![CDATA[" . $pinalty . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readborrowhistory() {

        if ($this->method->isAjax()) {
            $memberid = $this->method->post('memberid', 0);
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectBorrowedHistory($memberid, $page);
            $total = $this->model->countBorrowedHistory($memberid);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {
                $foreign_title = '';
                if (!empty($row['book_foreign_title']))
                    $foreign_title = ' / ' . $row['book_foreign_title'];

                $row['borrowed_history_status'] ? $status = 'Dikembalikan' : $status = 'Meminjam';

                $author = $this->content->parsingAuthor($row['book_id']);
                $callnumber_extention = $this->content->callNumberExtention($author, $row['book_title']);

                $description = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
                $description .= '<br><b>' . $row['book_title'] . $foreign_title . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';

                $xml .= "<row id='" . $row['borrowed_history_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_book'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $description . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_type_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<font color='blue'>" . date('d.m.Y', strtotime($row['borrowed_history_star'])) . '</font> s/d  <font color="blue">' . date('d.m.Y', strtotime($row['borrowed_history_finish'])) . "</font>]]></cell>";
                $xml .= "<cell><![CDATA[" . $status . "]]></cell>";
                if (!empty($row['borrowed_history_return']))
                    $xml .= "<cell><![CDATA[" . date('d.m.Y', strtotime($row['borrowed_history_return'])) . "]]></cell>";
                else
                    $xml .= "<cell><![CDATA[-]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readreturncart() {

        if ($this->method->isAjax()) {
            $memberid = $this->method->post('memberidtemp', 0);
            $borrowtype = $this->method->post('borrowedtype', 0);
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectReturnCart($memberid, $borrowtype, $page);
            $total = $this->model->countReturnCart($memberid, $borrowtype);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                $foreign_title = '';
                if (!empty($row['book_foreign_title']))
                    $foreign_title = ' / ' . $row['book_foreign_title'];

                $author = $this->content->parsingAuthor($row['book_id']);
                $callnumber_extention = $this->content->callNumberExtention($author, $row['book_title']);

                $description = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
                $description .= '<br><b>' . $row['book_title'] . $foreign_title . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';


                $xml .= "<row id='" . $row['borrowed_return_temp_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_return_temp_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_register_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $description . "]]></cell>";
                $xml .= "<cell><![CDATA[<font color='blue'>" . date('d.m.Y', strtotime($row['borrowed_history_star'])) . '</font> s/d <font color="blue">' . date('d.m.Y', strtotime($row['borrowed_history_finish'])) . "</font>]]></cell>";
                $pinalty = '-';
                if ($row['borrow_time'] > 0)
                    $pinalty = 'Rp. ' . $row['borrow_time'] * 2000;
                $xml .= "<cell><![CDATA[" . $pinalty . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readmemberinfo() {
        $id = $this->method->post('memberid');
        $data = $this->model->selectMemberInfo($id);
        if ($data) {
            $this->model->clearReturnCart($id);
            $list = $data[0];
            $info = array();
            $info['memberid'] = $id;
            $info['name'] = $list['members_name'];
            $info['birthinfo'] = $list['members_birthplace'] . ', ' . date('d', strtotime($list['members_birthdate'])) . ' ' . $this->content->monthName(date('m', strtotime($list['members_birthdate']))) . ' ' . date('Y', strtotime($list['members_birthdate']));
            $info['gender'] = $list['gender_title'];
            $info['isa'] = $list['isa_title'];
            $info['address'] = $list['members_address'];
            $info['photo'] = Src::image($list['members_photo'], 'http://' . Web::getHost() . '/web/src/' . Web::$webFolder . '/asset/upload/images/members/', array('id' => 'member-photo'));
            $res = array(1, $info);
        } else {
            $res = array(0, null);
        }
        echo json_encode($res);
    }

    public function readbookinfo() {
        $bmemberidtemp = $this->method->post('memberidtemp');
        $bookregister = $this->method->post('bookregister');
        $borrowedtype = $this->method->post('borrowedtype');
        $data = $this->model->selectBookInfo($bookregister, $borrowedtype, $bmemberidtemp);

        if ($data) {

            $borrowid = $data[0]['borrowed_history_id'];
            $listborrowedtype = $this->model->selectBorrowTypeById($borrowedtype);

            if (count($listborrowedtype) > 0) {
                $databorrowedtype = $listborrowedtype[0];
                $interval = $databorrowedtype['borrowed_type_interval'];

                if ($borrowedtype == 1) {
                    $this->model->saveAddBookCart($borrowid);
                } else if ($borrowedtype == 2) {
                    $this->model->saveAddBookCart($borrowid);
                } else if ($borrowedtype == 3) {
                    $this->model->saveAddBookCart($borrowid);
                }
            }

            $res = true;
        } else {
            $res = false;
        }

        echo json_encode($res);
    }

    public function update($id = 0) {
        if ($this->model->updateSave($id)) {
            $ket = array(1, 0, $this->message->saveSucces());
        } else {
            $ket = array(0, 0, $this->message->saveError());
        }
        echo json_encode($ket);
    }

    public function delete() {
        $res = false;
        if ($this->model->deleteSave()) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function deleteBorrowHistory() {
        $res = false;
        if ($this->model->deleteBorrowHistory()) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function deleteReturnCart() {
        $res = false;
        if ($this->model->deleteReturnCart()) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function checkout() {
        $res = false;
        $memberid = $this->method->post('memberid');
        $cart = $this->model->selectReturnCartByMemberId($memberid);
        if ($cart) {
            if (count($cart) > 0) {
                foreach ($cart as $value) {
                    $pinalty = 0;
                    if ($value['borrow_time'] > 0)
                        $pinalty = $value['borrow_time'] * 2000;

                    $this->model->saveReturnCart($value['borrowed_history_id'], $pinalty);
                }
                $res = true;
            }
        }
        echo json_encode($res);
    }

    public function invoice($memberid) {

        $datamember = $this->model->selectMemberInfo($memberid);
        $cart = $this->model->selectReturnCartByMemberId($memberid);
        $this->model->clearReturnCart($memberid);

        $pdf = Src::plugin()->tcPdf();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Warman Suganda');
        $pdf->SetTitle('TCPDF Example 061');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(true, 5);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 5.5);
        // add a page
        $pdf->AddPage('P', array(80, 100));

        $html = '
                <style>
                .company-name {
                    font-weight : bold;
                    font-size : 9pt;
                }
                .company-info {
                    font-size : 5.5pt;
                }
                .border-bottom-dashed {
                    border-bottom : 1px dashed #000;
                }
                .invoice-title {
                    font-weight : bold;
                    font-size : 6pt;
                }
                .book-list {
                    font-size : 5.5pt;
                }
                </style>
                <table cellpadding="0" cellspacing="0" width="245" border="0">
                    <tr>
                        <td align="center" class="company-name">PERPUSTAKAAN</td>
                    </tr>
                    <tr>
                        <td align="center" class="company-name">SMP NEGERI 1 SUBANG</td>
                    </tr>
                    <tr>
                        <td align="center" class="company-info">Jl. Letjen Soeprapto No. 105 Subang 41211 Telp. (0260) 411403 - 411404</td>
                    </tr>
                    <tr>
                        <td align="center" class="company-info border-bottom-dashed">Email : info@digilib.smpn1subang.sch.id Website : digilib.smpn1subang.sch.id</td>
                    </tr>
                    <tr>
                        <td align="center" class="invoice-title">&nbsp;<br><u>FAKTUR PEMINJAMAN</u><br>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" width="245" border="0">
                                <tr>
                                    <td width="55">ID</td>
                                    <td width="5">:</td>
                                    <td width="180">' . $memberid . '</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $datamember[0]['members_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Daftar Buku</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="book-list">
                            <table cellpadding="2" cellspacing="0" width="245" border="1">
                                <tr>
                                    <td width="55" align="center"><b>No. Induk Buku</b></td>
                                    <td width="140"><b>Judul Buku</b></td>
                                    <td width="45" align="center"><b>Denda</b></td>
                                </tr>';

        foreach ($cart as $rowcart) {
            $pinalty_total = 0;
            $pinalty = '-';
            if ($rowcart['borrow_time'] > 0) {
                $pinalty = 'Rp. ' . $rowcart['borrow_time'] * 2000;
                $pinalty_total += $rowcart['borrow_time'] * 2000;
            }

            $foreign_title = '';
            if (!empty($rowcart['book_foreign_title']))
                $foreign_title = ' / ' . $rowcart['book_foreign_title'];

            $author = $this->content->parsingAuthor($rowcart['book_id']);
            $callnumber_extention = $this->content->callNumberExtention($author, $rowcart['book_title']);

            $description = '<b>' . $rowcart['ddc_classification_number'] . $callnumber_extention . '</b>';
            $description .= '<br><b>' . $rowcart['book_title'] . $foreign_title . '.</b> ';
            $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
            $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($rowcart['city_name'])) . ' : ' . $rowcart['publisher_name'] . ', ' . $rowcart['book_publishing'] . '</font>';

            $html .= '
                                <tr>
                                    <td align="center">' . $rowcart['borrowed_history_book'] . '</td>
                                    <td>' . $description . '</td>
                                    <td align="center">' . $pinalty . '</td>
                                </tr>';
        }

        $html .= '
                                <tr>
                                    <td colspan="2">Total Denda</td>
                                    <td>Rp. ' . $pinalty_total . '</td>
                                </tr>
                           </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td rowspan="5" width="150">&nbsp;</td>
                                    <td>Subang, ' . date('d') . ' ' . $this->content->monthName(date('m')) . ' ' . date('Y') . '</td>
                                </tr>
                                <tr>
                                    <td>Pustakawan,</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Herda Sibutarbutar</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>';

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        // ---------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('example_061.pdf', 'I');
    }

}