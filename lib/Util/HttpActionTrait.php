<?php

namespace FMVC\Util;

use Serializable;

trait HttpActionTrait {
    public function Ok(Serializable $responseBody = NULL) 
    {
        http_response_code(200);
        return $responseBody->serialize() ?? '' ;
    }
    
    public function Created(Serializable $responseBody = NULL)
    {
        http_response_code(201);
        return $responseBody->serialize() ?? '';
    }

    public function Accepted(Serializable $responseBody = NULL)
    {
        http_response_code(202);
        return $responseBody->serialize() ?? '';
    }
    
    public function NoContent() 
    {
        http_response_code(204);
        return '';
    }

    public function BadRequest(Serializable $responseBody = NULL)
    {
        return PageUtils::renderErrorPage(
            array(
                'code' => 400,
                'message' => $responseBody->serialize ?? 'Bad Request'
            )
        );
    }
    
    public function NotFound(Serializable $responseBody = NULL)
    {
        return PageUtils::renderErrorPage(
            array(
                'code' => 404,
                'message' => $responseBody->serialize() ?? 'Not Found'
            )
        );
    }

    public function Teapot()
    {
        http_response_code(418);
        return 'I am a teapot';
    }
}