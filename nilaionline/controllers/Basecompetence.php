<?php

class Basecompetence extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($id = 0) {
        Web::setTitle('Kompetensi Dasar');

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

                $this->view->link_r_basecompetence = $this->content->setLink('basecompetence/readbasecompetence');
                $this->view->link_d_basecompetence = $this->content->setLink('basecompetence/deletebasecompetence');
                
                $this->view->render('basecompetence/index');
            }
        }
    }

    public function readBaseCompetence() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $subject_id = $this->method->post('subject');
        $period_id = $this->method->post('period');
        $semester_id = $this->method->post('semester');
        $grade_id = $this->method->post('grade');

        $myteaching = $this->model->selectBaseCompetence($teacher_id, $subject_id, $grade_id, $period_id, $semester_id);
        $teaching_list = '';
        $idx = 1;

        if ($myteaching) {
            foreach ($myteaching as $row) {
                $teaching_list .= '<tr id="row_' . $row['base_competence_id'] . '">';
                $teaching_list .= '     <td class="first" align="center">' . $idx . '</td>';
                $teaching_list .= '     <td class="competence_title">' . $row['base_competence_title'] . '</td>';
                $teaching_list .= '     <td align="center" class="competence_mlc">' . $row['base_competence_mlc'] . '</td>';
                $teaching_list .= '     <td>' . date('d-m-Y H:i:s', strtotime($row['base_competence_entry_update'])) . '</td>';
                $teaching_list .= '     <td align="center"><a href="' . $row['base_competence_id'] . '" rel="edit">Edit</a> &bullet; <a href="' . $row['base_competence_id'] . '" rel="delete">Hapus</a></td>';
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
    
    public function create() {
        Session::init();
        $teacher_id = Session::get('user_references');
        
        $result = false;
        if ($this->model->saveBaseCompetence($teacher_id)) {
            $result = true;
        }
        echo json_encode($result);
    }
    
    public function update($id) {
        Session::init();
        $teacher_id = Session::get('user_references');
        
        $result = false;
        if ($this->model->updateBaseCompetence($id, $teacher_id)) {
            $result = true;
        }
        echo json_encode($result);
    }
    
    public function deleteBaseCompetence() {
        
        $id = $this->method->post('id');
        
        $result = false;
        if ($this->model->deleteBaseCompetenceById($id)) {
            $result = true;
        }
        
        echo json_encode($result);
    }
}