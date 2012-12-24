<?php

class Task extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($id = 0) {
        Web::setTitle('Tugas');

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

                $this->view->link_r_task = $this->content->setLink('task/readtask');
                $this->view->link_d_task = $this->content->setLink('task/deletetask');
                
                $this->view->render('task/index');
            }
        }
    }

    public function readTask() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $subject_id = $this->method->post('subject');
        $period_id = $this->method->post('period');
        $semester_id = $this->method->post('semester');
        $grade_id = $this->method->post('grade');

        $myteaching = $this->model->selectTask($teacher_id, $subject_id, $grade_id, $period_id, $semester_id);
        $teaching_list = '';
        $idx = 1;

        if ($myteaching) {
            foreach ($myteaching as $row) {
                $teaching_list .= '<tr id="row_' . $row['task_description_id'] . '">';
                $teaching_list .= '     <td class="first" align="center" valign="top">' . $idx . '</td>';
                $teaching_list .= '     <td class="task_title">';
                $teaching_list .= '         <div style="margin:0 5px;font-weight:bold;">' . $row['task_description_title'] . '</div>';
                $teaching_list .= '         <div class="description" style="border: 1px solid #ccc;font-style: italic;">' . $row['task_description'] . '</div>';
                $teaching_list .= '     </td>';
                $teaching_list .= '     <td valign="top">' . date('d-m-Y H:i:s', strtotime($row['task_description_entry_update'])) . '</td>';
                $teaching_list .= '     <td align="center" valign="top"><a href="' . $row['task_description_id'] . '" rel="edit">Edit</a> &bullet; <a href="' . $row['task_description_id'] . '" rel="delete">Hapus</a></td>';
                $teaching_list .= '</tr>';

                $idx++;
            }
        } else {
            $teaching_list .= '
                            <tr>
                                <td class="first" colspan="4">
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
        if ($this->model->saveTask($teacher_id)) {
            $result = true;
        }
        echo json_encode($result);
    }
    
    public function update($id) {
        Session::init();
        $teacher_id = Session::get('user_references');
        
        $result = false;
        if ($this->model->updateTask($id, $teacher_id)) {
            $result = true;
        }
        echo json_encode($result);
    }
    
    public function deleteTask() {
        
        $id = $this->method->post('id');
        
        $result = false;
        if ($this->model->deleteBaseCompetenceById($id)) {
            $result = true;
        }
        
        echo json_encode($result);
    }
}