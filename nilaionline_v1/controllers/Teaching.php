<?php

class Teaching extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Tugas Mengajar');

        Session::init();
        $user_references = Session::get('user_references');
        $teacher_list = $this->model->selectTeacherInformationById($user_references);
        if ($teacher_list) {
            $teacher_info = $teacher_list[0];
            $this->view->teacher_info = $teacher_info;

            $this->view->option_period = $this->optionPeriod();
            $this->view->link_guardian_information = $this->content->setLink('teaching/readguardianinformation/' . $user_references);
            $this->view->link_r_teaching = $this->content->setLink('teaching/readteaching');
            $this->view->link_r_teaching_pbkl = $this->content->setLink('teaching/readteachingpbkl');
            $this->view->link_r_teaching_ekskul = $this->content->setLink('teaching/readteachingekskul');
            $this->view->render('teaching/index');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function myClass($id = 0) {
        Web::setTitle('Daftar Kelas');
        if ($id) {
            list($subject_id, $grade_id, $period_id, $semester_id) = explode('.', $id);

            if (isset($subject_id) && isset($grade_id) && isset($period_id) && isset($semester_id)) {
                $subject_list = $this->model->selectSubjectById($subject_id);
                $subject_info = $subject_list[0];
                $this->view->subject_info = $subject_info;

                $grade_list = $this->model->selectGradeById($grade_id);
                $grade_info = $grade_list[0];
                $this->view->grade_info = $grade_info;

                $period_list = $this->model->selectPeriodById($period_id);
                $period_info = $period_list[0];
                $this->view->period_info = $period_info;

                $semester_list = $this->model->selectSemesterById($semester_id);
                $semester_info = $semester_list[0];
                $this->view->semester_info = $semester_info;

                $this->view->link_r_basecompetence = $this->content->setLink('teaching/readmyclass');
                $this->view->render('teaching/myclass');
            }
        }
    }

    public function myClassRoom($teachingid = 0) {

        Session::init();
        $user_references = Session::get('user_references');

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;
            $semesterid = 1;

            Web::setTitle('Kelas ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->link_back = '../../teaching/myclass/' . $class_info['subject_id'] . '.' . $class_info['grade_id'] . '.' . $class_info['period_id'] . '.' . $class_info['semester_id'];

            // Daily Score
            $this->view->option_basecompetance = $this->optionBaseCompetence($class_info['period_id'], $semesterid, $user_references, $class_info['subject_id'], $class_info['grade_id']);
            $this->view->option_scoretype = $this->optionScoreType();
            $this->view->link_export_dailyscore = $this->content->setLink('teaching/exportdailyscore/' . $teachingid);
            $this->view->link_save_daily_score = $this->content->setLink('teaching/savedailyscore');

            // Task Score $subject, $teacher, $period, $semester, $grade
            $this->view->option_taskdescription = $this->optionTaskDescription($class_info['subject_id'], $user_references, $class_info['period_id'], $semesterid, $class_info['grade_id']);
            $this->view->link_export_taskscore = $this->content->setLink('teaching/exporttaskscore/' . $teachingid);
            $this->view->link_save_task_score = $this->content->setLink('teaching/savetaskscore');

            // Attitude Score
            $this->view->link_export_attitudescore = $this->content->setLink('teaching/exportattitudescore/' . $teachingid);
            $this->view->link_save_attitude_score = $this->content->setLink('teaching/saveattitudescore');

            // Mid Score
            $this->view->link_export_midscore = $this->content->setLink('teaching/exportmidscore/' . $teachingid);
            $this->view->link_save_mid_score = $this->content->setLink('teaching/savemidscore');
            $this->view->link_read_mid_score = $this->content->setLink('teaching/readmidscore/' . $class_info['classgroup_id']);

            // Attitude Score
            $this->view->link_export_finalscore = $this->content->setLink('teaching/exportfinalscore/' . $teachingid);
            $this->view->link_save_final_score = $this->content->setLink('teaching/savefinalscore');
            $this->view->link_read_final_score = $this->content->setLink('teaching/readfinalscore/' . $class_info['classgroup_id']);

            $this->view->render('teaching/myclassroom');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function myclassekskul($statusid = 0) {

        Session::init();
        $user_references = Session::get('user_references');

        $teachingid = substr($statusid, 1);
        $semesterid = substr($statusid, 0, 1);

        $class_list = $this->model->selectClassEkskulListByTeachingId($teachingid, $user_references);
        $semester_list = $this->model->selectSemesterById($semesterid);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;
            $semester_info = $semester_list[0];
            $this->view->semester_info = $semester_info;

            Web::setTitle('Kelas ' . $class_info['extracurricular_name']);

            $this->view->option_class = $this->optionClass($class_info['period_id']);

            $this->view->render('teaching/myclassekskul');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function optionClass($period_id) {
        $option = array();
        $class = $this->model->selectClassGroupByPeriodId($period_id);
        foreach ($class as $row) {
            $option[$row['classgroup_id']] = $row['grade_title'] . ' (' . $row['grade_name'] . ') ' . $row['classroom_name'];
        }
        return $option;
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

    public function optionBaseCompetence($period, $semester, $teacher, $subject, $grade) {
        $option = array();
        $basecompetence = $this->model->selectBaseCompetence($period, $semester, $teacher, $subject, $grade);
        $idx = 1;
        foreach ($basecompetence as $row) {
            $option[$row['base_competence_id']] = $idx . '. ' . $row['base_competence_title'];
            $idx++;
        }
        return $option;
    }

    public function optionTaskDescription($subject, $teacher, $period, $semester, $grade) {
        $option = array();
        $no = 1;
        $basecompetence = $this->model->selectTaskDescription($subject, $teacher, $period, $semester, $grade);
        foreach ($basecompetence as $row) {
            $option[$row['task_description_id']] = $no . '. ' . $row['task_description_title'];
            $no++;
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

    public function saveTaskScore() {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];

            $task_description = $this->method->post('task_description');
            $period_id = 1;
            $semester_id = 1;

            foreach ($data as $row) {
                $score_list = $this->model->selectTaskSocoreByScoreFilter($row[0], $period_id, $semester_id, $task_description);
                if ($score_list) {
                    $data = $score_list[0];
                    $this->model->updateTaskScore($data['score_task_id'], $row[1]);
                } else {
                    $this->model->saveTaskScore($row[0], $row[1], $task_description);
                }
            }
        }
    }

    public function saveAttitudeScore() {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];

            $subject_id = $this->method->post('subject');
            $period_id = $this->method->post('period');
            $semester_id = $this->method->post('semester');

            foreach ($data as $row) {
                $score_list = $this->model->selectAttitudeSocoreByScoreFilter($row[0], $subject_id, $period_id, $semester_id);
                if ($score_list) {
                    $data = $score_list[0];
                    $this->model->updateAttitudeScore($data['score_attitude_id'], $row[1]);
                } else {
                    $this->model->saveAttitudeScore($row[0], $row[1], $subject_id, $period_id, $semester_id);
                }
            }
        }
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

    public function readGuardianInformation($id = 0) {
        $period = $this->method->post('p');
        $semester = $this->method->post('s');
        $guardian_list = $this->model->selectGuardianInformation($period, $semester, $id);
        if ($guardian_list) {
            $res = array(1, $guardian_list[0]);
        } else {
            $res = array(0);
        }
        echo json_encode($res);
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

    public function readTaskScore($class_group_id) {

        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $task_description = $this->method->post('task_description');
        $mlc = $this->method->post('mlc');

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $html_list = '';
        $no = 1;
        foreach ($student_list as $row) {

            $score_list = $this->model->selectTaskSocoreByScoreFilter($row['student_nis'], $period, $semester, $task_description);
            $score = '';
            if ($score_list) {
                $data = $score_list[0];
                $score = $data['score_task_value'];
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

    public function readAttitudeScore($class_group_id) {

        $subject = $this->method->post('subject');
        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $mlc = $this->method->post('mlc');

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $html_list = '';
        $no = 1;
        foreach ($student_list as $row) {

            $score_list = $this->model->selectAttitudeSocoreByScoreFilter($row['student_nis'], $subject, $period, $semester);
            $score = '';
            if ($score_list) {
                $data = $score_list[0];
                $score = $data['score_attitude_value'];
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
            header('Content-Disposition: attachment;filename="NILAI_HARIAN-' . $class_info['period_years_start'] . $class_info['period_years_end'] . $semester_info['semester_id'] . '-' . $class_info['grade_title'] . $class_info['classroom_name'] . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function exportTaskScore($id) {

        Session::init();
        $user_references = Session::get('user_references');
        list($teachingid, $task_description_id) = explode('_', $id);

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        $task_description_list = $this->model->selectTaskDescriptionById($task_description_id);

        if ($class_list) {
            $class_info = $class_list[0];
            $task_description_info = $task_description_list[0];

            $semester_list = $this->model->selectSemesterById($task_description_info['task_description_semester']);
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
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'DAFTAR NILAI TUGAS SISWA');
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
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A8', $task_description_id, PHPExcel_Cell_DataType::TYPE_STRING)->setCellValue('B8', 'Keterangan Tugas')->setCellValue('D8', ': ' . $task_description_info['task_description_title']);
            //$objPHPExcel->getActiveSheet()->setCellValue('A9', $score_type_id)->setCellValue('B9', 'Type')->setCellValue('D9', ': ' . $score_type_info['score_type_symbol'] . ' - ' . $score_type_info['score_type_description']);

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
                $score_list = $this->model->selectTaskSocoreByScoreFilter($row['student_nis'], $class_info['period_id'], $task_description_info['task_description_semester'], $task_description_id);
                $score = '';
                if ($score_list) {
                    $data = $score_list[0];
                    $score = $data['score_task_value'];
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
            header('Content-Disposition: attachment;filename="NILAI_TUGAS-' . $class_info['period_years_start'] . $class_info['period_years_end'] . $semester_info['semester_id'] . '-' . $class_info['grade_title'] . $class_info['classroom_name'] . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function exportAttitudeScore($id) {

        Session::init();
        $user_references = Session::get('user_references');
        list($teachingid, $semester_id) = explode('_', $id);

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);

        if ($class_list) {
            $class_info = $class_list[0];

            $semester_list = $this->model->selectSemesterById($semester_id);
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
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'DAFTAR NILAI TUGAS SISWA');
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
            //$objPHPExcel->getActiveSheet()->setCellValueExplicit('A8', $task_description_id, PHPExcel_Cell_DataType::TYPE_STRING)->setCellValue('B8', 'Keterangan Tugas')->setCellValue('D8', ': ' . $task_description_info['task_description_title']);
            //$objPHPExcel->getActiveSheet()->setCellValue('A9', $score_type_id)->setCellValue('B9', 'Type')->setCellValue('D9', ': ' . $score_type_info['score_type_symbol'] . ' - ' . $score_type_info['score_type_description']);

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
                $score_list = $this->model->selectAttitudeSocoreByScoreFilter($row['student_nis'], $class_info['subject_id'], $class_info['period_id'], $semester_id);
                $score = '';
                if ($score_list) {
                    $data = $score_list[0];
                    $score = $data['score_attitude_value'];
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
            header('Content-Disposition: attachment;filename="NILAI_SIKAP-' . $class_info['period_years_start'] . $class_info['period_years_end'] . $semester_info['semester_id'] . '-' . $class_info['grade_title'] . $class_info['classroom_name'] . '.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
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
                $score_list = $this->model->selectFinalSocoreByScoreFilter($row['student_nis'], $class_info['subject_id'], $class_info['period_id'], $semester_id, $score_type_id);
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

    public function importTaskScore() {

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
                $task_description = $objPHPExcel->getActiveSheet()->getCell('A8')->getValue();

                $count_student = $objPHPExcel->getActiveSheet()->getCell('A12')->getValue();
                $numrow = 13;
                for ($i = 1; $i <= $count_student; $i++) {
                    $nis = $objPHPExcel->getActiveSheet()->getCell('C' . $numrow)->getValue();
                    $score = $objPHPExcel->getActiveSheet()->getCell('F' . $numrow)->getValue();
                    //echo '<br>' . $i . '. ' . $nis . ' => ' . $score;

                    $score_list = $this->model->selectTaskSocoreByScoreFilter($nis, $period_id, $semester_id, $task_description);
                    if ($score_list) {
                        $data = $score_list[0];
                        $this->model->updateTaskScore($data['score_task_id'], $score);
                    } else {
                        $this->model->saveTaskScore($nis, $score, $task_description);
                    }

                    $numrow++;
                }

                $upload->RemoveFile($inputFileName);
            }
        } else {
            echo 'error';
        }
    }

    public function importAttitudeScore() {

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

                    $score_list = $this->model->selectAttitudeSocoreByScoreFilter($nis, $subject_id, $period_id, $semester_id);
                    if ($score_list) {
                        $data = $score_list[0];
                        $this->model->updateAttitudeScore($data['score_attitude_id'], $score);
                    } else {
                        $this->model->saveAttitudeScore($nis, $score, $subject_id, $period_id, $semester_id);
                    }

                    $numrow++;
                }

                $upload->RemoveFile($inputFileName);
            }
        } else {
            echo 'error';
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

    public function readTeaching() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $periodid = $this->method->post('p');
        $semesterid = $this->method->post('s');

        $myteaching = $this->model->selectTeaching($teacher_id, $periodid, $semesterid);
        $teaching_list = '';
        $idx = 1;

        if ($myteaching) {
            foreach ($myteaching as $row) {
                $tempid = $row['subject_id'] . '.' . $row['grade_id'] . '.' . $periodid . '.' . $semesterid;
                $teaching_list .= '<tr>';
                $teaching_list .= '
                    <td valign="top" class="first" align="center">' . $idx . '</td>
                    <td valign="top">
                        <div class="class-title">' . $row['subject_name'] . '</div>
                        <div class="link">
                            &bullet; <a href="teaching/myclass/' . $tempid . '" class="go-to-class">' . $row['total_class'] . ' Daftar Kelas</a>
                        </div>
                    </td>';

                $teaching_list .= '
                    <td valign="top">
                        <div class="class-title" align="center">' . $row['grade_title'] . ' (' . $row['grade_name'] . ') </div>
                    </td>
                    <td valign="top" align="center">' . $row['total_time'] . ' Jam</td>
                </tr>';

                $idx++;
            }
        } else {
            $teaching_list .= '
                            <tr>
                                <td class="first" colspan="4">
                                    <div class="information-box">
                                        Data mengajar tidak ditemukan.
                                    </div>
                                </td>
                            </tr>';
        }

        echo json_encode(array('count' => 1, 'row' => $teaching_list));
    }

    public function readTeachingEkskul() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $periodid = $this->method->post('p');
        $semesterid = $this->method->post('s');

        $myteaching = $this->model->selectTeachingEkskul($teacher_id, $periodid);
        $teaching_list = '';
        $idx = 1;

        if ($myteaching) {
            foreach ($myteaching as $row) {
                $teaching_list .= '<tr>';
                $teaching_list .= '
                    <td valign="top" class="first" align="center">' . $idx . '</td>
                    <td valign="top">
                        <div class="class-title">' . $row['extracurricular_name'] . '</div>
                        <div class="link">
                            &bullet; <a href="teaching/myclassekskul/' . $semesterid . $row['extracurricular_coach_history_id'] . '" class="go-to-class">Masuk Kelas</a>
                        </div>
                    </td>';

                $teaching_list .= '
                    <td valign="top" align="center">' . $row['extracurricular_coach_history_totaltime'] . ' Jam</td>
                </tr>';

                $idx++;
            }
        } else {
            $teaching_list .= '
                            <tr>
                                <td class="first" colspan="4">
                                    <div class="information-box">
                                        Data mengajar tidak ditemukan.
                                    </div>
                                </td>
                            </tr>';
        }

        echo json_encode(array('count' => 1, 'row' => $teaching_list));
    }

    public function readMyClass() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $subject_id = $this->method->post('subject');
        $period_id = $this->method->post('period');
        $semester_id = $this->method->post('semester');
        $grade_id = $this->method->post('grade');

        $myteaching = $this->model->selectMyClass($teacher_id, $subject_id, $grade_id, $period_id, $semester_id);
        $teaching_list = '';
        $idx = 1;

        if ($myteaching) {
            foreach ($myteaching as $row) {
                $teaching_list .= '<tr id="row_' . $row['teaching_id'] . '">';
                $teaching_list .= '     <td class="first" align="center">' . $idx . '</td>';
                $teaching_list .= '     <td align="center">' . $row['grade_title'] . ' (' . $row['grade_name'] . ') ' . $row['classroom_name'] . '</td>';
                $teaching_list .= '     <td align="center">' . $row['student_count'] . '</td>';
                $teaching_list .= '     <td>' . $row['employess_name'] . '</td>';
                $teaching_list .= '     <td align="center">' . $row['teaching_total_time'] . ' Jam</td>';
                $teaching_list .= '     <td>' . date('d-m-Y H:i:s', strtotime($row['teaching_entry_update'])) . '</td>';
                $teaching_list .= '     <td align="center"><a href="../myclassroom/' . $row['teaching_id'] . '" rel="edit">Masuk Kelas</a> &bullet; <a href="../scorerecapitulation/' . $row['teaching_id'] . '" rel="delete">Rekapitulasi Nilai</a></td>';
                $teaching_list .= '</tr>';
                $idx++;
            }
        } else {
            $teaching_list .= '
                            <tr>
                                <td class="first" colspan="5">
                                    <div class="information-box">
                                        Kompetensi dasar tidak ditemukan.
                                    </div>
                                </td>
                            </tr>';
        }

        echo json_encode(array('count' => 1, 'row' => $teaching_list));
    }

    public function scoreRecapitulation($teachingid = 0) {
        Session::init();
        $user_references = Session::get('user_references');

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;

            Web::setTitle('Rekapitulasi Nilai ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->link_back = '../../teaching/myclass/' . $class_info['subject_id'] . '.' . $class_info['grade_id'] . '.' . $class_info['period_id'] . '.' . $class_info['semester_id'];

            $this->view->link_r = $this->content->setLink('teaching/readscorerecapitulation/' . $class_info['classgroup_id']);

            $this->view->render('teaching/scorerecapitulation');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function readScoreRecapitulation($class_group_id = 0) {
        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $subject = $this->method->post('subject');
        $mlc = $this->method->post('mlc');

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $html_list = '';
        $no = 1;
        foreach ($student_list as $row) {

            $score_list = $this->model->selectMidSocoreByScoreFilter($row['student_nis'], $subject, $period, $semester);
            $score = '-';
            if ($score_list) {
                $data = $score_list[0];
                $score = $data['score_mid_value'];
            }

            $desc = '-';
            $font_color = '';
            if ($score != '') {
                if ($score > $mlc) {
                    $desc = 'Terlampaui';
                } else if ($score == $mlc) {
                    $desc = 'Tercapai';
                } else {
                    $desc = 'Tidak Tercapai';
                    $font_color = ' style="color:red" ';
                }
            }

            $score_list2 = $this->model->selectFinalSocoreByScoreFilter($row['student_nis'], $subject, $period, $semester);
            $score2 = '-';
            if ($score_list2) {
                $data2 = $score_list2[0];
                $score2 = $data2['score_final_value'];
            }

            $desc2 = '-';
            $font_color2 = '';
            if ($score2 != '') {
                if ($score2 > $mlc) {
                    $desc2 = 'Terlampaui';
                } else if ($score2 == $mlc) {
                    $desc2 = 'Tercapai';
                } else {
                    $desc2 = 'Tidak Tercapai';
                    $font_color2 = ' style="color:red" ';
                }
            }

            $html_list .= '<tr>';
            $html_list .= '     <td align="center" class="first">' . $no . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nis'] . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nisn'] . '</td>';
            $html_list .= '     <td>' . $row['student_name'] . '</td>';
            $html_list .= '     <td align="center" ' . $font_color . '>' . $score . '</td>';
            $html_list .= '     <td align="center" class="desc_' . $row['student_nis'] . '" ' . $font_color . '>' . $desc . '</td>';
            $html_list .= '     <td align="center" ' . $font_color2 . '>' . $score2 . '</td>';
            $html_list .= '     <td align="center" class="desc_' . $row['student_nis'] . '" ' . $font_color2 . '>' . $desc2 . '</td>';
            $html_list .= '</tr>';
            $no++;
        }
        echo json_encode(array('count' => $no - 1, 'row' => $html_list));
    }

    public function detailScore() {
        $detail = "<div id='online-score' style='background:#fff;'>";
        $detail .= "    <div class='box-green' style='margin-bottom:5px;'>";
        $detail .= "        lsdkml";
        $detail .= "    </div>";
        $detail .= "    <div class='description'>Berikut adalah daftar nilai:</div>";
        $detail .= "    <table class='table-list' cellspacing='0' cellpadding='0' style='width:100%'>";
        $detail .= "        <thead>";
        $detail .= "            <tr>";
        $detail .= "                <td width='50' align='center' class='first'>No.</td>";
        $detail .= "                <td>Keterangan Nilai</td>";
        $detail .= "                <td width='50' align='center'>KKM</td>";
        $detail .= "                <td width='50' align='center'>Nilai</td>";
        $detail .= "                <td width='150' align='center'>Keterangan</td>";
        $detail .= "            <tr>";
        $detail .= "        </thead>";
        $detail .= "        <tbody>";

        $recap_list = $this->model->selectRecapList();
        $idx = 1;
        foreach ($recap_list as $row) {
            $list = array();
            if ($row['recapitulation_type_reference'] == "academic_score_daily") {
                $list = $this->model->selectRecapDailyScore();
            }

            $list_count = count($list);
            $rowspan = $list_count + 1;

            $detail .= "            <tr style='font-weight:bold;'>";
            $detail .= "                <td align='center' valign='top' class='first' rowspan='" . $rowspan . "'>" . $idx . "</td>";
            $detail .= "                <td>" . $row['recapitulation_type_title'] . "</td>";
            $detail .= "                <td align='center'>?</td>";
            $detail .= "                <td align='center'>?</td>";
            $detail .= "                <td align='center'>?</td>";
            $detail .= "            </tr>";

            $alpha_numbering = "a";
            foreach ($list as $rowscore) {
                $detail .= "            <tr>";
                $detail .= "                <td>" . $alpha_numbering . ". " . $rowscore['base_competence_title'] . "</td>";
                $detail .= "                <td align='center'>80</td>";
                $detail .= "                <td align='center'>80</td>";
                $detail .= "                <td align='center'>Tercapai</td>";
                $detail .= "            </tr>";
                $alpha_numbering++;
            }

            $idx++;
        }

        $detail .= "        </tbody>";
        $detail .= "    </table>";
        $detail .= "</div>";
        echo $detail;
    }

}