<?php

declare(strict_types=1);

namespace Simplicity\Core\Request;

class Request
{
    private readonly HttpMethod $method;
    private readonly array $uriParts;
    private readonly array $query;
    private readonly array $parameters;
    private readonly array $headers;
    private readonly object|null $body;

    public function __construct(
        string $uri,
        HttpMethod $method = HttpMethod::GET,
        array $query = [],
        array $parameters = [],
        array $headers = [],
        object|null $body = null
    ) {
        $this->uriParts = $this->explodeUri($uri);
        $this->method = $method;
        $this->query = $query;
        $this->parameters = $parameters;
        $this->headers = $headers;
        $this->body = $this->parseBody($body);
    }

    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return implode('/', $this->uriParts);
    }

    public function getUriParts(): array
    {
        return $this->uriParts;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getBody(): object|null
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getContentType(): string
    {
        return $this->headers['Content-Type'] ?? 'unknown';
    }

    public function subRequest(): Request
    {
        $uri = implode('/', array_slice($this->uriParts, 1));

        return new Request(
            $uri,
            $this->method,
            $this->query,
            $this->parameters,
            $this->headers,
            $this->body
        );
    }

    private function explodeUri(string $uri): array
    {
        $uri = trim($uri, '/');

        $parts = explode('/', $uri);

        $parts = array_filter($parts, function ($part) {
            return $part !== '';
        });

        return array_values($parts);
    }

    private function parseBody(): object|null
    {
        $body = file_get_contents('php://input');

        if ($body === false) {
            return null;
        }

        $contentType = $this->getContentType();

        switch ($contentType) {
            case 'application/json':
                return json_decode($body);
            case 'application/x-www-form-urlencoded':
                parse_str($body, $parsedBody);
                return (object) $parsedBody;
            default:
                return null;
        }
    }
}
