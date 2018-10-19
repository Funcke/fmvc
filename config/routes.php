<?php
  require_once('controller/IndexController.php');
  return [
    'base_url' => '/',
    '' => [
      'GET' =>'IndexController::index',
      'POST' => 'IndexController::create'
    ],
    'create' => [
      'POST' => 'IndexController::create'
    ],
    'json' => [
      'GET' => 'IndexController::iJson'
    ]
  ];
?>
