<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->get('/', 'Payrollsession::getList');
//$routes->post('login', 'CustomLoginController::login');
// $routes->get('/', function() {
//     return redirect()->to('/login');
// });
$routes->get('/', function () {
    return redirect()->to(site_url('login'));
});

service('auth')->routes($routes);
