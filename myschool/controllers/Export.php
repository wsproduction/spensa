<?php

class Export extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->content->protection(true);
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('home/index');
    }

    public function account() {
        Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // Defult Border
        $defaultBorder = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        );

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'DAFTAR ACCOUNT MESHPLACE');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NOMOR');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'NAMA');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'PASSWORD');

        $list_account = $this->model->selectAllAccount();
        $no = 1;
        $row = 3;
        foreach ($list_account as $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['user_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, 'default');
            $no++;
            $row++;
        }
        /* 
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . time() . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
        * 
         */
    }

}