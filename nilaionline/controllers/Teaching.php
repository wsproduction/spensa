<?php

class Teaching extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Tugas Mengajar');
        $this->view->option_period = $this->optionPeriod();
        $this->view->link_r_teaching = $this->content->setLink('teaching/readteaching');
        $this->view->render('teaching/index');
    }

    public function myClass($statusid = 0) {

        Session::init();
        $user_references = Session::get('user_references');

        $teachingid = substr($statusid, 1);
        $semesterid = substr($statusid, 0, 1);

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        $semester_list = $this->model->selectSemesterById($semesterid);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;
            $semester_info = $semester_list[0];
            $this->view->semester_info = $semester_info;

            Web::setTitle('Kelas ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->student_list = $this->model->selectStudentByClassGroupId($class_info['classgroup_id']);
            $this->view->option_basecompetance = $this->optionBaseCompetence($class_info['period_id'], $semesterid);
            $this->view->option_scoretype = $this->optionScoreType();
            $this->view->link_export_dailyscore = $this->content->setLink('teaching/exportdailyscore/' . $teachingid);
            $this->view->link_save_daily_score = $this->content->setLink('teaching/savedailyscore');

            $this->view->render('teaching/myclass');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function optionPeriod() {
        $option = array();
        $semester = $this->model->selectAllSemester();
        $period = $this->model->selectAllPeriod();
        foreach ($period as $rowperiod) {
            foreach ($semester as $rowsmester) {
                $option[$rowperiod['period_id'] . '_' . $rowsmester['semester_id']] = $rowperiod['period_years_start'] . ' / ' . $rowperiod['period_years_end'] . ' - ' . $rowsmester['semester_name'];
            }
        }
        return $option;
    }

    public function optionBaseCompetence($period, $semester) {
        $option = array();
        $basecompetence = $this->model->selectBaseCompetence($period, $semester);
        foreach ($basecompetence as $row) {
            $option[$row['base_competence_id']] = $row['base_competence_symbol'] . ' - ' . $row['base_competence_title'];
        }
        return $option;
    }

    public function optionScoreType() {
        $option = array();
        $basecompetence = $this->model->selectScoreType();
        foreach ($basecompetence as $row) {
            $option[$row['score_type_id']] = $row['score_type_symbol'] . ' - ' . $row['score_type_description'];
        }
        return $option;
    }

    public function saveDailyScore() {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];

            $period_id = $this->method->post('period');
            $semester_id = $this->method->post('semester');
            $base_competence = $this->method->post('base_competence');
            $score_type = $this->method->post('score_type');

            foreach ($data as $row) {
                $score_list = $this->model->selectDailySocoreByScoreFilter($row[0], $period_id, $semester_id, $base_competence, $score_type);
                if ($score_list) {
                    $data = $score_list[0];
                    $this->model->updateDailyScore($data['score_daily_id'], $row[1]);
                } else {
                    $this->model->saveDailyScore($row[0], $row[1], $period_id, $semester_id, $base_competence, $score_type);
                }
            }
        }
    }

    public function readDailyScore($class_group_id) {

        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $base_competence = $this->method->post('base_competence');
        $score_type = $this->method->post('score_type');
        $mlc = $this->method->post('mlc');

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $html_list = '';
        $no = 1;
        foreach ($student_list as $row) {

            $score_list = $this->model->selectDailySocoreByScoreFilter($row['student_nis'], $period, $semester, $base_competence, $score_type);
            $score = '';
            if ($score_list) {
                $data = $score_list[0];
                $score = $data['score_daily_value'];
            }

            $desc = '-';
            if (!empty($score)) {
                if ($score > $mlc)
                    $desc = 'Terlampaui';
                else if ($score == $mlc)
                    $desc = 'Tercapai';
                else
                    $desc = 'Tidak Tercapai';
            }

            $html_list .= '<tr>';
            $html_list .= '     <td align="center" class="first">' . $no . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nis'] . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nisn'] . '</td>';
            $html_list .= '     <td>' . $row['student_name'] . '</td>';
            $html_list .= '     <td align="center"><input type="text" class="score_list" id="score_list_' . $no . '" order="' . $row['student_nis'] . '" value="' . $score . '" size="5" maxlength="3" style="text-align:center"></td>';
            $html_list .= '     <td align="center" class="desc_' . $row['student_nis'] . '">' . $desc . '</td>';
            $html_list .= '</tr>';
            $no++;
        }
        echo json_encode(array('count' => $no - 1, 'row' => $html_list));
    }

    public function exportDailyScore($id) {

        Session::init();
        $user_references = Session::get('user_references');
        list($teachingid, $base_competence_id, $score_type_id, $semester_id) = explode('_', $id);

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        $base_competence_list = $this->model->selectBaseCompetenceById($base_competence_id);
        $score_type_list = $this->model->selectScoreTypeById($score_type_id);
        $semester_list = $this->model->selectSemesterById($semester_id);

        if ($class_list) {
            $class_info = $class_list[0];
            $base_competence_info = $base_competence_list[0];
            $score_type_info = $score_type_list[0];
            $semester_info = $semester_list[0];

            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

            // Set Active Sheet 1
            $objPHPExcel->setActiveSheetIndex(0);

            // Defult Border
            $defaultBorder = array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            );

            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
            $objPHPExcel->getDefaultStyle()->getFont()->setSize(9);
            $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setPassword('subangmaju');

            /* BEGIN : Layouting */
            // Header
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0);
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'DAFTAR NILAI HARIAN SISWA');
            $objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SMP NEGERI 1 SUBANG');
            $objPHPExcel->getActiveSheet()->mergeCells('B2:G2');
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->applyFromArray(array('font' => array('bold' => true)));

            // Document Description
            $objPHPExcel->getActiveSheet()->setCellValue('A4', $class_info['classgroup_id'])->setCellValue('B4', 'Kelas')->setCellValue('D4', ': ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', $class_info['period_id'] . '_' . $semester_info['semester_id'])->setCellValue('B5', 'Tahun Akademik')->setCellValue('D5', ': ' . $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - ' . $semester_info['semester_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A6', $class_info['subject_id'])->setCellValue('B6', 'Mata Pelajaran')->setCellValue('D6', ': ' . $class_info['subject_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A7', $class_info['mlc_value'])->setCellValue('B7', 'KKM')->setCellValue('D7', ': ' . $class_info['mlc_value']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A8', $base_competence_id, PHPExcel_Cell_DataType::TYPE_STRING)->setCellValue('B8', 'Kompetensi Dasar')->setCellValue('D8', ': ' . $base_competence_info['base_competence_symbol'] . ' - ' . $base_competence_info['base_competence_title']);
            $objPHPExcel->getActiveSheet()->setCellValue('A9', $score_type_id)->setCellValue('B9', 'Type')->setCellValue('D9', ': ' . $score_type_info['score_type_symbol'] . ' - ' . $score_type_info['score_type_description']);

            $objPHPExcel->getActiveSheet()->getStyle('B4:B9')->applyFromArray(array('font' => array('bold' => true)));

            // HEADER LIST DATA
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5.43);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10.71);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13.43);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(43.43);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7.14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13.71);
            $objPHPExcel->getActiveSheet()->getStyle('B11:G12')->applyFromArray(array('font' => array('bold' => true)));
            $objPHPExcel->getActiveSheet()->getStyle('B11:G12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B11:G12')->applyFromArray(array('borders' => array('inside' => $defaultBorder, 'outline' => $defaultBorder)));

            $objPHPExcel->getActiveSheet()->setCellValue('B11', 'NOMOR');
            $objPHPExcel->getActiveSheet()->mergeCells('B11:D11');
            $objPHPExcel->getActiveSheet()->setCellValue('E11', 'NAMA SISWA');
            $objPHPExcel->getActiveSheet()->mergeCells('E11:E12');
            $objPHPExcel->getActiveSheet()->setCellValue('F11', 'NILAI');
            $objPHPExcel->getActiveSheet()->mergeCells('F11:F12');
            $objPHPExcel->getActiveSheet()->setCellValue('G11', 'KETERANGAN');
            $objPHPExcel->getActiveSheet()->mergeCells('G11:G12');
            $objPHPExcel->getActiveSheet()->setCellValue('B12', 'URUT');
            $objPHPExcel->getActiveSheet()->setCellValue('C12', 'INDUK');
            $objPHPExcel->getActiveSheet()->setCellValue('D12', 'NISN');

            // List Data
            $student_list = $this->model->selectStudentByClassGroupId($class_info['classgroup_id']);
            $nourut = 0;
            $rowno = 12;
            foreach ($student_list as $row) {
                $nourut++;
                $rowno++;

                $cell_value = 'F' . $rowno;

                $score_list = $this->model->selectDailySocoreByScoreFilter($row['student_nis'], $class_info['period_id'], $semester_id, $base_competence_id, $score_type_id);
                $score = '';
                if ($score_list) {
                    $data = $score_list[0];
                    $score = $data['score_daily_value'];
                }

                $objPHPExcel->getActiveSheet()->getStyle('D' . $rowno)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowno, $nourut)
                        ->setCellValueExplicit('C' . $rowno, $row['student_nis'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D' . $rowno, $row['student_nisn'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue('E' . $rowno, $row['student_name'])
                        ->setCellValue('F' . $rowno, $score)
                        ->setCellValue('G' . $rowno, '=IF(ISBLANK(' . $cell_value . '),"-",IF(' . $cell_value . '>A$7,"Terlampaui", IF(' . $cell_value . '=A$7,"Tercapai","Tidak Tercapai")))');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('A12', $nourut);
            $objPHPExcel->getActiveSheet()->getStyle('B12' . ':G' . $rowno)->applyFromArray(array('borders' => array('inside' => $defaultBorder, 'outline' => $defaultBorder)));
            $objPHPExcel->getActiveSheet()->getStyle('B12:D' . $rowno)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F12:G' . $rowno)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F12:F' . $rowno)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="01simple.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function readteaching() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $periodid = $this->method->post('p');
        $semesterid = $this->method->post('s');

        $teaching_list = '';
        $idx = 1;

        foreach ($this->model->selectTeaching($teacher_id, $periodid) as $row) {
            $teaching_list .= '<tr>';
            $teaching_list .= '
                    <td valign="top" class="first" align="center">' . $idx . '</td>
                    <td valign="top">
                        <div class="class-title">' . $row['subject_name'] . '</div>
                        <div class="link">
                            <a href="#">6 Kompetensi Dasar</a> &bullet; <a href="#">7 Tugas</a> &bullet; <a href="teaching/myclass/' . $semesterid . $row['teaching_id'] . '" class="go-to-class">Masuk Kelas</a>
                        </div>
                    </td>';

            $teaching_list .= '
                    <td valign="top">
                        <div class="class-title">' . $row['grade_title'] . ' (' . $row['grade_name'] . ') ' . $row['classroom_name'] . ' </div>
                        <div class="class-description">
                            <b>Jumlah Siswa : </b> 30 (15 Laki-Laki, 15 Perempuan)
                        </div>
                        <div class="class-description">
                            <b>Wali Kelas : </b> ' . $row['employess_name'] . '
                        </div>
                    </td>
                    <td valign="top" align="center">' . $row['teaching_total_time'] . ' Jam</td>
                </tr>';

            $idx++;
        }

        echo json_encode(array('count' => 1, 'row' => $teaching_list));
    }

    public function importDailyScore() {

        if ($this->method->files('file', 'tmp_name')) {
            $upload = Src::plugin()->PHPUploader();
            $upload->SetFileName($this->method->files('file', 'name'));
            $upload->ChangeFileName('import_' . date('Ymd') . time());
            $upload->SetTempName($this->method->files('file', 'tmp_name'));
            $upload->SetUploadDirectory(Web::path() . 'asset/upload/file/');
            if ($upload->UploadFile()) {
                
                $inputFileName = Web::path() . 'asset/upload/file/' . $upload->GetFileName();
                Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
                $objReader = PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load($inputFileName);
                
                //echo '<pre>';
                //echo ' Kelas : ' . $objPHPExcel->getActiveSheet()->getCell('A4')->getValue();
                //echo ' Tahun Akademik : ' . $objPHPExcel->getActiveSheet()->getCell('A5')->getValue();
                //echo ' Mata Pelajaran : ' . $objPHPExcel->getActiveSheet()->getCell('A6')->getValue();
                //echo ' Kompetensi Dasar : ' . $objPHPExcel->getActiveSheet()->getCell('A8')->getValue();
                //echo ' Type : ' . $objPHPExcel->getActiveSheet()->getCell('A9')->getValue();
                //echo ' Jumlah Siswa : ' . $objPHPExcel->getActiveSheet()->getCell('A12')->getValue();
                //echo '</pre>';
                
                list($period_id, $semester_id) = explode('_', $objPHPExcel->getActiveSheet()->getCell('A5')->getValue());
                $base_competence = $objPHPExcel->getActiveSheet()->getCell('A8')->getValue();
                $score_type = $objPHPExcel->getActiveSheet()->getCell('A9')->getValue();

                $count_student = $objPHPExcel->getActiveSheet()->getCell('A12')->getValue();
                $numrow = 13;
                for ($i = 1; $i <= $count_student; $i++) {
                    $nis = $objPHPExcel->getActiveSheet()->getCell('C' . $numrow)->getValue();
                    $score = $objPHPExcel->getActiveSheet()->getCell('F' . $numrow)->getValue();
                    //echo '<br>' . $i . '. ' . $nis . ' => ' . $score;
                    
                    $score_list = $this->model->selectDailySocoreByScoreFilter($nis, $period_id, $semester_id, $base_competence, $score_type);
                    if ($score_list) {
                        $data = $score_list[0];
                        $this->model->updateDailyScore($data['score_daily_id'], $score);
                    } else {
                        $this->model->saveDailyScore($nis, $score, $period_id, $semester_id, $base_competence, $score_type);
                    }
                    
                    $numrow++;
                }
                
                $upload->RemoveFile($inputFileName);
            }
        } else {
            echo 'error';
        }
    }

}