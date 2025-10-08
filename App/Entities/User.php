<?php
declare(strict_types=1);

namespace App\Entities;

class User
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $passwordHash;
    private ?int $id;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $phone,
        string $passwordHash,
        ?int   $id = null,
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->passwordHash = $passwordHash;

        if ($id !== null) {
            $this->id = $id;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}