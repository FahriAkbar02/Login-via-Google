<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */ $routes->get('/', 'Home::index');
$routes->get('/login', 'UserController::showLoginForm');
$routes->post('user/register', 'UserController::register'); // route untuk memproses form register
$routes->get('login/proses', 'UserController::proses');
$routes->get('logout', 'UserController::logout');
$routes->get('tentang', 'Home::tentang');
$routes->get('notifications', 'NotificationController::index');
$routes->get('daftar_tugas/(:num)', 'NotificationController::listAssign/$1');
$routes->get('tentang', 'Home::tentang');
// Routes for other pages

$routes->get('course/', 'CourseController::index');
$routes->get('/course/create_course', 'CourseController::create');
$routes->post('/course/store_course', 'CourseController::store');
$routes->get('/course/edit_course/(:num)', 'CourseController::edit/$1');
$routes->post('course/update_course/(:num)', 'CourseController::update/$1');
$routes->get('/course/delete_course/(:num)', 'CourseController::delete/$1');
$routes->get('/course/detail_course/(:num)', 'CourseController::detail/$1');
$routes->get('course/userCourses', 'CourseController::index');
$routes->get('course/userCourses/(:num)', 'CourseController::userCourses/$1');
$routes->get('/course/share_course/(:any)', 'CourseController::share/$1');

$routes->post('/course/join_course', 'CourseController::join');
$routes->get('/course/join_course', 'CourseController::showJoinForm');


// Contoh pemanggilan fungsi create dari rute
$routes->get('assignments/create_assignments/(:num)/(:num)', 'AssignmentController::create/$1/$2');
$routes->post('/assignments/store_assignments', 'AssignmentController::store');
$routes->get('assignments/edit_assignments/(:num)', 'AssignmentController::edit/$1');
$routes->post('assignments/update_assignments/(:num)', 'AssignmentController::update/$1');
$routes->get('assignments/delete_assignments/(:num)', 'AssignmentController::delete/$1');

$routes->get('/submissions', 'SubmissionsController::index');
$routes->get('/submissions/daftar_userSubmissions/(:num)', 'SubmissionsController::index/$1');
$routes->get('/submissions/create_submissions/(:num)', 'SubmissionsController::create/$1');
$routes->get('/submissions/edit_submissions/(:num)', 'SubmissionsController::edit/$1');
$routes->get('/submissions/delete_submissions/(:num)', 'SubmissionsController::delete/$1');
$routes->post('/submissions/store_assignments', 'SubmissionsController::store');
$routes->post('submissions/update_submissions/(:num)', 'SubmissionsController::update/$1');

 // Menangani aksi join kursus sebagai POST request