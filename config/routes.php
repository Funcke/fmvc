<?php
  require_once('controller/IndexController.php');
  return [
    '' => [
      'GET' =>'IndexController::index',
      'POST' => 'IndexController::create'
    ],
    'create' => [
      'POST' => 'IndexController::create'
    ]
  ];
?>
