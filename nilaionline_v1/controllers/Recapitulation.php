<?php

class Recapitulation extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($teachingid = 0) {
        Session::init();
        $user_references = Session::get('user_references');

        $class_list = $this->model->selectClassListByTeachingId($teachingid, $user_references);

        if ($class_list) {
            $class_info = $class_list[0];
            $this->view->class_info = $class_info;

            Web::setTitle('Rekapitulasi Nilai ' . $class_info['grade_title'] . ' (' . $class_info['grade_name'] . ') ' . $class_info['classroom_name']);

            $this->view->link_back = $this->content->setParentLink('myclass/view/' . $class_info['subject_id'] . '.' . $class_info['grade_id'] . '.' . $class_info['period_id'] . '.' . $class_info['semester_id']);
            $this->view->link_r = $this->content->setLink('recapitulation/readscore/' . $teachingid . '.' . $class_info['classgroup_id'] . '.' . $class_info['mlc_value']);

            $this->view->render('recapitulation/index');
        } else {
            $this->view->render('teaching/404');
        }
    }

    public function readScore($tempid = 0) {

        list ($teachingid, $class_group_id, $mlc) = explode('.', $tempid);

        $student_list = $this->model->selectStudentByClassGroupId($class_group_id);
        $student_id_list = $this->parsingStudentId($student_list);
        $score_list = $this->model->selectSocoreByScoreFilter($student_id_list, $teachingid);
        $score_data = $this->parsingScore($score_list);

        $html_list = '';
        $no = 1;

        if (count($student_list) > 0) {
            foreach ($student_list as $row) {

                $score = '';
                if (isset($score_data[$row['student_nis']][1])) {
                    $data = $score_data[$row['student_nis']][1];
                    $score = $data['value'];
                }

                $desc = '-';
                if ($score != '') {
                    $desc = $this->content->descProgressLearning($score, $mlc);
                }

                $score2 = '';
                if (isset($score_data[$row['student_nis']][2])) {
                    $data2 = $score_data[$row['student_nis']][2];
                    $score2 = $data2['value'];
                }

                $desc2 = '-';
                if ($score2 != '') {
                    $desc2 = $this->content->descProgressLearning($score, $mlc);
                }

                $html_list .= '<tr>';
                $html_list .= '     <td align="center" class="first">' . $no . '</td>';
                $html_list .= '     <td align="center">' . $row['student_nis'] . '</td>';
                $html_list .= '     <td align="center">' . $row['student_nisn'] . '</td>';
                $html_list .= '     <td>' . $row['student_name'] . '</td>';
                $html_list .= '     <td align="center">' . $score . '</td>';
                $html_list .= '     <td align="center" class="desc_' . $row['student_nis'] . '">' . $desc . '</td>';
                $html_list .= '     <td align="center">' . $score2 . '</td>';
                $html_list .= '     <td align="center" class="desc_' . $row['student_nis'] . '">' . $desc2 . '</td>';
                $html_list .= '</tr>';
                $no++;
            }
        } else {
            $html_list .= '
                        <tr>
                            <td class="first" colspan="6">
                                <div class="information-box">
                                    Data tidak ditemukan
                                </div>
                            </td>
                        </tr>';
        }
        echo json_encode(array('count' => $no - 1, 'row' => $html_list));
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
            $score[$row['score_student']][$row['score_type']] = array(
                'score_id' => $row['score_id'],
                'value' => $row['score_value']
            );
        }
        return $score;
    }

}