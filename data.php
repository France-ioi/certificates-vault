<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$request = json_decode(file_get_contents('php://input'), true);

function getCertificate($request) {
    if($request['code'] == 'ok') {
        return ['success' => true, 'data' => [
            'certificateName' => 'Test certificate',
            'certificateDescription' => 'Nullam nulla mauris, dapibus a nulla ac, malesuada tempus augue. Aenean mattis lobortis luctus. Fusce tristique nisi id tempor ullamcorper. Aliquam aliquet neque est, convallis euismod lectus sollicitudin non. Nam posuere facilisis pretium. Maecenas eros nulla, tempus posuere consectetur ut, aliquam nec felis. Sed dignissim, nibh id suscipit porta, ipsum massa fringilla magna, gravida hendrerit enim tortor sed felis. Etiam id mi vehicula, faucibus felis ac, sollicitudin nulla. Etiam congue ultricies ex et porta. Suspendisse quis lorem malesuada, fermentum est ac, gravida ligula. Aenean vel massa luctus urna scelerisque pharetra. Nam nec lacus massa. Nulla ligula metus, consectetur sit amet dui a, ultricies dictum velit. Proin finibus mi ac hendrerit posuere. Nullam tincidunt ut arcu vel blandit.',
            'public' => true,
            'viewLatest' => true,
            'verificationCode' => '57684902',
            'generationDate' => date("Y-m-d H:i:s"),
            'views' => 532,
            'items' => [
                ['name' => 'Testskill 1', 'description' => 'malesuada tempus augue', 'type' => 'SKILL', 'rate' => 100, 'presence' => true, 'children' => [
                    ['name' => 'Testactivity 1', 'description' => 'malesuada tempus augue', 'type' => 'ACTIVITY', 'rate' => null, 'presence' => null, 'children' => []],
                    ['name' => 'Testactivity 2', 'description' => 'malesuada tempus augue', 'type' => 'ACTIVITY', 'rate' => null, 'presence' => null, 'children' => []],
                    ['name' => 'Testactivity 3', 'description' => 'malesuada tempus augue', 'type' => 'ACTIVITY', 'rate' => null, 'presence' => null, 'children' => []]
                ]],
                ['name' => 'Testskill 2', 'description' => 'malesuada tempus augue', 'type' => 'SKILL', 'rate' => 89, 'presence' => false, 'children' => []],
                ['name' => 'Testskill 3', 'description' => 'malesuada tempus augue', 'type' => 'SKILL', 'rate' => 100, 'presence' => false, 'children' => [
                    ['name' => 'Testactivity 4', 'description' => 'malesuada tempus augue', 'type' => 'ACTIVITY', 'rate' => null, 'presence' => null, 'children' => []]
                ]]
                ]
            ]];
    }
    return ['success' => false];
}

if($request['action'] == 'getCertificate') {    
    die(json_encode(getCertificate($request)));
}
