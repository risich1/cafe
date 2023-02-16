<?php

namespace App\Exceptions;

use App\Http\Response\Response;
use Exception;

class BadRequestException extends Exception {
    protected $code = Response::HTTP_BAD_REQUEST;
}
