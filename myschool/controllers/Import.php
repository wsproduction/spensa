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

    public function teaching() {
        $inputFileName = Web::path() . 'asset/upload/ptk/jadwalmengajar.xls';
        if (file_exists($inputFileName)) {
            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($inputFileName);

            try {
                $data = array();
                $html = '
                    <table border="1">
                        <tr>
                            <td>ID</td>
                            <td>NAMA</td>
                            <td>MAPEL</td>
                            <td>KELAS</td>
                            <td>PERIOD</td>
                            <td>SEMESTER</td>
                            <td>JAM</td>
                        </tr>
                    ';
                $count_student = 6;
                $numrow = 361;
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $id = $sheet->getCell('A' . $numrow)->getValue();
                    $nama = $sheet->getCell('B' . $numrow)->getValue();
                    $mapel = $sheet->getCell('C' . $numrow)->getValue();
                    $kelas = $sheet->getCell('D' . $numrow)->getValue();
                    $period = $sheet->getCell('E' . $numrow)->getValue();
                    $semester = $sheet->getCell('F' . $numrow)->getValue();
                    $jam = $sheet->getCell('G' . $numrow)->getValue();

                    $html .= '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $nama . '</td>
                            <td>' . $mapel . '</td>
                            <td>' . $kelas . '</td>
                            <td>' . $period . '</td>
                            <td>' . $semester . '</td>
                            <td>' . $jam . '</td>
                        </tr>
                    ';

                    $data['id'] = $id;
                    $data['mapel'] = $mapel;
                    $data['kelas'] = $kelas;
                    $data['period'] = $period;
                    $data['semester'] = $semester;
                    $data['jam'] = $jam;

                    $this->model->saveTeaching($data);

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

    public function mlc() {
        $inputFileName = Web::path() . 'asset/upload/ptk/kkm.xls';
        if (file_exists($inputFileName)) {
            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($inputFileName);

            try {
                $data = array();
                $html = '
                    <table border="1">
                        <tr>
                            <td>ID</td>
                            <td>MAPEL</td>
                            <td>VII</td>
                            <td>VIII</td>
                            <td>IX</td>
                            <td>PERIOD</td>
                            <td>SEMESTER</td>
                        </tr>
                    ';
                $count_student = 23;
                $numrow = 4;
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $id = $sheet->getCell('A' . $numrow)->getValue();
                    $mapel = $sheet->getCell('B' . $numrow)->getValue();
                    $kelas7 = $sheet->getCell('C' . $numrow)->getValue();
                    $kelas8 = $sheet->getCell('D' . $numrow)->getValue();
                    $kelas9 = $sheet->getCell('E' . $numrow)->getValue();
                    $period = $sheet->getCell('F' . $numrow)->getValue();
                    $semester = $sheet->getCell('G' . $numrow)->getValue();

                    $html .= '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $mapel . '</td>
                            <td>' . $kelas7 . '</td>
                            <td>' . $kelas8 . '</td>
                            <td>' . $kelas9 . '</td>
                            <td>' . $period . '</td>
                            <td>' . $semester . '</td>
                        </tr>
                    ';

                    $data['subject'] = $id;
                    $data['mapel'] = $mapel;
                    $data['period'] = $period;
                    $data['semester'] = $semester;

                    if ($kelas7) {
                        $data['value'] = $kelas7;
                        $data['grade'] = 1;
                        $this->model->saveMlc($data);
                    }

                    if ($kelas8) {
                        $data['value'] = $kelas8;
                        $data['grade'] = 2;
                        $this->model->saveMlc($data);
                    }

                    if ($kelas9) {
                        $data['value'] = $kelas9;
                        $data['grade'] = 3;
                        $this->model->saveMlc($data);
                    }

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

    public function guidance() {
        $inputFileName = Web::path() . 'asset/upload/ptk/bk.xls';
        if (file_exists($inputFileName)) {
            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($inputFileName);

            try {
                $data = array();
                $html = '
                    <table border="1">
                        <tr>
                            <td>ID</td>
                            <td>NAMA</td>
                            <td>KELAS</td>
                            <td>PERIOD</td>
                            <td>SEMESTER</td>
                        </tr>
                    ';
                $count_student = 1;
                $numrow = 26;
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $id = $sheet->getCell('A' . $numrow)->getValue();
                    $nama = $sheet->getCell('B' . $numrow)->getValue();
                    $kelas = $sheet->getCell('C' . $numrow)->getValue();
                    $period= $sheet->getCell('D' . $numrow)->getValue();
                    $semester = $sheet->getCell('E' . $numrow)->getValue();

                    $html .= '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $nama . '</td>
                            <td>' . $kelas . '</td>
                            <td>' . $period . '</td>
                            <td>' . $semester . '</td>
                        </tr>
                    ';

                    $data['teacher'] = $id;
                    $data['classgroup'] = $kelas;
                    $data['period'] = $period;
                    $data['semester'] = $semester;

                    $this->model->saveGuidance($data);

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

    public function pembinaeskul() {
        $inputFileName = Web::path() . 'asset/upload/ptk/pembina_eskul.xls';
        if (file_exists($inputFileName)) {
            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($inputFileName);

            try {
                $data = array();
                $html = '
                    <table border="1">
                        <tr>
                            <td>ID</td>
                            <td>NAMA</td>
                            <td>KELAS</td>
                            <td>PERIOD</td>
                            <td>SEMESTER</td>
                        </tr>
                    ';
                $count_student = 19;
                $numrow = 3;
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $id = $sheet->getCell('A' . $numrow)->getValue();
                    $nama = $sheet->getCell('B' . $numrow)->getValue();
                    $kelas = $sheet->getCell('C' . $numrow)->getValue();
                    $period= $sheet->getCell('D' . $numrow)->getValue();
                    $semester = $sheet->getCell('E' . $numrow)->getValue();

                    $html .= '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $nama . '</td>
                            <td>' . $kelas . '</td>
                            <td>' . $period . '</td>
                            <td>' . $semester . '</td>
                        </tr>
                    ';

                    $data['teacher'] = $id;
                    $data['eskul'] = $kelas;
                    $data['period'] = $period;
                    $data['semester'] = $semester;

                    $this->model->saveGuidanceEskul($data);

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

    public function pbkl() {
        $inputFileName = Web::path() . 'asset/upload/daftar_siswa/pbkl.xls';
        if (file_exists($inputFileName)) {
            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($inputFileName);

            try {
                $data = array();
                $html = '
                    <table border="1">
                        <tr>
                            <td>ID</td>
                            <td>NAMA</td>
                            <td>KELAS</td>
                            <td>PERIOD</td>
                            <td>SEMESTER</td>
                        </tr>
                    ';
                $count_student = 11;
                $numrow = 2;
                
                $objPHPExcel->setActiveSheetIndex(19);
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $id = $sheet->getCell('D' . $numrow)->getValue();
                    $nama = $sheet->getCell('B' . $numrow)->getValue();
                    $kelas = $sheet->getCell('G' . $numrow)->getValue();
                    $period= $sheet->getCell('F' . $numrow)->getValue();
                    $semester = $sheet->getCell('E' . $numrow)->getValue();

                    $html .= '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $nama . '</td>
                            <td>' . $kelas . '</td>
                            <td>' . $period . '</td>
                            <td>' . $semester . '</td>
                        </tr>
                    ';

                    $data['nis'] = $id;
                    $data['class_group'] = $kelas;
                    $data['status'] = 3; // 1 : Siswa Baru, 3 : Naik Kelas

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

    public function pesertaeskul() {
        $inputFileName = Web::path() . 'asset/upload/daftar_siswa/peserta_eskul.xls';
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
                            <td>NAMA</td>
                            <td>ESKUL</td>
                        </tr>
                    ';
                $count_student = 14;
                $numrow = 2;
                
                $objPHPExcel->setActiveSheetIndex(0);
                $sheet = $objPHPExcel->getActiveSheet();
                for ($i = 1; $i <= $count_student; $i++) {

                    $id = $sheet->getCell('A' . $numrow)->getValue();
                    $nama = $sheet->getCell('B' . $numrow)->getValue();
                    $kelas = $sheet->getCell('C' . $numrow)->getValue();
                    

                    $html .= '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $nama . '</td>
                            <td>' . $kelas . '</td>
                        </tr>
                    ';

                    $data['student'] = $id;
                    $data['eskul'] = $kelas;

                    $this->model->saveEskulParticipan($data);

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

}