<?php

class Data extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();

        Src::plugin()->jQueryForm();
        Src::plugin()->flexiGrid();
    }

    public function index() {
        Web::setTitle('Hots Data');
        $this->view->listSubject = $this->listSubject();
        $this->view->link = $this->content->setLink('data/rquestion');
        $this->view->render('data/index');
    }    

    public function detail($questionId = 0) {
        Web::setTitle('Detail Data');
        $this->view->tempId = $questionId;
        $this->view->link = $this->content->setLink('data/ranswer');
        $this->view->listSubject = $this->listSubject();
        $this->view->render('data/detail');
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
        $listData = $this->model->selecQuestion($page);
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
            $xml .= "<cell><![CDATA[" . utf8_encode($row['question_status']) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode(date('d.m.Y', strtotime($row['question_entry']))) . "]]></cell>";
            $xml .= "<cell><![CDATA[" . utf8_encode($link_detail . ' | ' . $link_edit) . "]]></cell>";
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

}