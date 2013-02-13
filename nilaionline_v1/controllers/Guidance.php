<?php

class Guidance extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('BK (Bimbingan dan Konseling)');

        Session::init();
        $user_references = Session::get('user_references');
        $teacher_list = $this->model->selectTeacherInformationById($user_references);
        if ($teacher_list) {
            $teacher_info = $teacher_list[0];
            $this->view->teacher_info = $teacher_info;

            $this->view->option_period = $this->optionPeriod();
            $this->view->link_guardian_information = $this->content->setLink('guidance/readguardianinformation/' . $user_references);
            $this->view->link_r_teaching = $this->content->setLink('guidance/readteaching');
            $this->view->link_r_teaching_ekskul = $this->content->setLink('guidance/readextracurricular');
            $this->view->link_guardian = $this->content->setParentLink('guardian/page');
            $this->view->render('guidance/index');
        } else {
            $this->view->render('guidance/404');
        }
    }

    public function attitude($teachingid = 0) {
        Session::init();
        $user_references = Session::get('user_references');

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;

            Web::setTitle('Bimbingan Konseling | Kelas ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->link_back = $this->content->setParentLink('guidance');
            $this->view->link_score_export = $this->content->setLink('guidance/exportscore/' . $teachingid);
            $this->view->link_score_save = $this->content->setLink('guidance/savescore/' . $teachingid . '.' . $class_info['classgroup_id']);
            $this->view->link_score_read = $this->content->setLink('guidance/readscore/' . $teachingid . '.' . $class_info['classgroup_id']);

            $this->view->render('guidance/attitude');
        } else {
            $this->view->render('guidance/404');
        }
    }

    public function personality($teachingid = 0) {
        Session::init();
        $user_references = Session::get('user_references');

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;

            Web::setTitle('Bimbingan Konseling | Kelas ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->link_back = $this->content->setParentLink('guidance');
            $this->view->link_score_export = $this->content->setLink('guidance/exportscore/' . $teachingid);
            $this->view->link_score_save = $this->content->setLink('guidance/savescore/' . $teachingid . '.' . $class_info['classgroup_id']);
            $this->view->link_score_read = $this->content->setLink('guidance/readscore/' . $teachingid . '.' . $class_info['classgroup_id']);

            $this->view->render('guidance/personality');
        } else {
            $this->view->render('guidance/404');
        }
    }

    public function attendance($teachingid = 0) {
        Session::init();
        $user_references = Session::get('user_references');

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);
        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;

            Web::setTitle('Bimbingan Konseling | Kelas ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->link_back = $this->content->setParentLink('guidance');
            $this->view->link_score_export = $this->content->setLink('guidance/exportscore/' . $teachingid);
            $this->view->link_score_save = $this->content->setLink('guidance/savescore/' . $teachingid . '.' . $class_info['classgroup_id']);
            $this->view->link_score_read = $this->content->setLink('guidance/readattendance/' . $teachingid . '.' . $class_info['classgroup_id']);

            $this->view->render('guidance/attendance');
        } else {
            $this->view->render('guidance/404');
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
                $tempid = $row['guidance_id'];
                $link_attitude = $this->content->setParentLink('guidance/attitude/' . $tempid);
                $link_personality = $this->content->setParentLink('guidance/personality/' . $tempid);
                $link_attendance = $this->content->setParentLink('guidance/attendance/' . $tempid);
                $teaching_list .= '<tr>';
                $teaching_list .= '
                    <td valign="top" class="first" align="center">' . $idx . '</td>';

                $teaching_list .= '
                    <td valign="top">
                        <div align="center">' . $row['grade_title'] . ' (' . $row['grade_name'] . ') ' . $row['classroom_name'] . ' </div>
                    </td>
                    <td valign="top" align="center">' . $row['student_count'] . '</td>
                    <td valign="top" align="left">' . $row['employess_name'] . '</td>
                    <td valign="top" align="center">' . $row['guidance_entry_update'] . '</td>
                    <td valign="top" align="center"><div class="link"><a href="' . $link_attitude . '">Ahlak</a> &bullet;  <a href="' . $link_personality . '">Kepribadian</a> &bullet; <a href="' . $link_attendance . '">Ketidakhadiran</a></div></td>
                </tr>';

                $idx++;
            }
        } else {
            $teaching_list .= '
                            <tr>
                                <td class="first" colspan="6">
                                    <div class="information-box">
                                        Data mengajar tidak ditemukan.
                                    </div>
                                </td>
                            </tr>';
        }

        echo json_encode(array('count' => 1, 'row' => $teaching_list));
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

            Form::create('select', 'score_list_' . $no);
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

    public function readAttendance($tempid = 0) {

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
            Form::value($score);
            Form::size(5);
            Form::properties(array('order' => $row['student_nis']));
            Form::style('score_list');
            $score_input = Form::commit('attach');

            Form::create('text', 'score_list2_' . $no);
            Form::value($score);
            Form::size(5);
            Form::properties(array('order' => $row['student_nis']));
            Form::style('score_list');
            $score_input2 = Form::commit('attach');

            Form::create('text', 'score_list3_' . $no);
            Form::value($score);
            Form::size(5);
            Form::properties(array('order' => $row['student_nis']));
            Form::style('score_list');
            $score_input3 = Form::commit('attach');

            $html_list .= '<tr>';
            $html_list .= '     <td align="center" class="first">' . $no . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nis'] . '</td>';
            $html_list .= '     <td align="center">' . $row['student_nisn'] . '</td>';
            $html_list .= '     <td>' . $row['student_name'] . '</td>';
            $html_list .= '     <td align="center">' . $score_input . '</td>';
            $html_list .= '     <td align="center">' . $score_input2 . '</td>';
            $html_list .= '     <td align="center">' . $score_input3 . '</td>';
            $html_list .= '</tr>';
            $no++;
        }
        echo json_encode(array('count' => $no - 1, 'row' => $html_list));
    }

}