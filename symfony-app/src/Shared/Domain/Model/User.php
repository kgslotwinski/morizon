<?php

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Enum\Gender;

final readonly class User
{
    public function __construct(
        private ?int $id,
        private string $firstName,
        private string $lastName,
        private \DateTimeImmutable $birthdate,
        private Gender $gender,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBirthdate(): \DateTimeImmutable
    {
        return $this->birthdate;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['first_name'],
            $data['last_name'],
            new \DateTimeImmutable($data['birthdate']),
            Gender::from($data['gender']),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'birthdate' => $this->birthdate->format('Y-m-d'),
            'gender' => $this->gender->value,
        ];
    }
}
