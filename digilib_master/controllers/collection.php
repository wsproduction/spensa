<?php

class Collection extends Controller {

    public function __construct() {
        parent::__construct();
        $this->content->accessRight();
        $this->view->topMenu = $this->content->topMenu();

        Src::plugin()->jQueryValidation();
        Src::plugin()->jQueryAlphaNumeric();
        Src::plugin()->poshytip();
        Src::plugin()->elrte();
    }

    public function index() {
        Web::setTitle('Daftar Koleksi Buku');
        $this->view->link_add = $this->content->setLink('author/add');
        $this->view->listData = $this->listData();
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

    public function listData($page = 1) {
        $maxRows = 10;
        $countList = $this->model->countAll();
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 9;

        $ddcList = $this->model->selectAll(($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['book_register_id'];
                $id .= ',' . $tmpID;

                $tr_class = 'ganjil';
                if ($idx % 2 == 0) {
                    $tr_class = 'genap';
                }

                $sts = 'Ada';
                if ($value['borrow_status']) {
                    $sts = 'Dipinjam';
                }

                $html .= '<tr class="' . $tr_class . '" id="row_' . $tmpID . '" temp="' . $tr_class . '">';
                $html .= '  <td style="width: 10px;" class="first">';
                Form::create('checkbox', 'list_' . $tmpID);
                Form::style('cbList');
                Form::value($tmpID);
                $html .= Form::commit('attach');
                $html .= '  </td>';
                $html .= '  <td style="text-align: center;">' . $tmpID . '</td>';
                $html .= '  <td></td>';
                $html .= '  <td></td>';
                $html .= '  <td style="text-align: center;">' . $value['book_con'] . '</td>';
                $html .= '  <td style="text-align: center;">' . date('d/m/Y', strtotime($value['entry_date'])) . '</td>';
                $html .= '  <td style="text-align: center;">' . $sts . '</td>';
                $html .= '  <td style="text-align: center;">';
                if ($value['last_borrow'] == NULL)
                    $html .= date('d/m/Y', strtotime($value['last_borrow']));
                $html .= '  </td>';
                $html .= '  <td style="text-align: center;">';
                $html .= URL::link($this->content->setLink('author/edit/' . $tmpID), 'Edit', 'attach') . ' | ';
                $html .= URL::link($this->content->setLink('author/edit/' . $tmpID), 'Detail', 'attach');
                $html .= '  </td>';
                $html .= '</tr>';

                $idx++;
            }

            $html .= $this->content->paging($jumlah_kolom, $countPage, $page);

            Form::create('hidden', 'hiddenID');
            Form::value($id);
            $html .= Form::commit('attach');
        } else {
            $html .= '<tr>';
            $html .= '   <th colspan="' . $jumlah_kolom . '">Data Not Found</th>';
            $html .= '</tr>';
        }
        return $html;
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
        $page = 1;
        if (isset($_GET['p'])) {
            $page = $_GET['p'];
        }
        echo json_encode($this->listData($page));
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
            $pdf->write1DBarcode($id , 'C128C', $posX, $posY, 44, 18, 0.4, $style, '');
            
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