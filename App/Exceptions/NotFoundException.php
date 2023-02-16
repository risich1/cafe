<?php

namespace App\Exceptions;

use App\Http\Response\Response;
use Exception;

class NotFoundException extends Exception {
    protected $message = 'Not Found';
    protected $code = Response::HTTP_NOT_FOUND_CODE;
}
