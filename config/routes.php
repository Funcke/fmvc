<?php
  return [
    'base_url' => '/', #please do only add subfolders
    'authenticate' => [
      'GET' => ['SessionController::create'],
      'POST' => ['SessionController::login'],
      'PUT' => ['SessionController::login']
    ],
    'authenticate/logout' => [
      'GET' => ['SessionController::logout']
    ],
  ];
