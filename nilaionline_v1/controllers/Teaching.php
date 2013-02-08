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
            $this->view->link_r_teaching_ekskul = $this->content->setLink('teaching/readextracurricular');
            $this->view->link_guardian = $this->content->setParentLink('guardian/page');
            $this->view->render('teaching/index');
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
                $link_myclass = $this->content->setParentLink('myclass/view/' . $tempid);
                $teaching_list .= '<tr>';
                $teaching_list .= '
                    <td valign="top" class="first" align="center">' . $idx . '</td>
                    <td valign="top">
                        <div><span  class="class-title">' . $row['subject_name'] . ' </span> <span style="color:#999">/ ' . $row['subject_category_title'] . '</span></div>
                        <div class="link">
                            &bullet; <a href="' . $link_myclass . '" class="go-to-class">' . $row['total_class'] . ' Daftar Kelas</a>
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

    public function readExtracurricular() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $periodid = $this->method->post('p');
        $semesterid = $this->method->post('s');

        $myteaching = $this->model->selectExtracurricular($teacher_id, $periodid, $semesterid);
        $teaching_list = '';
        $idx = 1;

        if ($myteaching) {
            foreach ($myteaching as $row) {

                $link = $this->content->setParentLink('extracurricular/room/' . $row['extracurricular_coach_history_id']);

                $teaching_list .= '<tr>';
                $teaching_list .= '
                    <td valign="top" class="first" align="center">' . $idx . '</td>
                    <td valign="top">
                        <div class="class-title">' . $row['extracurricular_name'] . '</div>
                        <div class="link">
                            &bullet; <a href="' . $link . '" class="go-to-class">Masuk Kelas</a>
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

}