<?php

class Data extends Controller {

    public function __construct() {
        parent::__construct();
        
        Session::init();
        if (!Session::get('loginStatus')) {
            $this->url->redirect('http://' . Web::$host . '/' . Web::$webAlias .'/index');
            exit;
        }
        
        Src::plugin()->jQueryForm();
        Src::plugin()->flexiGrid();
        Src::plugin()->jQueryValidation();
        Src::plugin()->elrte();
    }

    public function index() {
        Web::setTitle('Hots Data');
        $this->view->listSubject = $this->listSubject();
        $this->view->link = $this->content->setLink('data/rquestion');
        $this->view->render('data/index');
    }

    public function detail($questionId = 0) {
        $question = $this->model->selectQuestionById($questionId);
        if (count($question) > 0) {
            Web::setTitle('Detail Data');
            $this->view->tempId = $questionId;
            $this->view->subject = $question[0];
            $this->view->link = $this->content->setLink('data/ranswer');
            $this->view->link_print = $this->content->setLink('data/printanswer/' . $questionId);
            $this->view->listSubject = $this->listSubject();
            $this->view->render('data/detail');
        } else {
            echo 'Page not found';
        }
    }

    public function add() {
        Web::setTitle('Add Data');
        $this->view->listSubject = $this->listSubject();
        $this->view->render('data/add');
    }

    public function edit($id = 0) {
        $this->view->tempId = $id;
        $question = $this->model->selectQuestionById($id);
        if (count($question) > 0) {
            Web::setTitle('Edit Data');
            $this->view->listSubject = $this->listSubject();
            $this->view->listQuestion = $question[0];
            $this->view->render('data/edit');
        }
    }

    public function cobabacaEXcel() {

        $inputFileType = 'Excel5';
        $inputFileName = Web::path() . 'asset/upload/file/KELAS9/9H.xls';

        Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        $chunkSize = 31;
        $startRow = 2;

        /**  Create a new Instance of our Read Filter, passing in the limits on which rows we want to read  * */
        $chunkFilter = new chunkReadFilter($startRow, $chunkSize);
        /**  Tell the Reader that we want to use the new Read Filter that we've just Instantiated  * */
        $objReader->setReadFilter($chunkFilter);
        /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load($inputFileName);

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        unset($sheetData[1]);
        $html = '<table border=1>';
        foreach ($sheetData as $key => $row) {
            $html .= '<tr>';

            $html .= '<td>' . $row['A'] . '</td>';
            $html .= '<td>' . $row['B'] . '</td>';

            /*
              $name = explode(' ', $row['C'] );
              $jmlNama = count($name);

              $namaDepan = '';
              $namaBelakang = '';

              for ($idx = 0; $idx <$jmlNama; $idx++) {
              if ($idx == 0)
              $namaDepan = $name[$idx];
              else {
              $namaBelakang .= ' ' . $name[$idx];
              }
              }
             */
            $html .= '<td>' . $row['C'] . '</td>';


            $html .= '</tr>';
            $this->model->saveStudent($row['A'], $row['B'], $row['C'], 1);
        }
        $html .= '</table>';
    }

    public function listSubject() {
        $listData = $this->model->selectSubject();
        $data = array();
        foreach ($listData as $value) {
            $data[$value['subject_id']] = $value['subject_title'];
        }
        return $data;
    }

