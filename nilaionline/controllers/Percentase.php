<?php

class Percentase extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Web::setTitle('Persentase Nilai');
        $this->view->option_period = $this->optionPeriod();
        $this->view->link_r_percentase = $this->content->setLink('percentase/readpercentase');
        $this->view->render('percentase/index');
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
    
    public function readPercentase() {
        Session::init();
        $teacher_id = Session::get('user_references');

        $periodid = $this->method->post('p');
        $semesterid = $this->method->post('s');

        $myteaching = $this->model->selectSubjectTeaching($teacher_id, $periodid);
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

}