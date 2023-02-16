<?php

namespace App\Http\Request;

class PopularCooksRequest extends Request {
    protected array $requireBodyFields = [
      'date1', 'date2'
    ];
}
