<?php

class Guardian extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function page($classgroup_id = 0) {
        Web::setTitle('Halaman Wali Kelas');
        Session::init();
        $user_references = Session::get('user_references');
        $guardian_list = $this->model->selectGuardianInformation($classgroup_id, $user_references);
        if ($guardian_list) {
            $guardian_info = $guardian_list[0];
            $this->view->guardian_info = $guardian_info;

            $this->view->link_back = $this->content->setParentLink('teaching');
            $this->view->link_rapor = $this->content->setParentLink('report/preview/' . $classgroup_id);
            $this->view->link_read_subject = $this->content->setLink('guardian/readsubject/' . $classgroup_id . '.' . $guardian_info['classgroup_grade'] . '.' . $guardian_info['classgroup_period'] . '.' . $guardian_info['classgroup_semester']);
            $this->view->link_read_eskul = $this->content->setLink('guardian/readeskul/' . $classgroup_id . '.' . $guardian_info['classgroup_grade'] . '.' . $guardian_info['classgroup_period'] . '.' . $guardian_info['classgroup_semester']);
            $this->view->render('guardian/index');
        } else {
            $this->view->render('guardian/404');
        }
    }

    public function readSubject($tempid = 0) {

        list($classgroup_id, $grade, $period, $semester) = explode('.', $tempid);

        $student_list = $this->model->selectSubjectByClassGroup($classgroup_id);
        $student_id = '0';
        foreach ($student_list as $row) {
            $student_id .= ',' . $row['student_nis'];
        }

        $subject_list = $this->model->selectSubjectByStudentId($student_id, $grade, $period, $semester);
        $subject_info = array();

        foreach ($subject_list as $row) {
            $subject_info[$row['subject_category']][] = array(
                'teaching_id' => $row['teaching_id'],
                'employees_nip' => $row['employees_nip'],
                'employess_name' => $row['employess_name'],
                'subject_name' => $row['subject_name'],
                'midscore_count' => $row['midscore_count'],
                'finalscore_count' => $row['finalscore_count'],
                'student_count' => $row['student_count'],
                'classgroup_id' => $row['classgroup_id']
            );
        }

        $html_list = '';
        if (count($subject_info) > 0) {
            $idx = 1;

            /* Matapelajaran Wajib */
            if (isset($subject_info[1])) {
                $rowspan = count($subject_info[1]) + 1;
                $html_list .= '<tr>
                                    <td class="first" align="center" valign="top" rowspan="' . $rowspan . '" style="font-weight:bold;">' . $idx . ' .</td>
                                    <td colspan="5" style="font-weight:bold;">Mata Pelajaran Wajib :</td>
                               </tr>';
                $i = 'a';
                foreach ($subject_info[1] as $row) {

                    $sc1 = $row['student_count'];
                    $link_view = $this->content->setParentLink('recapitulation/notification/' . $row['teaching_id'] . '.' . $classgroup_id . '.' . $row['classgroup_id']);

                    $html_list .= '<tr>';
                    $html_list .= '     <td>' . $i . '. ' . $row['subject_name'] . '</td>';
                    $html_list .= '     <td>' . $row['employess_name'] . '</td>';
                    $html_list .= '     <td align="center">' . $row['midscore_count'] . '/' . $sc1 . ' Siswa</td>';
                    $html_list .= '     <td align="center">' . $row['finalscore_count'] . '/' . $sc1 . ' Siswa</td>';
                    $html_list .= '     <td align="center"><a href="' . $link_view . '">Lihat</a></td>';
                    $html_list .= '</tr>';
                    $i++;
                }
                $idx++;
            }

            /* Matapelajaran Pilihan */
            if (isset($subject_info[2])) {

                $rowspan = count($subject_info[2]) + 1;
                $html_list .= '<tr>
                                    <td class="first" align="center" valign="top" rowspan="' . $rowspan . '" style="font-weight:bold;">' . $idx . ' .</td>
                                    <td colspan="5" style="font-weight:bold;">Mata Pelajaran Pilihan :</td>
                               </tr>';
                $i = 'a';
                foreach ($subject_info[2] as $row) {

                    $sc2 = $row['student_count'];
                    $link_view = $this->content->setParentLink('recapitulation/notification/' . $row['teaching_id'] . '.' . $classgroup_id . '.' . $row['classgroup_id']);

                    $html_list .= '<tr>';
                    $html_list .= '     <td>' . $i . '. ' . $row['subject_name'] . '</td>';
                    $html_list .= '     <td>' . $row['employess_name'] . '</td>';
                    $html_list .= '     <td align="center">' . $row['midscore_count'] . '/' . $sc2 . ' Siswa</td>';
                    $html_list .= '     <td align="center">' . $row['finalscore_count'] . '/' . $sc2 . ' Siswa</td>';
                    $html_list .= '     <td align="center"><a href="' . $link_view . '">Lihat</a></td>';
                    $html_list .= '</tr>';
                    $i++;
                }
                $idx++;
            }

            /* Matapelajaran Mulok */
            if (isset($subject_info[3])) {

                $rowspan = count($subject_info[3]) + 1;
                $html_list .= '<tr>
                                    <td class="first" align="center" valign="top" rowspan="' . $rowspan . '" style="font-weight:bold;">' . $idx . ' .</td>
                                    <td colspan="5" style="font-weight:bold;">Muatan Lokal :</td>
                               </tr>';
                $i = 'a';
                foreach ($subject_info[3] as $row) {

                    $sc3 = $row['student_count'];
                    $link_view = $this->content->setParentLink('recapitulation/notification/' . $row['teaching_id'] . '.' . $classgroup_id . '.' . $row['classgroup_id']);

                    $html_list .= '<tr>';
                    $html_list .= '     <td>' . $i . '. ' . $row['subject_name'] . '</td>';
                    $html_list .= '     <td>' . $row['employess_name'] . '</td>';
                    $html_list .= '     <td align="center">' . $row['midscore_count'] . '/' . $sc3 . ' Siswa</td>';
                    $html_list .= '     <td align="center">' . $row['finalscore_count'] . '/' . $sc3 . ' Siswa</td>';
                    $html_list .= '     <td align="center"><a href="' . $link_view . '">Lihat</a></td>';
                    $html_list .= '</tr>';
                    $i++;
                }
            }
        } else {
            $html_list .= '<tr>
                                <td class="first" colspan="6">
                                    <div class="information-box">
                                        Data tidak ditemukan
                                    </div>
                                </td>
                            </tr>';
        }
        echo json_encode($html_list);
    }

    public function readEskul($tempid = 0) {

        list($classgroup_id, $grade, $period, $semester) = explode('.', $tempid);

        $student_list = $this->model->selectSubjectByClassGroup($classgroup_id);
        $student_id = '0';
        foreach ($student_list as $row) {
            $student_id .= ',' . $row['student_nis'];
        }
        
        $subject_list = $this->model->selectExtracuriculerByStudentId($student_id, $grade, $period, $semester);

        $html_list = '';
        if (count($subject_list) > 0) {
            $idx = 1;
            foreach ($subject_list as $value) {
                $student_count = $value['student_count'];
                $html_list .= '<tr>
                                <td class="first" style="text-align:center">' . $idx . '.</td>
                                <td>' . $value['extracurricular_name'] . '</td>
                                <td>' . $value['employess_name'] . '</td>
                                <td style="text-align:center">' . $value['midscore_count'] . '/' . $student_count . ' Siswa</td>
                                <td style="text-align:center">' . $value['finalscore_count'] . '/' . $student_count . ' Siswa</td>
                                <td style="text-align:center">Lihat</td>
                            </tr>';
                $idx++;
            }
        } else {
            $html_list .= '<tr>
                                <td class="first" colspan="6">
                                    <div class="information-box">
                                        Data tidak ditemukan
                                    </div>
                                </td>
                            </tr>';
        }
        echo json_encode($html_list);
    }

}