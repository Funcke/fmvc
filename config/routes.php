<?php
  return [
    'base_url' => '/', #please do only add subfolders
    'authenticate' => [
      'GET' => [
        "controller" => 'SessionController::create',
        "middleware" => [],
        "validation" => []
      ],
      'POST' => [
        "controller" => 'SessionController::login'
      ],
      'PUT' => [
        "controller" => 'SessionController::login'
      ]
    ],
    'authenticate/logout' => [
      'GET' => [
        "controller" => 'SessionController::logout'
      ]
    ],
  ];
