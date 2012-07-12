<?php

Web::$host = $_SERVER['SERVER_NAME']; //'ecp.net';
//echo md5($_SERVER['SERVER_NAME']);
switch (Web::getSubDomain()) {
    case 'www':
        Web::main('SMPN 1 SUBANG', 'main', 'elegant');
        Web::child('ADMIN SMPN 1 SUBANG', 'admin_main', 'demo');
        break;
    case 'digilib':
        Web::main('DIGITAL LIBRARY', 'digilib', 'elegant');
        Web::child('DIGITAL LIBRARY ADMINISTRATION', 'admin', 'digilib_master', 'demo');
        Web::child('OPERATOR DIGITAL LIBRARY', 'operator', 'digilib_master', 'demo');
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

