<?php

class Members extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryForm();
        Src::plugin()->jQueryBase64();
        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Daftar Anggota Perpustakaan / Library Members List');
        $this->view->link_r = $this->content->setLink('members/read');
        $this->view->link_c = $this->content->setLink('members/add');
        $this->view->link_d = $this->content->setLink('members/delete');
        $this->view->link_pl = $this->content->setLink('members/printlist');
        $this->view->link_apl = $this->content->setLink('members/addprintlist');
        $this->view->render('members/index');
    }

    public function printlist() {
        Web::setTitle('Daftar Print Kartu / Card Print List');
        $this->view->link_r = $this->content->setLink('members/readprintlist');
        $this->view->link_p = $this->content->setLink('members/printcard');
        $this->view->link_d = $this->content->setLink('members/deleteprintlist');
        $this->view->render('members/printlist');
    }

    public function add() {
        Web::setTitle('Tambah Anggota / Add Members');
        $this->view->link_back = $this->content->setLink('members');
        $this->view->list_gender = $this->listGender();
        $this->view->list_isa = $this->listIsa();
        $this->view->render('members/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit Anggota / Edit Members');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('members');
        $data = $this->model->selectMembersByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->list_gender = $this->listGender();
            $this->view->list_isa = $this->listIsa();
            $this->view->render('members/edit');
        } else {
            $this->view->render('default/message/pnf');
        }
    }

    public function listGender() {
        $list = $this->model->selectAllGender();
        $gender = array();
        foreach ($list as $value) {
            $gender[$value['gender_id']] = $value['gender_title'];
        }
        return $gender;
    }

    public function listIsa() {
        $list = $this->model->selectAllIsa();
        $gender = array();
        foreach ($list as $value) {
            $gender[$value['isa_id']] = $value['isa_title'];
        }
        return $gender;
    }

    public function create() {
        if ($this->model->createSave()) {
            $ket = array(1, 1, base64_encode($this->message->saveSucces()), ''); // sucess, reset, message
        } else {
            $ket = array(0, 0, base64_encode($this->message->saveError()), ''); // no sucess, no reset, message
        }
        echo json_encode($ket);
    }

    public function read() {
        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllMembers($page);
            $total = $this->model->countAllMembers();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                $link_detail = URL::link($this->content->setLink('members/detail/' . $row['members_id']), 'Detail', false);
                $link_edit = URL::link($this->content->setLink('members/edit/' . $row['members_id']), 'Edit', false);

                $xml .= "<row id='" . $row['members_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['members_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['members_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['members_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[0]]></cell>";
                $xml .= "<cell><![CDATA[0]]></cell>";
                $xml .= "<cell><![CDATA[0]]></cell>";
                $xml .= "<cell><![CDATA[0]]></cell>";
                $xml .= "<cell><![CDATA[0]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_detail . " | " . $link_edit . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function readprintlist() {
        if ($this->method->isAjax()) {

            Session::init();
            $sessionid = Session::id();

            $page = $this->method->post('page', 1);
            $listData = $this->model->selectAllPrintList($sessionid, $page);
            $total = $this->model->countAllPrintList($sessionid);

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData AS $row) {

                $link_detail = URL::link($this->content->setLink('members/detail/' . $row['members_id']), 'Detail', false);
                $link_edit = URL::link($this->content->setLink('members/edit/' . $row['members_id']), 'Edit', false);

                $xml .= "<row id='" . $row['members_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['members_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['members_name'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['gender_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['members_birthplace'] . ', ' . date('d', strtotime($row['members_birthdate'])) . ' ' . $this->listTextMonth(date('m', strtotime($row['members_birthdate']))) . ' ' . date('Y', strtotime($row['members_birthdate'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['members_address'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['isa_title'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['members_desc'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $link_detail . " | " . $link_edit . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function listTextMonth($id) {
        $list = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        return $list[$id - 1];
    }

    public function update($id = 0) {
        $process = $this->model->updateSave($id);
        if ($process[0]) {
            $ket = array(1, 0, base64_encode($this->message->saveSucces()), base64_encode(Src::image($process[1], 'http://' . Web::getHost() . '/web/src/digilib_admin/asset/upload/images/members/', array('style' => 'width:100px;border:1px solid #ccc;padding:4px;'))));
        } else {
            $ket = array(0, 0, base64_encode($this->message->saveError()), '');
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

    public function deleteprintlist() {
        Session::init();
        $sessionid = Session::id();
        $res = false;
        if ($this->model->deleteprintlist($sessionid)) {
            $res = true;
        }
        echo json_encode($res);
    }

    public function addPrintList() {
        if ($this->method->isAjax()) {
            Session::init();
            $sessionid = Session::id();
            $tempcount = $this->model->countTempPrintcardBySession($sessionid);
            $getid = $this->method->post('id');
            $setid = explode(',', $getid);
            $newid = array();

            if ($tempcount > 0) {
                $tempid = $this->model->selectTempPrintcardBySession($sessionid);
                $oldid = array();
                foreach ($tempid as $value) {
                    $oldid[] = $value['temp_members'];
                }

                foreach ($setid as $value) {
                    if (!in_array($value, $oldid))
                        $newid[] = $value;
                }
            } else {
                foreach ($setid as $value) {
                    $newid[] = $value;
                }
            }

            $this->model->savePrintList($sessionid, $newid);
            echo json_encode(true);
        }
    }

    public function printCard() {

        Session::init();
        $sessionid = Session::id();

        $pdf = Src::plugin()->tcPdf();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Warman Suganda');
        $pdf->SetTitle('Cetak Barcode Buku Induk');
        $pdf->SetSubject('Koleksi Buku');

        // set default header data
        $pdf->SetHeaderData('', '', 'Print Member Card of Library', 'SMP NEGERI 1 SUBANG');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(13, PDF_MARGIN_TOP, 12);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        //$pdf->setLanguageArray($l);
        // ---------------------------------------------------------
        $pdf->SetFont('helvetica', '', 10);

        // define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 6,
            'stretchtext' => 4
        );

        $note = "
                    <ol>
                        <li>Jika kartu anggota ini hilang segera melapor kepada Seksi Perpustakaan dan diganti dengan biaya Rp. 10.000,-</li>
                        <li>Waktu peminjaman buku paling lama 7 (tujuh) hari.</li>
                        <li>Peminjaman yang melewati batas waktu 7 (tujuh) hari dikenakan denda Rp. 2.000,-/hari/buku.</li>
                        <li>Buku peminjaman yang hilang harus diganti dengan jenis buku yang sama atau dengan uang sebesar 2 (dua) kali lipat harga buku tersebut.</li>
                        <li>Kartu anggota ini berlaku selama menjadi siswa SMP Negeri 1 Subang.</li>
                    </ol>
                ";

        $signature = "
                    Subang, 1 Juli 2012<br />
                    Kepala Perpustakaan,<br /><br /><br />
                    Ii Heri Hermawan, S.Pd.<br />
                    NIP. 19670902 199201 1 001
                ";

        $info = "
                    <b>Email :</b> info@digilib.smpn1subang.sch.id<br />
                    <b>Webstie :</b> digilib.smpn1subang.sch.id
                ";

        $node = array(
            1 => array(
                'bg' => array('x' => 13, 'y' => 21),
                'profile' => array(
                    'name' => array('x' => 49, 'y' => 56.7),
                    'gender' => array('x' => 49, 'y' => 60.5),
                    'birthday' => array('x' => 49, 'y' => 64.1),
                    'address' => array('x' => 49, 'y' => 67.8),
                    'level' => array(
                        'ina' => array('x' => 29.5, 'y' => 72.3),
                        'eng' => array('x' => 29.5, 'y' => 74.7)
                    ),
                    'photo' => array('x' => 14.9, 'y' => 57.9),
                    'barcode' => array('x' => 22.4, 'y' => 45.4)
                ),
                'info' => array(
                    'webmail' => array('x' => 50.5, 'y' => 43.2),
                    'signature' => array('x' => 22, 'y' => 54),
                    'note' => array('x' => 51.5, 'y' => 65.2),
                    'sign' => array('x' => 20, 'y' => 52)
            )),
            2 => array(
                'bg' => array('x' => 110, 'y' => 21),
                'profile' => array(
                    'name' => array('x' => 145.8, 'y' => 56.7),
                    'gender' => array('x' => 145.8, 'y' => 60.5),
                    'birthday' => array('x' => 145.8, 'y' => 64.1),
                    'address' => array('x' => 146, 'y' => 67.8),
                    'level' => array(
                        'ina' => array('x' => 126.5, 'y' => 72.3),
                        'eng' => array('x' => 126.5, 'y' => 74.7)
                    ),
                    'photo' => array('x' => 111.8, 'y' => 57.9),
                    'barcode' => array('x' => 70.8, 'y' => 45.4)
                ),
                'info' => array(
                    'webmail' => array('x' => 98.9, 'y' => 43.2),
                    'signature' => array('x' => 70.5, 'y' => 54),
                    'note' => array('x' => 99.9, 'y' => 65.2),
                    'sign' => array('x' => 68.5, 'y' => 52)
            )),
            3 => array(
                'bg' => array('x' => 13, 'y' => 146),
                'profile' => array(
                    'name' => array('x' => 49, 'y' => 181.7),
                    'gender' => array('x' => 49, 'y' => 185.5),
                    'birthday' => array('x' => 49, 'y' => 189.1),
                    'address' => array('x' => 49, 'y' => 192.8),
                    'level' => array(
                        'ina' => array('x' => 29.5, 'y' => 197.3),
                        'eng' => array('x' => 29.5, 'y' => 199.7)
                    ),
                    'photo' => array('x' => 14.9, 'y' => 182.9),
                    'barcode' => array('x' => 22.4, 'y' => 107.9)
                ),
                'info' => array(
                    'webmail' => array('x' => 50.5, 'y' => 105.7),
                    'signature' => array('x' => 22, 'y' => 116.5),
                    'note' => array('x' => 51.5, 'y' => 127.7),
                    'sign' => array('x' => 20, 'y' => 114.5)
            )),
            4 => array(
                'bg' => array('x' => 110, 'y' => 146),
                'profile' => array(
                    'name' => array('x' => 145.8, 'y' => 181.7),
                    'gender' => array('x' => 145.8, 'y' => 185.5),
                    'birthday' => array('x' => 145.8, 'y' => 189.1),
                    'address' => array('x' => 146, 'y' => 192.8),
                    'level' => array(
                        'ina' => array('x' => 126.5, 'y' => 197.3),
                        'eng' => array('x' => 126.5, 'y' => 199.7)
                    ),
                    'photo' => array('x' => 111.8, 'y' => 182.9),
                    'barcode' => array('x' => 70.8, 'y' => 107.9)
                ),
                'info' => array(
                    'webmail' => array('x' => 98.9, 'y' => 105.7),
                    'signature' => array('x' => 70.5, 'y' => 116.5),
                    'note' => array('x' => 99.9, 'y' => 127.7),
                    'sign' => array('x' => 68.5, 'y' => 114.5)
            ))
        );


        $countlist = $this->model->countAllPrintList($sessionid);

        if ($countlist) {
            $list = $this->model->selectPrintListBySession($sessionid);
            // Card 1
            $idx = 1;

            foreach ($list as $value) {

                if ($idx == 1) {
                    // add a page
                    $pdf->AddPage();
                }

                // Background
                $bg = Web::path() . 'asset/upload/images/format-kartu-perpustakaan.png';
                $pdf->Image($bg, $node[$idx]['bg']['x'], $node[$idx]['bg']['y'], 88, 116, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                // Biodata
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('helvetica', 'B', 6);
                $pdf->Text($node[$idx]['profile']['name']['x'], $node[$idx]['profile']['name']['y'], $value['members_name']);
                $pdf->SetFont('helvetica', '', 6);
                $pdf->Text($node[$idx]['profile']['gender']['x'], $node[$idx]['profile']['gender']['y'], $value['gender_title']);
                $pdf->Text($node[$idx]['profile']['birthday']['x'], $node[$idx]['profile']['birthday']['y'], $value['members_birthplace'] . ', ' . date('d', strtotime($value['members_birthdate'])) . ' ' . $this->listTextMonth(date('m', strtotime($value['members_birthdate']))) . ' ' . date('Y', strtotime($value['members_birthdate'])));
                $pdf->MultiCell(52, 0, $value['members_address'], 0, 'L', false, 1, $node[$idx]['profile']['address']['x'], $node[$idx]['profile']['address']['y'], true, 0, false, true, 0, 'T', false);

                list($isa_ina, $isa_eng) = explode('/', $value['isa_title']);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetFont('helvetica', 'BU', 6.5);
                $pdf->Text($node[$idx]['profile']['level']['ina']['x'], $node[$idx]['profile']['level']['ina']['y'], strtoupper(trim($isa_ina)));
                $pdf->SetFont('helvetica', 'BI', 3.5);
                $pdf->Text($node[$idx]['profile']['level']['eng']['x'], $node[$idx]['profile']['level']['eng']['y'], strtoupper(trim($isa_eng)));

                if ($value['members_photo'] != '') {

                    $extfile = array('jpg', 'jpeg', 'png');

                    $tempfile = explode('.', $value['members_photo']);
                    $ext = $tempfile[1];

                    if (in_array($ext, $extfile)) {
                        // Photo
                        $photo = Web::path() . 'asset/upload/images/members/' . $value['members_photo'];
                        $pdf->Image($photo, $node[$idx]['profile']['photo']['x'], $node[$idx]['profile']['photo']['y'], 13.8, 18.9, strtoupper($ext), '', 'T', false, 300, '', false, false, 0, false, false, false);
                    }
                }
                // Barcode
                $pdf->StartTransform();
                $pdf->MirrorV($node[$idx]['profile']['barcode']['y']);
                $pdf->MirrorH($node[$idx]['profile']['barcode']['x']);
                $pdf->write1DBarcode($value['members_id'], 'C128C', 0, 0, 32, 12, 0.4, $style, '');
                $pdf->StopTransform();

                $pdf->SetFont('helvetica', '', 6);
                // Info
                $pdf->StartTransform();
                $pdf->MirrorV($node[$idx]['info']['webmail']['y']);
                $pdf->MirrorH($node[$idx]['info']['webmail']['x']);
                $pdf->writeHTMLCell(57, 20, 0, 0, $info, 0);
                $pdf->StopTransform();
                $pdf->SetFont('helvetica', '', 5.5);
                // Tanda tangan 
                $pdf->StartTransform();
                $pdf->MirrorV($node[$idx]['info']['signature']['y']);
                $pdf->MirrorH($node[$idx]['info']['signature']['x']);
                $pdf->writeHTMLCell(33.5, 16, 0, 0, $signature, 0);
                $pdf->StopTransform();
                // Catatan
                $pdf->StartTransform();
                $pdf->MirrorV($node[$idx]['info']['note']['y']);
                $pdf->MirrorH($node[$idx]['info']['note']['x']);
                $pdf->writeHTMLCell(88, 20, 0, 0, $note, 0);
                $pdf->StopTransform();
                // TTD
                $pdf->StartTransform();
                $pdf->MirrorV($node[$idx]['info']['sign']['y']);
                $pdf->MirrorH($node[$idx]['info']['sign']['x']);
                $ttd = Web::path() . 'asset/upload/images/ttd-pa-ii.png';
                $pdf->Image($ttd, 0, 0, 10, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $pdf->StopTransform();

                if ($idx == 4) {
                    $idx = 1;
                } else {
                    $idx++;
                }
            }
            // ---------------------------------------------------------
            //Close and output PDF document
            $pdf->Output('example_013.pdf', 'I');
        }
    }

}