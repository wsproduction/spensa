<?php

class News extends Controller {

    public function __construct() {
        parent::__construct();
        $this->view->hotsSubject = $this->content->hotsSubject();
        Src::plugin()->highChart();
    }
    
    public function index() {
        Web::setTitle('Hots News');
        $this->view->listDataNews = $this->listDataNews();
        $this->view->render('news/index');
    }
    
    public function view($id) {
        Web::setTitle('Hots News');
        $dataNews = $this->model->selectNewsById($id);
        if (count($dataNews)>0){
            $this->view->dataNews = $dataNews[0];
            $this->view->render('news/view');
        }
    }
    
    public function listDataNews($page = 1) {
        $maxRows = 1;
        $countList = $this->model->countAllNews();
        $countPage = ceil($countList / $maxRows);
        $jumlah_kolom = 4;

        $ddcList = $this->model->selectAllNews(($page * $maxRows) - $maxRows, $maxRows);
        $html = '';

        if ($countList > 0) {

            $idx = 1;
            $id = '0';
            foreach ($ddcList as $value) {
                $tmpID = $value['news_id'];
                $id .= ',' . $tmpID;

                $html .= '<div class="box-news">
                            <div class="title">' . $value['news_title'] . '</div>
                            <div>
                                ' . $value['news_content'] . '
                                <div class="cl">&nbsp;</div>
                            </div>
                            <div class="footer">
                                <div class="left">' . date('l, d.m.Y', strtotime($value['news_entry']) ) . ' | Posted by admin</div>
                                <div class="right"><a href="http://' . Web::$host . '/news/view/' . $value['news_id'] . '/' . str_replace(' ', '-', $value['news_title']) . '">Read more</a></div>
                                <div class="cl">&nbsp;</div>
                            </div>
                        </div>';

                $idx++;
            }

            //$html .= $this->content->paging($jumlah_kolom, $countPage, $page);

            Form::create('hidden', 'hiddenID');
            Form::value($id);
            $html .= Form::commit('attach');
        } else {
            $html .= '<tr>';
            $html .= '   <th colspan="' . $jumlah_kolom . '">Data Not Found</th>';
            $html .= '</tr>';
        }
        return $html;
    }

}