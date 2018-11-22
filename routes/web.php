<?php
// frontend app
$router->get('/', 'AppController@index');
$router->get('/certificate/{first_name}/{last_name}/{code}', 'AppController@index');
$router->get('/public_certificates/{first_name}/{last_name}', 'AppController@index');

// backend
$router->get('/api/public_certificates/{platform_id}/{user_id}', 'ApiController@publicCertificates');
$router->get('/api/certificate/{first_name}/{last_name}/{code}', 'ApiController@get');
$router->post('/api/certificate', 'ApiController@store');
$router->patch('/api/certificate/{certificate_id}', 'ApiController@update');

$router->get('/qrcode', 'QRCodeController@render');