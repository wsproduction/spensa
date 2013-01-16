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
        $this->view->link_p = $this->content->setLink('collection/addprint');
        $this->view->link_pl = $this->content->setLink('collection/printlist');
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
                
                $resource= '-';
                if (!empty($row['resource'])) {
                    $resource = $row['resource'];
                }
                
                $fund = '-';
                if (!empty($row['fund'])) {
                    $fund = $row['fund'];
                }
                
                $description  = '<b>' . $row['ddc_classification_number'] . $callnumber_extention . '</b>';
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
                $xml .= "<cell><![CDATA[<a href=''>Edit</a>]]></cell>";
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

    public function printBarcode() {
        $pdf = Src::plugin()->tcPdf();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Warman Suganda');
        $pdf->SetTitle('Cetak Barcode Buku Induk');
        $pdf->SetSubject('Koleksi Buku');

        // set default header data
        $pdf->SetHeaderData('', '', '[ 120908001 ] ' . 'Sistem Infomasi Perpustakaan', 'Call Number : 900.1-WAR-s | Jumlah Barcode : 53');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

        for ($idx = 1; $idx <= 53; $idx++) {


            $id = '120908001001';
            $pdf->write1DBarcode($id, 'C128C', $posX, $posY, 44, 18, 0.4, $style, '');

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

        /*
          $pdf->write1DBarcode('120908001002', 'C128C', 58, 20, 44, 18, 0.4, $style, '');
          $pdf->write1DBarcode('120908001003', 'C128C', 106, 20, 44, 18, 0.4, $style, '');
          $pdf->write1DBarcode('120908001004', 'C128C', 154, 20, 44, 18, 0.4, $style, '');

          // Baris 2
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 42, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 42, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 42, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 42, '', 18, 0.4, $style, '');

          // Baris 3
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 64, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 64, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 64, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 64, '', 18, 0.4, $style, '');

          // Baris 4
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 86, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 86, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 86, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 86, '', 18, 0.4, $style, '');

          // Baris 5
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 108, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 108, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 108, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 108, '', 18, 0.4, $style, '');

          // Baris 6
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 130, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 130, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 130, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 130, '', 18, 0.4, $style, '');

          // Baris 7
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 152, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 152, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 152, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 152, '', 18, 0.4, $style, '');

          // Baris 8
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 174, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 174, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 174, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 174, '', 18, 0.4, $style, '');

          // Baris 9
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 196, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 196, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 196, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 196, '', 18, 0.4, $style, '');

          // Baris 10
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 218, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 218, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 218, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 218, '', 18, 0.4, $style, '');

          // Baris 11
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 240, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 240, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 240, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 240, '', 18, 0.4, $style, '');

          // Baris 12
          $pdf->write1DBarcode('0123456789', 'C128C', 10, 262, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 58, 262, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 106, 262, '', 18, 0.4, $style, '');
          $pdf->write1DBarcode('0987654321', 'C128C', 154, 262, '', 18, 0.4, $style, '');
         */


        // ---------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('example_027.pdf', 'I');
    }

}