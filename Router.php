<?php

Web::$host = $_SERVER['SERVER_NAME']; //'warmansuganda.com';
//echo md5($_SERVER['SERVER_NAME']);
switch (Web::getSubDomain()) {
    case 'www':
        Web::main('SMPN 1 SUBANG', 'main', 'elegant');
        Web::child('ADMIN SMPN 1 SUBANG', 'admin_main', 'demo');
        break;
    case 'meshplace':
        Web::main('Meshplace SMPN 1 Subang', 'myschool', 'orangestrip');
        //Web::child('ONLINE SCORE', 'nilaionline', 'nilaionline', 'orangestrip');
        Web::child('Nilai Online V.1', 'nilaionline', 'nilaionline_v1', 'orangestrip');
        break;
    case 'akademik':
        Web::main('AKADEMIK SMPN 1 SUBANG', 'akademik', 'demo');
        break;
    case 'komite':
        Web::main('SMPN 1 SUBANG', 'absensi', 'demo');
        break;
    case 'digilib':
        Web::main('DIGITAL LIBRARY', 'digilib', 'demo');
        Web::child('OPERATOR DIGITAL LIBRARY', 'admin', 'digilib_admin', 'demo');
        break;
    case 'absen':
        Web::main('ABSENSI SMPN 1 SUBANG', 'attendance', 'demo');
        break;
    case 'hots':
        Web::main('HOTS SPENSA', 'hots', 'wbfashion');
        Web::child('HOTS ADMINISTRATOR', 'admin', 'hots_master', 'demo');
        break;
    case 'demo':
        Web::main('DIGITAL LIBRARY', 'demo', 'demo');
        Web::child('ADMIN DIGITAL LIBRARY', 'admin_digilib', 'demo');
        break;
    default:
        Web::main('DEMO', 'demo', 'demo');
        Web::child('Admin E-Commerce Portal', 'demo', 'demo');
        break;
}