    public function rquestion() {

        $page = $this->method->post('page', 1);
        $listData = $this->model->selectQuestion($page);
        $total = $this->model->countQuestion($page);

        header("Content-type: text/xml");
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<rows>";
        $xml .= "<page>$page</page>";
        $xml .= "<total>$total</total>";

        foreach ($listData AS $row) {

            $link_detail = URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/data/detail/' . $row['question_id'], 'Detail', 'attach');
            $link_edit = URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/data/edit/' . $row['question_id'], 'Edit', 'attach');

            $xml .= "<row id='" . $row['question_id'] . "'>";
            $xml .= "<cell><![CDATA[" . $row['question_id'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode(date('d.m.Y', strtotime($row['question_start_date'])) . ' - ' . date('d.m.Y', strtotime($row['question_end_date']))) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($row['question_description']) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode(0) . "]]></cell>";
            $status = 'Disabled';
            if ($row['question_status'])
                $status = 'Enabled';
            $xml .= "<cell><![CDATA[" . utf8_encode($status) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode(date('d.m.Y', strtotime($row['question_entry']))) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($link_detail . ' | ' . $link_edit) . "]]></cell>";
            $xml .= "</row>";
        }

        $xml .= "</rows>";
        echo $xml;
    }

    public function ranswer() {

        $page = $this->method->post('page', 1);
        $listData = $this->model->selectAnswer($page);
        $total = $this->model->countAnswer($page);

        header("Content-type: text/xml");
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<rows>";
        $xml .= "<page>$page</page>";
        $xml .= "<total>$total</total>";

        foreach ($listData AS $row) {

            //$link_view = URL::link('http://' . Web::$host . '/' . Web::$webAlias . '/data/view/' . $row['question_id'], 'View', 'attach');
            //$link = URL::link('#view', 'View', 'attach');
            //if ($row['status'] == 'Submit')
                //$link .= ' | ' . URL::link('#rate', 'Rating', 'attach');
            
            //if ($row['status'] == 'Check')
                $link = URL::link('#winners', 'Set Winner', 'attach', array('rel'=>$this->content->setLink('data/setWinner'),'title'=>$row['answer_id']));

            $xml .= "<row id='" . $row['answer_id'] . "'>";
            $xml .= "<cell><![CDATA[" . $row['answer_id'] . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($row['nis']) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($row['student_name']) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($row['grade']) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode(date('d.m.Y H:i:s', strtotime($row['answer_date']))) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($row['status']) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($row['answer_score']) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($link) . "]]></cell>";
            $xml .= "</row>";
        }

        $xml .= "</rows>";
        echo $xml;
    }

    public function delete() {
        if ($this->model->delete()) {
            $ket = true;
        } else {
            $ket = false;
        }
        echo json_encode($ket);
    }

    public function printAnswer($id) {
        
        $dataQuestion = $this->model->selectQuestionById($id);
        if (count($dataQuestion) > 0) {
            $dataAnswer = $this->model->selectAnswerByQuestionId($id);
            //var_dump($data);

            $pdf = Src::plugin()->tcPdf();
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Warman Suganda');
            $pdf->SetTitle('Print Answer');
            $pdf->SetSubject('Printing');

            // set default header data
            $pdf->SetHeaderData('', '', 'SMP NEGERI 1 SUBANG | HOTS SPENSA ( Heigher Order Thinking Skill )', 'Email : hots@smpn1subang.sch.id - Website : hots.smpn1subang.sch.id');

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            //set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            //set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set default font subsetting mode
$pdf->setFontSubsetting(true);

// set font
$pdf->SetFont('freeserif', '', 12);

            // add a page
            $pdf->AddPage();

            $question = $dataQuestion[0];

            $html = '<table class="list" cellpadding="4" cellspacing="6">';
            $html .= '  <tr>';
            $html .= '      <td style="text-align:center;text-decoration:underline;font-weight:bold;">' . htmlspecialchars(trim(stripslashes($question['subject_title']),'"'), ENT_COMPAT, 'UTF-8') . '</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td style="border-bottom:1px dashed #ccc;"><b>Question:</b> <br>' . $question['question_description'] . '</td>';
            $html .= '  </tr>';
            $html .= '  <tr>';
            $html .= '      <td></td>';
            $html .= '  </tr>';
            foreach ($dataAnswer as $value) {
                $html .= '<tr>';
                $html .= '  <td style="border:1px solid #ccc;">';
                $html .= '      <table width="1000">';
                $html .= '          <tr>';
                $html .= '              <td><b>' . $value['student_register_number'] . ' - ' . $value['student_full_name'] . ' / ' . $value['grade_name'] . $value['class_name'] . '</b><br>' . date('l, d.m.Y H:i:s', strtotime($value['answer_date'])) . '</td>';
                $html .= '              <td width="105"><b>Score :</b> </td>';
                $html .= '          </tr>';
                $html .= '          <tr>';
                $html .= '              <td colspan="2"></td>';
                $html .= '          </tr>';
                $html .= '          <tr>';
                $html .= '              <td colspan="2"><b>Answer :</b><br>' . stripslashes($value['answer_content']) . '</td>';
                $html .= '          </tr>';
                $html .= '          <tr>';
                $link = 'http://' . Web::$host . '/hots/asset/web/upload/file/' . $value['answer_file'];
                if ($value['answer_file'] != '')
                    $html .= '              <td colspan="2"><b>Attachment :</b><br><a href="' . $link . '">' . $link . '</a></td>';
                else
                    $html .= '              <td colspan="2"><b>Attachment :</b><br>-</td>';
                $html .= '          </tr>';
                $html .= '      </table>';
                $html .= '  </td>';
                $html .= '</tr>';
            }
            $html .= '</table>';

            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
            // reset pointer to the last page
            $pdf->lastPage();
            
            //echo '<code>';
            //echo $html;
            //echo '</code>';
            // ---------------------------------------------------------
            //Close and output PDF document
            $pdf->Output('example_061.pdf', 'I');
        }
    }

    public function create() {
        if ($this->model->createSave()) {
            $msg = array(1, 1, $this->message->saveSucces());
        } else {
            $msg = array(0, 0, $this->message->saveError());
        }
        echo json_encode($msg);
    }

    public function update($id = 0) {
        if ($this->model->updateSave($id)) {
            $msg = array(1, 0, $this->message->saveSucces());
        } else {
            $msg = array(0, 0, $this->message->saveError());
        }
        echo json_encode($msg);
    }
    
    public function setWinner() {
        if ($this->model->setWinner()) {
            $res = 1;
        } else {
            $res = 0;
        }
        echo json_encode($res);
    }
}