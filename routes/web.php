<?php
// frontend app
$router->get('/', 'AppController@index');
$router->get('/certificate/{first_name}/{last_name}/{code}', 'AppController@search');

// backend
$router->get('/public_certificates/{platform_id}/{user_id}', 'ApiController@publicCertificates');
$router->get('/certificates/{first_name}/{last_name}/{code}', 'ApiController@get');
$router->post('/certificates', 'ApiController@store');
$router->patch('/certificates/{certificate_id}', 'ApiController@update');
$router->get('/qrcode', 'QRCodeController@render');