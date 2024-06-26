<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('create-db', function () {
    $forge = \Config\Database::forge();
    if ($forge->createDatabase('gorca')) {
        echo 'Database created!';
    }
});

$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->get('register', 'Auth::register');
// $routes->addRedirect('/', 'Home::index');

$routes->get('user', 'User::index');
$routes->get('admin', 'Mdadmin::dashboard');

$routes->get('lapangan_user', 'User::lapangan_user', ['filter' => 'isLoggedIn']);
$routes->get('booking/(:any)', 'User::booking/$1', ['filter' => 'isLoggedIn']);
$routes->get('proses_sewa', 'User::proses_sewa', ['filter' => 'isLoggedIn']);

$routes->get('detail_transaksi', 'User::detail_transaksi', ['filter' => 'isLoggedIn']);
$routes->get('informasi', 'User::informasi', ['filter' => 'isLoggedIn']);
$routes->get('proses_simpan', 'User::proses_simpan', ['filter' => 'isLoggedIn']);
$routes->post('proses_pembayaran', 'User::proses_pembayaran', ['filter' => 'isLoggedIn']);

//Presenter routes
$routes->presenter('mdadmin');
$routes->presenter('mdusers', ['filter' => 'isLoggedIn']);
$routes->presenter('mdlapangan');
$routes->presenter('mdjadwal', ['filter' => 'isLoggedIn']);
$routes->presenter('laporan', ['filter' => 'isLoggedIn']);
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
