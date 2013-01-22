<?php

class Percentase extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($id = 0) {
        Web::setTitle('Persentase Nilai');
        if ($id) {
            list($subject_id, $grade_id, $period_id, $semester_id) = explode('.', $id);

            if (isset($subject_id) && isset($grade_id) && isset($period_id) && isset($semester_id)) {
                Session::init();
                $user_references = Session::get('user_references');

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

                $this->view->recap_list = $this->percentaseList($user_references, $subject_id, $grade_id, $period_id, $semester_id);

                $this->view->link_save = $this->content->setLink('percentase/savepercentase');
                $this->view->link_r_percentase = $this->content->setLink('percentase/readpercentase');
                $this->view->render('percentase/index');
            }
        }
    }

    public function percentaseList($teacher, $subject, $grade, $period, $semester) {

        $recapitulation_list = $this->model->selectRecapType();
        $list = '<tbody>';
        $idx = 1;
        $total = 0;
        foreach ($recapitulation_list as $row) {
            $percentase_list = $this->model->selectPercentase($row['recapitulation_type_id'], $teacher, $subject, $grade, $period, $semester);

            $value = 0;
            $last_update = '-';
            if ($percentase_list) {
                if (count($percentase_list) > 0) {
                    $percentase_data = $percentase_list[0];
                    $value = $percentase_data['score_percentase_value'];
                    $last_update = date('d.m.Y H:i:s', strtotime($percentase_data['score_percentase_entry_update']));
                }
            }

            $total += $value;

            Form::create('text');
            Form::style('form_percentase');
            Form::value($value);
            Form::properties(array('style' => 'text-align:center;width:100px;', 'temp_id' => $row['recapitulation_type_id']));
            $input = Form::commit('attach');
            Form::create('hidden', 'form_percentase_' . $row['recapitulation_type_id']);
            Form::value($value);
            $input_temp = Form::commit('attach');

            $list .= '<tr>';
            $list .= '  <td class="first" align="center">' . $idx . '</td>';
            $list .= '  <td>' . $row['recapitulation_type_title'] . '</td>';
            $list .= '  <td align="center">' . $input . ' %</td>';
            $list .= '  <td align="center">' . $last_update . $input_temp . '</td>';
            $list .= '</tr>';
            $idx++;
        }

        $list .= '<tr style="background-color:#fff9d7;">';
        $list .= '  <td class="first" align="center" colspan="2"><b>Total</b></td>';
        $list .= '  <td align="center"><b id="calculate_percentase">' . $total . ' %</b></td>';
        $list .= '  <td align="center">-</td>';
        $list .= '</tr>';

        $list .= '</tbody>';
        return $list;
    }

    public function readPercentase() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $periodid = $this->method->post('p');
        $semesterid = $this->method->post('s');

        $myteaching = $this->model->selectRecapType();
        $teaching_list = '';
        $idx = 1;

        if ($myteaching) {
            foreach ($myteaching as $row) {
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

    public function savePercentase() {
        Session::init();
        $user_references = Session::get('user_references');
        
        $data = $_POST['data'];
        $subject = $this->method->post('subject');
        $period = $this->method->post('period');
        $semester = $this->method->post('semester');
        $grade = $this->method->post('grade');

        foreach ($data as $row) {
            $recap_type = $row[0];
            $value = $row[1];

            $percentase_list = $this->model->selectPercentase($recap_type, $user_references, $subject, $grade, $period, $semester);
            if (count($percentase_list)>0) {
                $percentase_data = $percentase_list[0];
                $this->model->updatePercentase($percentase_data['score_percentase_id'], $value);
            } else {
                $this->model->savePercentase($recap_type, $user_references, $subject, $grade, $period, $semester, $value);
            }
        }
        echo json_encode(true);
    }

}