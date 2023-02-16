<?php

namespace App\Http\Handlers;

use App\Http\Response\Response;
use JetBrains\PhpStorm\NoReturn;

class ResponseHandler {

    protected Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    #[NoReturn]
     public function handle(): void {
        foreach ($this->response->getHeaders() as $name =>  $value) {
            header($this->response->getHeaderLine($name));
        }
        http_response_code($this->response->getStatusCode());
        echo json_encode($this->response->getBody());
    }

}
