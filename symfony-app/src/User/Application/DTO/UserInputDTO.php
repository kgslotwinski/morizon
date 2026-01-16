<?php

namespace App\User\Application\DTO;

use App\Shared\Domain\Enum\Gender;
use App\Shared\Domain\Model\User;
use Symfony\Component\Validator\Constraints as Assert;

final class UserInputDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $firstName = null;
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $lastName = null;
    #[Assert\NotNull]
    #[Assert\Choice(callback: [Gender::class, 'values'])]
    private ?string $gender = null;
    #[Assert\NotNull]
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Assert\LessThanOrEqual('today')]
    private ?\DateTimeImmutable $birthdate = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeImmutable $birthdate): self
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    public static function fromUser(User $user): self
    {
        return (new self())
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName())
            ->setGender($user->getGender()->value)
            ->setBirthdate($user->getBirthdate());
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate->format('Y-m-d'),
        ];
    }
}
