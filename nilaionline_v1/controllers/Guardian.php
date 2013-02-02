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

            $this->view->link_read_subject = $this->content->setLink('guardian/readsubject/' . $classgroup_id);
            $this->view->link_read_pbkl = $this->content->setLink('guardian/readpbkl/' . $classgroup_id);
            $this->view->link_read_eskul = $this->content->setLink('guardian/readeskul/' . $classgroup_id);
            $this->view->render('guardian/index');
        } else {
            $this->view->render('guardian/404');
        }
    }

    public function readSubject($classgroup_id = 0) {
        $subject_list = $this->model->selectSubjectByClassGroup($classgroup_id);
        $html_list = '';
        if ($subject_list) {
            $idx = 1;
            foreach ($subject_list as $row) {
                $html_list .= '<tr>';
                $html_list .= '     <td class="first" align="center">' . $idx . '</td>';
                $html_list .= '     <td>' . $row['subject_name'] . '</td>';
                $html_list .= '     <td>' . $row['employess_name'] . '</td>';
                $html_list .= '     <td>-</td>';
                $html_list .= '     <td>-</td>';
                $html_list .= '</tr>';
                $idx++;
            }
        } else {
            $html_list .= '<tr>
                                <td class="first" colspan="3">
                                    <div class="information-box">
                                        Data tidak ditemukan
                                    </div>
                                </td>
                            </tr>';
        }
        echo json_encode($html_list);
    }

    public function readEskul($classgroup_id = 0) {
        $subject_list = $this->model->selectSubjectByClassGroup($classgroup_id);
        $html_list = '';
        if ($subject_list) {
            $idx = 1;
            foreach ($subject_list as $row) {
                $html_list .= '<tr>';
                $html_list .= '     <td class="first" align="center">' . $idx . '</td>';
                $html_list .= '     <td>' . $row['subject_name'] . '</td>';
                $html_list .= '     <td>' . $row['employess_name'] . '</td>';
                $html_list .= '     <td>-</td>';
                $html_list .= '     <td>-</td>';
                $html_list .= '</tr>';
                $idx++;
            }
        } else {
            $html_list .= '<tr>
                                <td class="first" colspan="3">
                                    <div class="information-box">
                                        Data tidak ditemukan
                                    </div>
                                </td>
                            </tr>';
        }
        echo json_encode($html_list);
    }

}