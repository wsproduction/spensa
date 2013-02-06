<?php

class Classgroup extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function room($teachingid = 0) {

        Session::init();
        $user_references = Session::get('user_references');

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;

            Web::setTitle('Kelas ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->link_back = $this->content->setParentLink('myclass/view/' . $class_info['subject_id'] . '.' . $class_info['grade_id'] . '.' . $class_info['period_id'] . '.' . $class_info['semester_id']);

            // Mid Score
            $this->view->link_export_midscore = $this->content->setLink('classgroup/exportmidscore/' . $teachingid);
            $this->view->link_save_mid_score = $this->content->setLink('classgroup/savemidscore');
            $this->view->link_read_mid_score = $this->content->setLink('classgroup/readmidscore/' . $class_info['classgroup_id']);

            // Final Score
            $this->view->link_export_finalscore = $this->content->setLink('classgroup/exportfinalscore/' . $teachingid);
            $this->view->link_save_final_score = $this->content->setLink('classgroup/savefinalscore');
            $this->view->link_read_final_score = $this->content->setLink('classgroup/readfinalscore/' . $class_info['classgroup_id']);

            $this->view->render('classgroup/room');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function readMidScore($class_group_id) {

        $subject = $this->method->post('subject');
        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $mlc = $this->method->post('mlc');

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $html_list = '';
        $no = 1;
        foreach ($student_list as $row) {

            $score_list = $this->model->selectMidSocoreByScoreFilter($row['student_nis'], $subject, $period, $semester);
            $score = '';
            if ($score_list) {
                $data = $score_list[0];
                $score = $data['score_mid_value'];
            }

            $desc = '-';
            if ($score != '') {
                if ($score > $mlc)
                    $desc = 'Terlampaui';
                else if ($score == $mlc)
                    $desc = 'Tercapai';
                else
                    $desc = 'Tidak Tercapai';
            }

            Form::create('text', 'score_list_' . $no);
            Form::maxlength(3);
            Form::size(5);
            Form::value($score);
            Form::properties(array('order' => $row['student_nis']));
            Form::style('score_list');
            $score_input = Form::commit('attach');

            $html_list .= '<tr>';
            $html_list .= '     <td align="center" class="first">' . $no . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nis'] . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nisn'] . '</td>';
            $html_list .= '     <td>' . $row['student_name'] . '</td>';
            $html_list .= '     <td align="center">' . $score_input . '</td>';
            $html_list .= '     <td align="center" class="desc_' . $row['student_nis'] . '">' . $desc . '</td>';
            $html_list .= '</tr>';
            $no++;
        }
        echo json_encode(array('count' => $no - 1, 'row' => $html_list));
    }

    public function readFinalScore($class_group_id) {

        $subject = $this->method->post('subject');
        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $mlc = $this->method->post('mlc');

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $html_list = '';
        $no = 1;
        foreach ($student_list as $row) {

            $score_list = $this->model->selectFinalSocoreByScoreFilter($row['student_nis'], $subject, $period, $semester);
            $score = '';
            if ($score_list) {
                $data = $score_list[0];
                $score = $data['score_final_value'];
            }

            $desc = '-';
            if ($score != '') {
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

    public function saveMidScore() {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];

            $subject_id = $this->method->post('subject');
            $period_id = $this->method->post('period');
            $semester_id = $this->method->post('semester');

            try {
                unset($data[0]);
                foreach ($data as $row) {
                    $score_list = $this->model->selectMidSocoreByScoreFilter($row[0], $subject_id, $period_id, $semester_id);
                    if ($score_list) {
                        $data = $score_list[0];
                        $this->model->updateMidScore($data['score_mid_id'], $row[1]);
                    } else {
                        $this->model->saveMidScore($row[0], $row[1], $subject_id, $period_id, $semester_id);
                    }
                }
                echo json_encode(true);
            } catch (Exception $exc) {
                echo json_encode(false);
            }
        }
    }

    public function exportMidScore($id) {

        Session::init();
        $user_references = Session::get('user_references');
        list($teachingid, $semester_id) = explode('_', $id);

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);

        if ($class_list) {
            $class_info = $class_list[0];

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
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'DAFTAR NILAI RAPOR TENGAH SEMESTER SISWA');
            $objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SMP NEGERI 1 SUBANG');
            $objPHPExcel->getActiveSheet()->mergeCells('B2:G2');
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->applyFromArray(array('font' => array('bold' => true)));

            // Document Description
            $objPHPExcel->getActiveSheet()->setCellValue('A4', $class_info['classgroup_id'])->setCellValue('B4', 'Kelas')->setCellValue('D4', ': ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', $class_info['period_id'] . '_' . $class_info['semester_id'])->setCellValue('B5', 'Tahun Akademik')->setCellValue('D5', ': ' . $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - ' . $class_info['semester_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A6', $class_info['subject_id'])->setCellValue('B6', 'Mata Pelajaran')->setCellValue('D6', ': ' . $class_info['subject_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A7', $class_info['mlc_value'])->setCellValue('B7', 'KKM')->setCellValue('D7', ': ' . $class_info['mlc_value']);

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
                $score_list = $this->model->selectMidSocoreByScoreFilter($row['student_nis'], $class_info['subject_id'], $class_info['period_id'], $semester_id);
                $score = '';
                if ($score_list) {
                    $data = $score_list[0];
                    $score = $data['score_mid_value'];
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
            header('Content-Disposition: attachment;filename="NILAI_RAPOR_TENGAH_SEMESTER-' . $class_info['period_years_start'] . $class_info['period_years_end'] . $class_info['semester_id'] . '-' . $class_info['grade_title'] . $class_info['classroom_name'] . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function importMidScore() {

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

                $subject_id = $objPHPExcel->getActiveSheet()->getCell('A6')->getValue();
                list($period_id, $semester_id) = explode('_', $objPHPExcel->getActiveSheet()->getCell('A5')->getValue());
                //$task_description = $objPHPExcel->getActiveSheet()->getCell('A8')->getValue();

                $count_student = $objPHPExcel->getActiveSheet()->getCell('A12')->getValue();
                $numrow = 13;
                for ($i = 1; $i <= $count_student; $i++) {
                    $nis = $objPHPExcel->getActiveSheet()->getCell('C' . $numrow)->getValue();
                    $score = $objPHPExcel->getActiveSheet()->getCell('F' . $numrow)->getValue();
                    //echo '<br>' . $i . '. ' . $nis . ' => ' . $score;

                    $score_list = $this->model->selectMidSocoreByScoreFilter($nis, $subject_id, $period_id, $semester_id);
                    if ($score_list) {
                        $data = $score_list[0];
                        $this->model->updateMidScore($data['score_mid_id'], $score);
                    } else {
                        $this->model->saveMidScore($nis, $score, $subject_id, $period_id, $semester_id);
                    }

                    $numrow++;
                }

                $upload->RemoveFile($inputFileName);
            }
        } else {
            echo 'error';
        }
    }

    public function saveFinalScore() {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];

            $subject_id = $this->method->post('subject');
            $period_id = $this->method->post('period');
            $semester_id = $this->method->post('semester');
            $score_type = $this->method->post('score_type');

            try {
                unset($data[0]);
                foreach ($data as $row) {
                    $score_list = $this->model->selectFinalSocoreByScoreFilter($row[0], $subject_id, $period_id, $semester_id, $score_type);
                    if ($score_list) {
                        $data = $score_list[0];
                        $this->model->updateFinalScore($data['score_final_id'], $row[1]);
                    } else {
                        $this->model->saveFinalScore($row[0], $row[1], $subject_id, $period_id, $semester_id, $score_type);
                    }
                }
                $res = true;
            } catch (Exception $exc) {
                $res = false;
            }
            echo json_encode($res);
        }
    }
    
