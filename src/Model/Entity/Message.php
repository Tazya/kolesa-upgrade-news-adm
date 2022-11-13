<?php

namespace App\Model\Entity;

class Message
{
    private ?string $title;
    private ?string $message;

    public function __construct($data = [])
    {
        $this->title = $data['title'] ?? null;
        $this->message = $data['message'] ?? null;
    }
    public function getTitle(): string
    {
        return $this->title ?? '';
    }
    public function getMessage(): string
    {
        return $this->message;
    }
    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
        ];
    }
}