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
            $this->view->link_score_export = $this->content->setLink('classgroup/exportscore/' . $teachingid);
            $this->view->link_score_save = $this->content->setLink('classgroup/savescore/' . $teachingid . '.' . $class_info['classgroup_id']);
            $this->view->link_score_read = $this->content->setLink('classgroup/readscore/' . $teachingid . '.' . $class_info['classgroup_id']);

            $this->view->render('classgroup/room');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function readScore($tempid = 0) {

        list ($teachingid, $class_group_id) = explode('.', $tempid);
        $mlc = $this->method->post('mlc');
        $type = $this->method->post('type');

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $student_id_list = $this->parsingStudentId($student_list);
        $score_list = $this->model->selectSocoreByScoreFilter($student_id_list, $teachingid, $type);
        $score_data = $this->parsingScore($score_list);

        $html_list = '';
        $no = 1;
        foreach ($student_list as $row) {

            $score = '';
            if (isset($score_data[$row['student_nis']])) {
                $data = $score_data[$row['student_nis']];
                $score = $data['value'];
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

    public function saveScore($tempid = 0) {

        list ($teachingid, $class_group_id) = explode('.', $tempid);

        if (isset($_POST['data'])) {
            $data = $_POST['data'];

            $type = $this->method->post('type');

            try {
                unset($data[0]);

                $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
                $student_id_list = $this->parsingStudentId($student_list);
                $score_list = $this->model->selectSocoreByScoreFilter($student_id_list, $teachingid, $type);
                $score_data = $this->parsingScore($score_list);

                foreach ($data as $row) {
                    if (isset($score_data[$row[0]])) {
                        $data = $score_data[$row[0]];
                        $this->model->updateScore($data['score_id'], $row[1]);
                    } else {
                        $this->model->saveScore($row[0], $row[1], $teachingid, $type);
                    }
                }
                echo json_encode(true);
            } catch (Exception $exc) {
                echo json_encode(false);
            }
        }
    }

    public function exportScore($id) {

        Session::init();
        $user_references = Session::get('user_references');
        list($teachingid, $type_id) = explode('.', $id);

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);

        if ($class_list) {
            $class_info = $class_list[0];

            $title = '???';
            $filename = 'ERROR';
            if ($type_id == 1) {
                $title = 'DAFTAR NILAI RAPOR TENGAH SEMESTER SISWA';
                $filename = 'NILAI_RAPOR_TENGAH_SEMESTER';
            } else if ($type_id == 2) {
                $title = 'DAFTAR NILAI RAPOR AKHIR SEMESTER SISWA';
                $filename = 'NILAI_RAPOR_AKHIR_SEMESTER';
            }

            Src::plugin()->PHPExcel('IOFactory', 'chunkReadFilter');
            $objPHPExcel = new PHPExcel();
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
            $objPHPExcel->getActiveSheet()->setCellValue('A1', $type_id);
            $objPHPExcel->getActiveSheet()->setCellValue('B1', $title);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SMP NEGERI 1 SUBANG');
            $objPHPExcel->getActiveSheet()->mergeCells('B2:G2');
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->applyFromArray(array('font' => array('bold' => true)));

            // Document Description
            $objPHPExcel->getActiveSheet()->setCellValue('A4', $class_info['classgroup_id'])->setCellValue('B4', 'Kelas')->setCellValue('D4', ': ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('A5', $class_info['period_id'] . '_' . $class_info['semester_id'])->setCellValue('B5', 'Tahun Akademik')->setCellValue('D5', ': ' . $class_info['period_years_start'] . '/' . $class_info['period_years_end'] . ' - ' . $class_info['semester_name']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A6', $teachingid, PHPExcel_Cell_DataType::TYPE_STRING)->setCellValue('B6', 'Mata Pelajaran')->setCellValue('D6', ': ' . $class_info['subject_name']);
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
            $student_id_list = $this->parsingStudentId($student_list);
            $score_list = $this->model->selectSocoreByScoreFilter($student_id_list, $teachingid, $type_id);
            $score_data = $this->parsingScore($score_list);

            $nourut = 0;
            $rowno = 12;
            foreach ($student_list as $row) {
                $nourut++;
                $rowno++;

                $cell_value = 'F' . $rowno;

                $score = '';
                if (isset($score_data[$row['student_nis']])) {
                    $data = $score_data[$row['student_nis']];
                    $score = $data['value'];
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
            header('Content-Disposition: attachment;filename="' . $filename . '-' . $class_info['period_years_start'] . $class_info['period_years_end'] . $class_info['semester_id'] . '-' . $class_info['grade_title'] . $class_info['classroom_name'] . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function importScore($type_reseource = 0) {

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

                $type_id = $objPHPExcel->getActiveSheet()->getCell('A1')->getValue();

                if ($type_reseource == $type_id) {
                    try {
                        $classgroup_id = $objPHPExcel->getActiveSheet()->getCell('A4')->getValue();
                        $teaching_id = $objPHPExcel->getActiveSheet()->getCell('A6')->getValue();

                        $student_list = $this->model->selectStudentByClassGroupId($classgroup_id);
                        $student_id_list = $this->parsingStudentId($student_list);
                        $score_list = $this->model->selectSocoreByScoreFilter($student_id_list, $teaching_id, $type_id);
                        $score_data = $this->parsingScore($score_list);

                        $count_student = $objPHPExcel->getActiveSheet()->getCell('A12')->getValue();
                        $numrow = 13;
                        for ($i = 1; $i <= $count_student; $i++) {
                            $nis = $objPHPExcel->getActiveSheet()->getCell('C' . $numrow)->getValue();
                            $score = $objPHPExcel->getActiveSheet()->getCell('F' . $numrow)->getValue();

                            if (isset($score_data[$nis])) {
                                $data = $score_data[$nis];
                                $this->model->updateScore($data['score_id'], $score);
                            } else {
                                $this->model->saveScore($nis, $score, $teaching_id, $type_id);
                            }

                            $numrow++;
                        }

                        echo 'true';
                    } catch (Exception $exc) {
                        echo 'false';
                    }
                } else {
                    echo 'error';
                }
            } else {
                echo 'false';
            }
            $upload->RemoveFile($inputFileName);
        } else {
            echo 'false';
        }
    }

    private function parsingStudentId($student_list = array()) {
        $student_id = '0';
        foreach ($student_list as $row) {
            $student_id .= ',' . $row['student_nis'];
        }
        return $student_id;
    }

    private function parsingScore($score_list = array()) {
        $score = array();
        foreach ($score_list as $row) {
            $score[$row['score_student']] = array(
                'score_id' => $row['score_id'],
                'value' => $row['score_value']
            );
        }
        return $score;
    }

}