    public function exportFinalScore($id) {

        Session::init();
        $user_references = Session::get('user_references');
        list($teachingid, $semester_id) = explode('_', $id);

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);

        if ($class_list) {
            $class_info = $class_list[0];

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
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'DAFTAR NILAI UTS SISWA');
            $objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SMP NEGERI 1 SUBANG');
            $objPHPExcel->getActiveSheet()->mergeCells('B2:G2');
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->applyFromArray(array('font' => array('bold' => true)));

            // Document Description
            $objPHPExcel->getActiveSheet()->setCellValue('A4', $class_info['classgroup_id'])->setCellValue('B4', 'Kelas')->setCellValue('D4', ': ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', $class_info['period_id'] . '_' . $class_info['semester_id'])->setCellValue('B5', 'Tahun Akademik')->setCellValue('D5', ': ' . $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - ' . $class_info['semester_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A6', $class_info['subject_id'])->setCellValue('B6', 'Mata Pelajaran')->setCellValue('D6', ': ' . $class_info['subject_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A7', $class_info['mlc_value'])->setCellValue('B7', 'KKM')->setCellValue('D7', ': ' . $class_info['mlc_value']);

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
                $score_list = $this->model->selectFinalSocoreByScoreFilter($row['student_nis'], $class_info['subject_id'], $class_info['period_id'], $semester_id);
                $score = '';
                if ($score_list) {
                    $data = $score_list[0];
                    $score = $data['score_final_value'];
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
            header('Content-Disposition: attachment;filename="NILAI_RAPOR_AKHIR_SEMESTER-' . $class_info['period_years_start'] . $class_info['period_years_end'] . $class_info['semester_id'] . '-' . $class_info['grade_title'] . $class_info['classroom_name'] . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function importFinalScore() {

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

                $subject_id = $objPHPExcel->getActiveSheet()->getCell('A6')->getValue();
                list($period_id, $semester_id) = explode('_', $objPHPExcel->getActiveSheet()->getCell('A5')->getValue());

                $count_student = $objPHPExcel->getActiveSheet()->getCell('A12')->getValue();
                $numrow = 13;
                for ($i = 1; $i <= $count_student; $i++) {
                    $nis = $objPHPExcel->getActiveSheet()->getCell('C' . $numrow)->getValue();
                    $score = $objPHPExcel->getActiveSheet()->getCell('F' . $numrow)->getValue();
                    //echo '<br>' . $i . '. ' . $nis . ' => ' . $score;

                    $score_list = $this->model->selectFinalSocoreByScoreFilter($nis, $subject_id, $period_id, $semester_id);

                    if ($score_list) {
                        $data = $score_list[0];
                        $this->model->updateFinalScore($data['score_final_id'], $score);
                    } else {
                        $this->model->saveFinalScore($nis, $score, $subject_id, $period_id, $semester_id);
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