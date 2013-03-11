<?php

class Contents extends Controller {

    public function __construct() {
        $this->model = Content::loadModel();
        $this->url = new URL();
        Session::init();
    }

    public function accessRight() {
        Session::init();
        if (!Session::get('login_status')) {
            Session::destroy();
            $url = $this->setLink('index');
            $this->url->redirect($url);
            exit;
        }
    }

    public function setLink($val = '', $ssl = false) {

        if (Web::$childStatus) {
            $house = Web::$host . '/' . Web::$webAlias;
        } else {
            $house = Web::$host;
        }

        $protocol = 'http://';
        if ($ssl) {
            $protocol = 'https://';
        }
        $link = $protocol . $house . '/' . $val;
        if ($val == '#') {
            $link = '#';
        }
        return $link;
    }

    public function numberFormat($number = 0) {
        return number_format($number, 0, ',', '.');
    }

    public function getMonthList($lang) {
        $month = array(
            'ina' => array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
            'eng' => array('January', 'February', 'Mart', 'April', 'May', 'Juny', 'July', 'Agust', 'September', 'October', 'November', 'Desember')
        );
        return $month[$lang];
    }

    public function getYearsList($start, $end) {
        $list = array();

        if ($start >= $end) {
            for ($start; $start >= $end; $start--) {
                $list[$start] = $start;
            }
        } else {
            for ($start; $start <= $end; $start++) {
                $list[$start] = $start;
            }
        }

        return $list;
    }

    public function getMonthName($idx, $lang) {
        $month = array(
            'ina' => array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
            'eng' => array('January', 'February', 'Mart', 'April', 'May', 'Juny', 'July', 'Agust', 'September', 'October', 'November', 'Desember')
        );
        return $month[$lang][$idx - 1];
    }

    public function getDayName($date, $lang) {
        $day = date('w', strtotime($date));
        $dayname = array(
            'ina' => array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')
        );
        return $dayname[$lang][$day];
    }

    public function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public function pasingCheckTime($nameid, $sdate, $fdate) {
        $checktime = $this->model->selectAllCheckTime($nameid, $sdate, $fdate);
        $checkinout = array();
        foreach ($checktime as $value) {
            // Keterangan : $checkinout['USERID']['TANGGAL']['INDEX'] = 'JAM'
            $checkinout[$value['USERID']][date('m/d/Y', strtotime($value['CHECKTIME']))][] = date('H:i', strtotime($value['CHECKTIME']));
        }
        return $checkinout;
    }

    public function parsingDateList($begin, $end) {
        $dateList = array();
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        foreach ($daterange as $date) {
            $dateList[] = $date->format('m/d/Y');
        }
        return $dateList;
    }

