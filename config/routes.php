<?php
  return [
    'base_url' => '/', #please do only add subfolders
    '' => [
      'GET' =>['ProfileController::test', 'ExampleSchema']
    ],
    'authenticate' => [
      'POST' => ['AuthenticationController::new'],
      'PUT' => ['AuthenticationController::login']
    ],
    'profile' => [
      'GET' => ['ProfileController::view']
    ],
      'show' => [
          'GET' => ['ProfileController::showUserStruct']
      ]
  ];