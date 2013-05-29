<?php

class Collection extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryValidation();
        Src::plugin()->poshytip();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Buku Indux');
        $this->view->link_c = $this->content->setLink('collection/add');
        $this->view->link_r = $this->content->setLink('collection/read');
        $this->view->link_d = $this->content->setLink('collection/delete');
        $this->view->link_p = $this->content->setLink('collection/addprintbarcode');
        $this->view->link_pl = $this->content->setLink('collection/printlistbarcode');
        $this->view->render('collection/index');
    }

    public function add() {
        Web::setTitle('Add author');
        $this->view->link_back = $this->content->setLink('author');
        $this->view->render('author/add');
    }

    public function edit($id = 0) {
        Web::setTitle('Edit author');
        $this->view->id = $id;
        $this->view->link_back = $this->content->setLink('author');
        $data = $this->model->selectByID($id);
        if ($data) {
            $listData = $data[0];
            $this->view->dataEdit = $listData;
            $this->view->render('author/edit');
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
            $listData = $this->model->selectAllCollection($page);
            $total = $this->model->countAllCollection();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData as $row) {

                $author = $this->content->parsingAuthor($row['book_id']);
                $callnumber_extention = $this->content->callNumberExtention($author, $row['book_title']);

                $last_borrowed = '-';
                if (!empty($row['last_borrowed']))
                    $last_borrowed = date('d.m.Y', strtotime($row['last_borrowed']));

                $foreign_title = '';
                if (!empty($row['book_foreign_title']))
                    $foreign_title = ' / ' . $row['book_foreign_title'];

                $resource = '-';
                if (!empty($row['resource'])) {
                    $resource = $row['resource'];
                }

                $fund = '-';
                if (!empty($row['fund'])) {
                    $fund = $row['fund'];
                }

                $count_barcode_print = '0';
                if (!empty($row['book_count_barcode_print'])) {
                    $count_barcode_print = $row['book_count_barcode_print'];
                }

                $description = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
                $description .= '<br><b>' . $row['book_title'] . $foreign_title . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';


                $xml .= "<row id='" . $row['book_register_id'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['book_register_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $description . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $resource . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $fund . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_condition'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['total_borrowed'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $last_borrowed . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d.m.Y', strtotime($row['book_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $count_barcode_print . "]]></cell>";
                //$xml .= "<cell><![CDATA[<a href=''>Edit</a>]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
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
        $this->model->delete();
    }

    public function addPrintBarcode() {
        if ($this->method->isAjax()) {
            Session::init();
            $sessionid = Session::id();
            $tempid = $this->method->post('id');
            foreach (explode(',', $tempid) as $key => $value) {
                $this->model->saveTempPrintBarcode($value, $sessionid);
            }
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function printListBarcode() {
        Web::setTitle('Daftar Print Barcode');
        $this->view->link_r = $this->content->setLink('collection/readprintlistbarcode');
        $this->view->link_p = $this->content->setLink('collection/printbarcode');
        $this->view->link_d = $this->content->setLink('collection/deleteprintlistbarcode');
        $this->view->link_da = $this->content->setLink('collection/deleteprintlistbarcodeall');
        $this->view->render('collection/printlistbarcode');
    }

    public function readPrintlistBarcode() {

        if ($this->method->isAjax()) {
            $page = $this->method->post('page', 1);
            $listData = $this->model->selectPrintListBarcode($page);
            $total = $this->model->countPrintListBarcode();

            header("Content-type: text/xml");
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<rows>";
            $xml .= "<page>$page</page>";
            $xml .= "<total>$total</total>";

            foreach ($listData as $row) {

                $author = $this->content->parsingAuthor($row['book_id']);
                $callnumber_extention = $this->content->callNumberExtention($author, $row['book_title']);

                $last_borrowed = '-';
                if (!empty($row['last_borrowed']))
                    $last_borrowed = date('d.m.Y', strtotime($row['last_borrowed']));

                $foreign_title = '';
                if (!empty($row['book_foreign_title']))
                    $foreign_title = ' / ' . $row['book_foreign_title'];

                $resource = '-';
                if (!empty($row['resource'])) {
                    $resource = $row['resource'];
                }

                $fund = '-';
                if (!empty($row['fund'])) {
                    $fund = $row['fund'];
                }

                $count_barcode_print = '0';
                if (!empty($row['book_count_barcode_print'])) {
                    $count_barcode_print = $row['book_count_barcode_print'];
                }

                $description = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
                $description .= '<br><b>' . $row['book_title'] . $foreign_title . '.</b> ';
                $description .= '<br><font style="font-style:italic;color:#666;">' . $this->content->sortAuthor($author) . '</font>';
                $description .= '<font style="font-style:italic;color:#666;"> ' . ucwords(strtolower($row['city_name'])) . ' : ' . $row['publisher_name'] . ', ' . $row['book_publishing'] . '</font>';


                $xml .= "<row id='" . $row['book_temp_barcodeprint'] . "'>";
                $xml .= "<cell><![CDATA[" . $row['book_temp_barcodeprint'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_register_id'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $description . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $resource . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $fund . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['book_condition'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $row['total_borrowed'] . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $last_borrowed . "]]></cell>";
                $xml .= "<cell><![CDATA[" . date('d.m.Y', strtotime($row['book_entry'])) . "]]></cell>";
                $xml .= "<cell><![CDATA[" . $count_barcode_print . "]]></cell>";
                $xml .= "</row>";
            }

            $xml .= "</rows>";
            echo $xml;
        }
    }

    public function deletePrintListBarcodeAll() {
        $res = false;
        if ($this->model->deletePrintListBarcodeAll())
            $res = true;
        echo json_encode($res);
    }

    public function printBarcode() {

        $data = $this->model->selectPrintBarcodeList();

        if (count($data) > 0) {


            $pdf = Src::plugin()->tcPdf();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Cetak Barcode Buku Induk');
            $pdf->SetSubject('Koleksi Buku');

            // set default header data
            $pdf->SetHeaderData('', '', 'Print Barcode');

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(11, PDF_MARGIN_TOP, 11);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // ---------------------------------------------------------
            // set a barcode on the page footer
            $pdf->setBarcode(date('Y-m-d H:i:s'));

            // set font
            $pdf->SetFont('helvetica', '', 11);

            // add a page
            $pdf->AddPage();

            // -----------------------------------------------------------------------------

            $pdf->SetFont('helvetica', '', 10);

            // define barcode style
            $style = array(
                'position' => '',
                'align' => 'C',
                'stretch' => false,
                'fitwidth' => true,
                'cellfitalign' => '',
                'border' => true,
                'hpadding' => 'auto',
                'vpadding' => 'auto',
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false, //array(255,255,255),
                'text' => true,
                'font' => 'helvetica',
                'fontsize' => 8,
                'stretchtext' => 4
            );

            // CODE 128 C
            $posX = 11;
            $posY = 20;
            $row = 1;
            $col = 1;
            
            $temp_id = '0';

            foreach ($data as $value) {
                $temp_id .= ',' . $value['book_temp_barcodeprint_register'];
                $pdf->write1DBarcode($value['book_temp_barcodeprint_register'], 'C128C', $posX, $posY, 44, 18, 0.4, $style, '');

                $posX += 48;

                if ($col == 4) {
                    $col = 1;
                    $posX = 11;
                    $posY += 22;
                    $row++;
                } else {
                    $col++;
                }

                if ($row > 12) {
                    $pdf->AddPage();
                    $posX = 11;
                    $posY = 20;
                    $row = 1;
                    $col = 1;
                }
            }
            
            $this->model->updateCountBarcodePrint($temp_id);
            
            //Close and output PDF document
            $pdf->Output('Barcode_' . date('dmYHis') . '.pdf', 'I');
        } else {
            echo 'Maaf Daftar Print Tidak Ditemukan!';
        }
    }

}