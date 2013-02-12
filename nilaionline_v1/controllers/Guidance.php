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
                //$tempid = $row['subject_id'] . '.' . $row['grade_id'] . '.' . $periodid . '.' . $semesterid;
                //$link_myclass = $this->content->setParentLink('myclass/view/' . $tempid);
                $teaching_list .= '<tr>';
                $teaching_list .= '
                    <td valign="top" class="first" align="center">' . $idx . '</td>';

                $teaching_list .= '
                    <td valign="top">
                        <div align="center">' . $row['grade_title'] . ' (' . $row['grade_name'] . ') ' . $row['classroom_name'] . ' </div>
                    </td>
                    <td valign="top" align="center">' . $row['student_count'] . '</td>
                    <td valign="top" align="left">' . $row['employess_name'] .  '</td>
                    <td valign="top" align="center">' . $row['guidance_entry_update'] .  '</td>
                    <td valign="top" align="center"><div class="link"><a href="">Ahlak & Kepribadian</a> &bullet; <a href="">Ketidakhadiran</a></div></td>
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