<?php
  return [
    'base_url' => '/htdocs/', #please do only add subfolders
    '' => [
      'GET' =>'/test/IndexController::index'
    ],
    'authenticate' => [
      'POST' => 'AuthenticationController::new',
      'PUT' => 'AuthenticationController::login'
    ],
    'profile' => [
      'GET' => 'ProfileController::view'  
    ]
  ];
?>
