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