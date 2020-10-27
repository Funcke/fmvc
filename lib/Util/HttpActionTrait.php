<?php

namespace FMVC\Util;

trait HttpActionTrait {
    public function Ok($responseBody = '') 
    {
        http_response_code(200);
        return $responseBody;
    }
    
    public function Created($responseBody = '')
    {
        http_response_code(201);
        return $responseBody;
    }

    public function Accepted($responseBody = '')
    {
        http_response_code(202);
        return $responseBody;
    }
    
    public function NoContent() 
    {
        http_response_code(204);
        return '';
    }

    public function BadRequest($responseBody = 'Bad Request')
    {
        return PageUtils::renderErrorPage(
            array(
                'code' => 400,
                'message' => $responseBody
            )
        );
    }
    
    public function NotFound($responseBody = 'Not Found')
    {
        return PageUtils::renderErrorPage(
            array(
                'code' => 404,
                'message' => $responseBody
            )
        );
    }

    public function Teapot()
    {
        http_response_code(418);
        return 'I am a teapot';
    }
}