<?php

class Borrow extends Controller {

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
        Web::setTitle('Daftar Peminjaman Buku');
        $this->view->link_r = $this->content->setLink('borrow/read');
        $this->view->link_c = $this->content->setLink('borrow/add');
        $this->view->link_d = $this->content->setLink('borrow/delete');
        $this->view->render('borrow/index');
    }

    public function add() {
        Web::setTitle('Tambah Data Peminjaman Buku');
        $this->view->link_rbh = $this->content->setLink('borrow/readborrowhistory');
        $this->view->link_dbh = $this->content->setLink('borrow/deleteborrowhistory');
        $this->view->link_rct = $this->content->setLink('borrow/readborrowcart');
        $this->view->link_dct = $this->content->setLink('borrow/deleteborrowcart');
        $this->view->link_checkout = $this->content->setLink('borrow/checkout');
        $this->view->link_invoice = $this->content->setLink('borrow/invoice');
        $this->view->render('borrow/add');
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

                $xml .= "<row id='" . $row['borrowed_history_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_book'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<b>" . $row['ddc_classification_number'] . '</b><br>' . $row['book_title'] . $foreign_title . '. ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . ".]]></cell>";
                $xml .= "<cell><![CDATA[<b>" . $row['members_id'] . '</b><br> ' . $row['members_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_type_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<font color='blue'>" . date('d.m.Y', strtotime($row['borrowed_history_star'])) . '</font> s/d  <font color="blue">' . date('d.m.Y', strtotime($row['borrowed_history_finish'])) . "</font>]]></cell>";
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

                $xml .= "<row id='" . $row['borrowed_history_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_history_book'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['ddc_classification_number'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_title'] . $foreign_title . '. ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . ".]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_type_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<font color='blue'>" . date('d.m.Y', strtotime($row['borrowed_history_star'])) . '</font> s/d  <font color="blue">' . date('d.m.Y', strtotime($row['borrowed_history_finish'])) . "</font>]]></cell>";
                $row['borrowed_history_status'] ? $status = 'Dikembalikan' : $status = 'Meminjam';
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

    public function readborrowcart() {

        if ($this->method->isAjax()) {
            $memberid = $this->method->post('memberidtemp', 0);
            $borrowtype = $this->method->post('borrowedtype', 0);
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectBorrowedCart($memberid, $borrowtype, $page);
            $total = $this->model->countBorrowedCart($memberid, $borrowtype);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {
                $xml .= "<row id='" . $row['borrowed_temp_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_temp_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['borrowed_temp_book'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[<font color='blue'>" . date('d.m.Y', strtotime($row['borrowed_temp_start'])) . '</font> s/d <font color="blue">' . date('d.m.Y', strtotime($row['borrowed_temp_finish'])) . "</font>]]></cell>";

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
            $this->model->clearBorrowedCart($id);
            $list = $data[0];
            $info = array();
            $info['memberid'] = $id;
            $info['name'] = $list['members_name'];
            $info['birthinfo'] = $list['members_birthplace'] . ', ' . date('d', strtotime($list['members_birthdate'])) . ' ' . $this->content->monthName(date('m', strtotime($list['members_birthdate']))) . ' ' . date('Y', strtotime($list['members_birthdate']));
            $info['gender'] = $list['gender_title'];
            $info['isa'] = $list['isa_title'];
            $info['address'] = $list['members_address'];
            $info['photo'] = Src::image($list['members_photo'], 'http://' . Web::getHost() . '/web/src/' . Web::$webFolder . '/asset/upload/images/members/', array('id' => 'member-photo'));
            $info['temporer_status'] = $list['temporer_status'];
            $res = array(1, $info);
        } else {
            $res = array(0, null);
        }
        echo json_encode($res);
    }

    public function readbookinfo() {
        $bookregister = $this->method->post('bookregister');
        $borrowedtype = $this->method->post('borrowedtype');
        $data = $this->model->selectBookInfo($bookregister);

        if ($data) {

            $bookborrowedstatus = $this->model->selectBookBorrowedStatus($bookregister);

            if (count($bookborrowedstatus) == 0) {
                $listborrowedtype = $this->model->selectBorrowTypeById($borrowedtype);

                if (count($listborrowedtype) > 0) {
                    $databorrowedtype = $listborrowedtype[0];
                    $interval = $databorrowedtype['borrowed_type_interval'];

                    if ($borrowedtype == 1) {
                        $this->model->saveAddBookCart($interval);
                    } else if ($borrowedtype == 2) {
                        $this->model->saveAddBookCart($interval);
                    } else if ($borrowedtype == 3) {
                        $this->model->saveAddBookCart($interval);
                    }
                    $res = array(true);
                } else {
                    $res = array(false, 'Type Peminjaman Tidak ditemukan');
                }
            } else {
                $res = array(false, 'Buku ini sedang dipinjam');
            }
        } else {
            $res = array(false, 'Buku tidak ditemukan');
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
        if ($this->model->delete()) {
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

    public function deleteborrowcart() {
        $res = false;
        if ($this->model->deleteBorrowCart()) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function checkout() {
        $res = false;
        $memberid = $this->method->post('memberid');
        $cart = $this->model->selectBorrowingCartByMemberId($memberid);
        if ($cart) {
            if (count($cart) > 0) {
                if ($this->model->saveBorrowingCart($cart)) {
                    $res = true;
                }
            }
        }
        echo json_encode($res);
    }

    public function invoice($memberid) {

        $datamember = $this->model->selectMemberInfo($memberid);
        $cart = $this->model->selectBorrowingCartByMemberId($memberid);
        $this->model->clearBorrowedCart($memberid);

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
                                    <td width="45" align="center"><b>Tgl. Kembali</b></td>
                                </tr>';

        foreach ($cart as $rowcart) {
            $html .= '
                                <tr>
                                    <td align="center">' . $rowcart['borrowed_temp_book'] . '</td>
                                    <td>' . $rowcart['book_title'] . '</td>
                                    <td align="center">' . date('d/m/Y', strtotime($rowcart['borrowed_temp_finish'])) . '</td>
                                </tr>';
        }

        $html .= '
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