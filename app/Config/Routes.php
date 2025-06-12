<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/lihatdata', 'DataController::index');
$routes->get('/ktp', 'Ktp::index');
$routes->get('/input', 'PesanController::input');
$routes->get('/proses', 'PesanController::proses');
$routes->get('/ktm', 'Ktm::index');
$routes->post('/proses_mahasiswa', 'MahasiswaController::proses_mahasiswa');
$routes->get('/buku', 'BukuController::index');
$routes->get('/mahasiswa', 'MahasiswaController::index');
$routes->get('asisten', 'AsistenController::index');

$routes->get('inputMahasiswa', 'MahasiswaController::toInputMahasiswa');
$routes->post('submitMahasiswa', 'MahasiswaController::submitMahasiswa');
$routes->get('updateMahasiswa', 'MahasiswaController::updateMahasiswa');
$routes->get('deleteMahasiswa', 'MahasiswaController::deleteMahasiswa');

$routes->match(['get', 'post'], '/asisten/simpan', 'AsistenController::simpan');
$routes->get('updateAsistenForm', 'AsistenController::updateAsistenForm');
$routes->post('updateAsisten', 'AsistenController::updateAsisten');
$routes->get('deleteAsistenForm', 'AsistenController::deleteAsistenForm');
$routes->post('deleteAsisten', 'AsistenController::deleteAsisten');

$routes->get('/', 'PasienController::index');
$routes->get('pasien', 'PasienController::index');
$routes->post('pasien/simpan', 'PasienController::simpan');
$routes->get('pasien/hapus/(:num)', 'PasienController::hapus/$1');



$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::processRegister');
$routes->get('login',    'AuthController::login');
$routes->post('login',   'AuthController::processLogin');
$routes->get('logout',   'AuthController::logout');

// Route Top Up
$routes->get('topup',                 'TopupController::purchase');
$routes->post('topup/processPurchase',        'TopupController::processPurchase');
$routes->get('topup/confirm-transfer','TopupController::confirmTransfer');  // ← PENTING
$routes->get('topup/upload-bukti',       'TopupController::uploadBuktiForm');
$routes->post('topup/upload-bukti/process','TopupController::uploadBuktiProcess');




$routes->get('cart',             'CartController::index');
$routes->post('cart/add',        'CartController::add');
$routes->post('cart/update/(:num)', 'CartController::update/$1');
$routes->get('cart/checkout',    'CartController::checkout');


$routes->get('transactions',         'TransactionController::index');
$routes->get('transaction/detail/(:num)', 'TransactionController::detail/$1');



 