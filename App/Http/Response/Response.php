<?php

namespace App\Http\Response;

class Response {

    const HTTP_CREATED_CODE = 201,
          HTTP_NOT_FOUND_CODE = 404,
          HTTP_BAD_REQUEST = 400,
          HTTP_NOT_ALLOWED = 403,
          HTTP_UNAUTHORIZED_CODE = 401,
          HTTP_TOO_MANY_REQUESTS_CODE = 429,
          HTTP_METHOD_NOT_ALLOWED_CODE = 405,
          HTTP_SERVER_ERROR_CODE = 500,
          HTTP_SUCCESS_CODE = 200;

    protected int $statusCode;
    protected array $headers = [
        "Content-Type" => "application/json; charset=utf-8"
    ];

    protected array|\stdClass $body = [];

    public function __construct(array|\stdClass|string $body = [], array $headers = [], int $statusCode = self::HTTP_SUCCESS_CODE)
    {
        $this->statusCode = $statusCode;
        if ($headers) $this->headers = $headers;

        if ($body) $this->body = is_string($body) ? ['message' => $body] : $body;
    }

    public static function getStatuses(): array {
        return [
            self::HTTP_CREATED_CODE,
            self::HTTP_NOT_FOUND_CODE,
            self::HTTP_BAD_REQUEST,
            self::HTTP_UNAUTHORIZED_CODE,
            self::HTTP_TOO_MANY_REQUESTS_CODE,
            self::HTTP_METHOD_NOT_ALLOWED_CODE,
            self::HTTP_SERVER_ERROR_CODE,
            self::HTTP_SUCCESS_CODE,
            self::HTTP_NOT_ALLOWED
        ];
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader($name): bool
    {
        return isset($this->headers[$name]);
    }

    public function getHeader($name): string
    {
        return $this->headers[$name];
    }

    public function getHeaderLine($name): string
    {
        return $name . ": " . $this->headers[$name];
    }

    public function withHeader($name, $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

}
