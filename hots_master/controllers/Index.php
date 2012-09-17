<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();
    }

    public function index() {
        Web::setTitle('Welcome');

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
        foreach ($sheetData as $key=>$row) {
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
            $html .= '<td>' . $row['C']. '</td>';
            

            $html .= '</tr>';
            $this->model->saveStudent($row['A'], $row['B'], $row['C'], 1);
        }
        $html .= '</table>';
        //$this->model->saveStudent('555555555', '1', 'Warsu', '1');

        $this->view->listData = $html;
        $this->view->render('index/index');
    }

    public function cobabaca() {
        $file_handle = fopen("myfile", "r");
        while (!feof($file_handle)) {
            echo fgetss($file_handle);
        }
        fclose($file_handle);
    }

}