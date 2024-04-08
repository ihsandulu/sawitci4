<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->add('/', 'utama::login');
$routes->add('/api/(:any)', 'api::$1');
$routes->add('/utama', 'utama::index');
$routes->add('/login', 'utama::login');
$routes->add('/logout', 'utama::logout');
$routes->add('/mposition', 'master\mposition::index');
$routes->add('/mpositionpages', 'master\mpositionpages::index');
$routes->add('/muser', 'master\muser::index');
$routes->add('/muserposition', 'master\muserposition::index');
$routes->add('/mpassword', 'master\mpassword::index');
$routes->add('/midentity', 'master\midentity::index');
$routes->add('/mestate', 'master\mestate::index');
$routes->add('/mdivisi', 'master\mdivisi::index');
$routes->add('/mseksi', 'master\mseksi::index');
$routes->add('/mblok', 'master\mblok::index');
$routes->add('/mtph', 'master\mtph::index');
$routes->add('/rkh', 'transaction\rkh::index');
$routes->add('/mplacement', 'master\mplacement::index');
$routes->add('/synchron', 'transaction\synchron::index');
$routes->add('/mtphnumber', 'master\mtphnumber::index');
$routes->add('/msptbsnumber', 'master\msptbsnumber::index');
$routes->add('/mgradingtype', 'master\mgradingtype::index');
$routes->add('/grading', 'transaction\grading::index');
$routes->add('/absen', 'transaction\absen::index');
$routes->add('/mwt', 'master\mwt::index');
$routes->add('/mquarrytype', 'master\mquarrytype::index');
$routes->add('/quarry', 'transaction\quarry::index');
