<?php
    // register Middleware function with ClassName::Method
    return [
        'all' => [],
        'profile' => [
            'Middleware::CheckLogin'    
        ],
        '/profile/edit' => [
            'Middelware::CkeckLogin'    
        ],
        '/profile/update' => [
            'Middleware::CheckLogin'    
        ],
        '/profile/follow' => [
            'Middleware::CheckLogin'   
        ]
    ];
?>