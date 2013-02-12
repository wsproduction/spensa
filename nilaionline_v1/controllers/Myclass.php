<?php

class Myclass extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view($id = 0) {
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

                $this->view->link_back = $this->content->setParentLink('teaching');
                $this->view->link_r_basecompetence = $this->content->setLink('myclass/readmyclass');

                $this->view->render('myclass/listview');
            }
        }
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
                $guardian_name = '-';
                if ($row['employees_id'] != '000000000000') {
                    $guardian_name = $row['employess_name'];
                }
                
                $link_classgroup = $this->content->setParentLink('classgroup/room/' . $row['teaching_id'] . '');

                $teaching_list .= '<tr id="row_' . $row['teaching_id'] . '">';
                $teaching_list .= '     <td class="first" align="center">' . $idx . '</td>';
                $teaching_list .= '     <td align="center">' . $row['grade_title'] . ' (' . $row['grade_name'] . ') ' . $row['classroom_name'] . '</td>';
                $teaching_list .= '     <td align="center">' . $row['student_count'] . '</td>';
                $teaching_list .= '     <td>' . $guardian_name . '</td>';
                $teaching_list .= '     <td align="center">' . $row['teaching_total_time'] . ' Jam</td>';
                $teaching_list .= '     <td>' . date('d-m-Y H:i:s', strtotime($row['teaching_entry_update'])) . '</td>';
                $teaching_list .= '     <td align="center"><a href="' . $link_classgroup . '" rel="edit">Masuk Kelas</a></td>';
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

}