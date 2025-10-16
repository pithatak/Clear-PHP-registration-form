<?php
declare(strict_types=1);

namespace App\Core;

class Request
{
    public function __construct(
        private array $get = [],
        private array $post = [],
        private array $server = []
    ) {}

    public function getPost(): array
    {
        return $this->post;
    }

    public function getQuery(): array
    {
        return $this->get;
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function path(): string
    {
        return strtok($this->server['REQUEST_URI'] ?? '/', '?');
    }
}