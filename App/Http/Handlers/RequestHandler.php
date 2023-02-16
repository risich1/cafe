<?php

namespace App\Http\Handlers;

use App\Http\Handlers\Middleware\Middleware;
use App\Http\Request\Request;
use App\Http\Response\Response;
use App\Interface\IRequest;

class RequestHandler {

    private $callable;
    private array $params;

    public function __construct(callable $callable, array $params = []) {
        $this->callable = $callable;
        $this->params = $params;
    }

    public function handle(Request $request): Response {
        try {
            $request->validate();
            return ($this->callable)($request, ...$this->params);
        } catch (\Exception $e) {
            $status = in_array($e->getCode(), Response::getStatuses()) ? $e->getCode() : Response::HTTP_SERVER_ERROR_CODE;
            return new Response(['error' => $e->getMessage()], [], $status);
        }
    }

}
