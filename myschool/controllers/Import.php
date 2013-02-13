<?php

class Import extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->content->protection(true);
    }

    public function index() {
        Web::setTitle('Welcome');
        $this->view->render('home/index');
    }

    public function student() {
        $inputFileName = Web::path() . 'asset/upload/daftar_siswa/KELAS9.xls';
        if (file_exists($inputFileName)) {
            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($inputFileName);

            try {
                $data = array();
                $html = '
                    <table border="1">
                        <tr>
                            <td>NIS</td>
                            <td>NISN</td>
                            <td>NAMA</td>
                            <td>JK</td>
                            <td>KELAS</td>
                        </tr>
                    ';
                $count_student = 202;
                $numrow = 7;
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $nis = $sheet->getCell('B' . $numrow)->getValue();
                    $nisn = $sheet->getCell('C' . $numrow)->getValue();
                    $nama = $sheet->getCell('D' . $numrow)->getValue();
                    $jk = $sheet->getCell('E' . $numrow)->getValue();
                    $kelas = $sheet->getCell('F' . $numrow)->getValue();


                    if (strtolower($jk) == 'l') {
                        $jk_id = 1;
                    } else {
                        $jk_id = 2;
                    }

                    $html .= '
                        <tr>
                            <td>' . $nis . '</td>
                            <td>' . $nisn . '</td>
                            <td>' . $nama . '</td>
                            <td>' . $jk_id . ' - ' . $jk . '</td>
                            <td>' . $kelas . '</td>
                        </tr>
                    ';

                    $data['nis'] = $nis;
                    $data['name'] = $nama;
                    $data['gender'] = $jk_id;
                    $data['nisn'] = $nisn;
                    $data['nik'] = ' ';
                    $data['birthplace'] = ' ';
                    $data['birthdate'] = '2013-2-13';
                    $data['religion'] = '-1';
                    $data['religionother'] = '';
                    $data['residance'] = '-1';
                    $data['residanceother'] = '';
                    $data['address'] = ' ';
                    $data['rt'] = '';
                    $data['rw'] = '';
                    $data['village'] = '';
                    $data['subdisctrict'] = '';
                    $data['city'] = 19;
                    $data['zipcode'] = '';
                    $data['distance'] = 1;
                    $data['distanceother'] = '';
                    $data['transportation'] = '-1';
                    $data['phonenumber1'] = '';
                    $data['phonenumber2'] = '';
                    $data['email'] = '';
                    $data['height'] = '';
                    $data['weight'] = '';
                    $data['specialneeds'] = '-1';

                    //$this->model->saveStudent($data);

                    $numrow++;
                }
                $html .= '</table>';

                echo $html;
            } catch (Exception $exc) {
                
            }
        } else {
            echo 'File Tidak ditemukan : ' . $inputFileName;
        }
    }

    public function employee() {
        $inputFileType = 'Excel5';
        $inputFileName = Web::path() . 'asset/upload/file/ptk.xls';

        if (file_exists($inputFileName)) {

            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

            $chunkSize = 649;
            $startRow = 2;

            /**  Create a new Instance of our Read Filter, passing in the limits on which rows we want to read  * */
            $chunkFilter = new chunkReadFilter($startRow, $chunkSize);
            /**  Tell the Reader that we want to use the new Read Filter that we've just Instantiated  * */
            $objReader->setReadFilter($chunkFilter);
            /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  * */
            $objPHPExcel = $objReader->load($inputFileName);

            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            unset($sheetData[1]);

            $data = array();

            $html = '<table border=1>';
            $html .= '<tr>';
            $html .= '<td>NIK</td>';
            $html .= '<td>NIP</td>';
            $html .= '<td>NUPTK</td>';
            $html .= '<td>NAMA</td>';
            $html .= '<td>L/P</td>';
            $html .= '<td>TEMPAT LAHIR</td>';
            $html .= '<td>TANGGAL LAHIR</td>';
            $html .= '<td>AGAMA</td>';
            $html .= '<td>ALAMAT</td>';
            $html .= '<td>RT</td>';
            $html .= '<td>RW</td>';
            $html .= '<td>KELURAHAN</td>';
            $html .= '<td>KECAMATAN</td>';
            $html .= '<td>KAB/KOTA</td>';
            $html .= '<td>KODE POS</td>';
            $html .= '<td>JARAK</td>';
            $html .= '<td>JARAK OTHER</td>';
            $html .= '<td>TRANSPORTASI</td>';
            $html .= '<td>PHONE 1</td>';
            $html .= '<td>PHONE 2</td>';
            $html .= '<td>EMAIL</td>';
            $html .= '<td>KEPEGAWAIAN</td>';
            $html .= '<td>STATUS PERNIKAHAN</td>';
            $html .= '<td>JUMLAH ANAK</td>';
            $html .= '<td>NAMA IBU</td>';
            $html .= '<td>KETERANGAN</td>';
            $html .= '</tr>';
            foreach ($sheetData as $key => $row) {
                $html .= '<tr>';

                $html .= '<td>' . $row['O'] . '</td>';
                $html .= '<td>' . $row['AT'] . '</td>';
                $html .= '<td>' . $row['L'] . '</td>';
                $html .= '<td>' . $row['D'] . '</td>';
                $html .= '<td>' . $row['F'] . '</td>';
                $html .= '<td>' . strtoupper($row['M']) . '</td>';
                $html .= '<td>' . $row['N'] . '</td>';
                $html .= '<td>' . $row['P'] . '</td>';
                $html .= '<td>' . $row['T'] . '</td>';
                $html .= '<td>' . $row['U'] . '</td>';
                $html .= '<td>' . $row['V'] . '</td>';
                $html .= '<td>' . $row['W'] . '</td>';
                $html .= '<td>' . $row['Y'] . '</td>';
                $html .= '<td>' . $row['Z'] . '</td>';
                $html .= '<td>' . $row['X'] . '</td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td>' . $row['AA'] . '</td>';
                $html .= '<td>' . $row['AB'] . '</td>';
                $html .= '<td>' . $row['AC'] . '</td>';
                $html .= '<td>' . $row['AD'] . '</td>';
                $html .= '<td>' . $row['Q'] . '</td>';
                $html .= '<td>' . $row['R'] . '</td>';
                $html .= '<td>' . $row['S'] . '</td>';
                $html .= '<td>' . $row['E'] . '</td>';

                $html .= '</tr>';

                $data['nik'] = $row['O'];
                $data['nip'] = $row['AT'];
                $data['nuptk'] = $row['L'];
                $data['name'] = $row['D'];
                $data['gender'] = $row['F'];
                $data['birthplace'] = strtoupper($row['M']);
                $data['birthdate'] = $row['N'];
                $data['religion'] = $row['P'];
                $data['religionother'] = ''; //$row[''];    
                $data['address'] = $row['T'];
                $data['rt'] = $row['U'];
                $data['rw'] = $row['V'];
                $data['village'] = $row['W'];
                $data['subdisctrict'] = $row['Y'];
                $data['city'] = $row['Z'];
                $data['zipcode'] = $row['X'];
                $data['transportation'] = -1; //$row[''];    
                $data['distance'] = -1; //$row[''];    
                $data['distanceother'] = ''; //$row[''];    
                $data['phone1'] = $row['AA'];
                $data['phone2'] = $row['AB'];
                $data['email'] = $row['AC'];
                $data['photo'] = ''; //$row['AD'];    
                $data['desc'] = $row['AD'];
                $data['marriage_status'] = $row['Q'];
                $data['total_children'] = $row['R'];
                $data['mother_name'] = $row['S'];
                $data['status'] = $row['E'];

                //$this->model->saveEmployees($data);
            }
            $html .= '</table>';
            echo $html;
        }
    }

    public function classHistrory() {
        $inputFileName = Web::path() . 'asset/upload/daftar_siswa/KELAS9.xls';
        if (file_exists($inputFileName)) {
            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($inputFileName);

            try {
                $data = array();
                $html = '
                    <table border="1">
                        <tr>
                            <td>NIS</td>
                            <td>NISN</td>
                            <td>NAMA</td>
                            <td>JK</td>
                            <td>KELAS</td>
                        </tr>
                    ';
                $count_student = 202;
                $numrow = 7;
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $nis = $sheet->getCell('B' . $numrow)->getValue();
                    $nisn = $sheet->getCell('C' . $numrow)->getValue();
                    $nama = $sheet->getCell('D' . $numrow)->getValue();
                    $jk = $sheet->getCell('E' . $numrow)->getValue();
                    $kelas = $sheet->getCell('F' . $numrow)->getValue();


                    if (strtolower($jk) == 'l') {
                        $jk_id = 1;
                    } else {
                        $jk_id = 2;
                    }

                    $html .= '
                        <tr>
                            <td>' . $nis . '</td>
                            <td>' . $nisn . '</td>
                            <td>' . $nama . '</td>
                            <td>' . $jk_id . ' - ' . $jk . '</td>
                            <td>' . $kelas . '</td>
                        </tr>
                    ';

                    $data['nis'] = $nis;
                    $data['class_group'] = $kelas;
                    $data['status'] = 3;

                    $this->model->saveClassGroup($data);

                    $numrow++;
                }
                $html .= '</table>';

                echo $html;
            } catch (Exception $exc) {
                
            }
        } else {
            echo 'File Tidak ditemukan : ' . $inputFileName;
        }
    }

    public function classHistroryUpdate() {
        $list1 = $this->model->selectAllClassHistory();
        $newid = 1212010001;
        foreach ($list1 as $value) {
            $this->model->updateClassHistory($newid, $value['classhistory_id']);
            echo $newid . '<br>';
            $newid++;
        }
    }

    public function exportTest() {
        Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        /*
          // Add some data
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A1', 'NIS')
          ->setCellValue('B1', 'NAMA')
          ->setCellValue('C1', 'Nilai');

          // Miscellaneous glyphs, UTF-8
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A2', '19394040')
          ->setCellValue('B2', 'Warman Suganda');

          // Rename worksheet
          $objPHPExcel->getActiveSheet()->setTitle('Simple');
         */

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Latihan Layouting');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');

        $objPHPExcel->getActiveSheet()->setCellValue('C2', date('Y-m-d'));
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Warman Suganda');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Sebagai mana mestiinya apa yang akan kita lakukan adalah menjadi yang terbaik');

        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(120);
        $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $defaultBorder = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '1006A3')
        );

        $style_header = array(
            'borders' => array(
                'top' => $defaultBorder,
                'bottom' => $defaultBorder,
                'left' => $defaultBorder,
                'right' => $defaultBorder
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E1E0F7')
            ),
            'font' => array(
                'bold' => true
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->setCellValue('E1', 10);
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 20);
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '=SUM(E1:F1)');

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function importTest() {
        $inputFileType = 'Excel5';
        $inputFileName = Web::path() . 'asset/upload/file/mlc.xls';

        if (file_exists($inputFileName)) {

            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

            $chunkSize = 649;
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
            $html .= '<tr>';
            $html .= '<td>ID</td>';
            $html .= '<td>NAMA</td>';
            $html .= '<td>USERNAME</td>';
            $html .= '<td>PASSWORD</td>';
            $html .= '</tr>';
            foreach ($sheetData as $key => $row) {
                $html .= '<tr>';

                $html .= '<td>' . $row['A'] . '</td>';
                $html .= '<td>' . $row['B'] . '</td>';
                $html .= '<td>' . $row['C'] . '</td>';
                $html .= '<td>' . $row['D'] . '</td>';

                $html .= '</tr>';

                $data['subject'] = $row['A'];
                $data['period'] = $row['D'];
                $data['grade'] = $row['E'];
                $data['value'] = $row['C'];
                $this->model->saveMlc($data);
            }
            $html .= '</table>';
            echo $html;
        }
    }

}