    public function parsingListView($listData, $dateList, $checkInOut, $userSpeday, $holidays) {
        $listView = array();
        foreach ($listData as $row) {

            foreach ($dateList as $dList) {

                // START : Set Clock In / Clock Out
                $clockin = '-';
                $clockout = '-';
                if (isset($checkInOut[$row['USERID']][$dList])) {
                    $time = $checkInOut[$row['USERID']][$dList];
                    $timecount = count($time);
                    if ($timecount > 0) {
                        sort($time);
                        $clockfirst = $time[0];
                        $clocklast = $time[$timecount - 1];

                        if ($clockfirst >= date('H:i', strtotime(substr($row['CHECKINTIME1'], -8, 8))) && $clockfirst <= date('H:i', strtotime(substr($row['CHECKINTIME2'], -8, 8)))) {
                            $clockin = $clockfirst;
                        }

                        if ($clocklast >= date('H:i', strtotime(substr($row['CHECKOUTTIME1'], -8, 8))) && $clocklast <= date('H:i', strtotime(substr($row['CHECKOUTTIME2'], -8, 8)))) {
                            $clockout = $clocklast;
                        }
                    }
                }

                if (isset($holidays[$dList])) {// Cek hari libur
                    $descUserSpeday = $holidays[$dList];
                    $note = 'Libur';
                    $style = 'style="color:#d500cd;"';
                } else {
                    if ($clockin == '-' && $clockout == '-') { // Cek List Jam datang dan pulang
                        // User Speday
                        if (isset($userSpeday[$row['USERID']][$dList][0])) {
                            $dataUserSpeday = $userSpeday[$row['USERID']][$dList][0]; //implode(',', $userSpeday[$row['USERID']][$dList]);
                            $descUserSpeday = $dataUserSpeday['reaseon'];
                            $note = $dataUserSpeday['desc'];

                            if ($dataUserSpeday['id'] == 1) {
                                $style = 'style="color:green;"';
                            } else {
                                $style = 'style="color:blue;"';
                            }
                        } else {
                            $descUserSpeday = '';
                            $note = 'Tanpa Keterangan';
                            $style = 'style="color:red;"';
                        }
                    } else {
                        $descUserSpeday = '';
                        $note = '';
                        $style = 'style="color:black;"';
                    }
                }

                // END : Set Clock In / Clock Out

                $ssn = '-';
                if (!empty($row['SSN'])) {
                    $ssn = $row['SSN'];
                }

                $CardNo = '-';
                if (!empty($row['CardNo'])) {
                    $CardNo = $row['CardNo'];
                }

                $gender = "Perempuan";
                if ($row['Gender'] == 'Male')
                    $gender = "Laki-Laki";


                $listView[] = array(
                    'USERID' => $row['USERID'],
                    'SSN' => $ssn,
                    'CardNo' => $CardNo,
                    'Name' => $row['Name'],
                    'Gender' => $gender,
                    'DateList' => $dList,
                    'ClockIn' => $clockin,
                    'ClockOut' => $clockout,
                    'Note' => $note,
                    'Style' => $style,
                    'USER_SPEDAY' => $descUserSpeday
                );
            }
        }

        return $listView;
    }

    public function parsingSpeday($nameid, $sdate, $fdate) {
        $spedayList = $this->model->selectSpeday($nameid, $sdate, $fdate);
        $userSpeday = array();
        foreach ($spedayList as $row_sd) {
            $s = new DateTime(date('Y-m-d', strtotime($row_sd['STARTSPECDAY'])));
            $e_temp = new DateTime(date('Y-m-d', strtotime($row_sd['ENDSPECDAY'])));
            $e = $e_temp->modify('+1 day');

            foreach ($this->parsingDateList($s, $e) as $row_d) {
                $userSpeday[$row_sd['USERID']][$row_d][] = array('id' => $row_sd['DATEID'], 'desc' => $row_sd['LEAVENAME'], 'reaseon' => $row_sd['YUANYING']);
            }
        }
        return $userSpeday;
    }

    public function parsingHolidays($sdate, $fdate) {
        $holidayList = $this->model->selectHolidays($sdate, $fdate);
        $holidays = array();
        foreach ($holidayList as $row_sd) {
            $s = new DateTime(date('Y-m-d', strtotime($row_sd['STARTTIME'])));
            $e_temp = new DateTime(date('Y-m-d', strtotime($row_sd['ENDTIME'])));
            $e = $e_temp->modify('+1 day');

            foreach ($this->parsingDateList($s, $e) as $row_d) {
                $holidays[$row_d] = $row_sd['HOLIDAYNAME'];
            }
        }
        return $holidays;
    }

    public function optionName($deptId = 0) {
        $list = $this->model->selectUserByDeptId($deptId);
        $name = array();
        $idx = 1;
        foreach ($list as $value) {
            $name[$value['USERID']] = $value['Name'];
            $idx++;
        }
        return $name;
    }

    public function optionDescription() {
        $list = $this->model->selectDescription();
        $name = array();
        $idx = 1;
        foreach ($list as $value) {
            $name[$value['LEAVEID']] = $value['LEAVENAME'];
            $idx++;
        }
        return $name;
    }

    public function getUserInfo($nameid) {
        return $this->model->selectUserInfo($nameid);
    }

}