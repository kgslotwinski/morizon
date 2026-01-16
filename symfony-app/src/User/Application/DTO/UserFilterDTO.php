<?php

namespace App\User\Application\DTO;

use App\Shared\Domain\Enum\Gender;
use Symfony\Component\Validator\Constraints as Assert;

final class UserFilterDTO
{
    private ?string $firstName = null;
    private ?string $lastName = null;
    #[Assert\Choice(callback: [Gender::class, 'values'])]
    private ?string $gender = null;
    #[Assert\Type(\DateTimeImmutable::class)]
    private ?\DateTimeInterface $birthdateFrom = null;
    #[Assert\Type(\DateTimeImmutable::class)]
    private ?\DateTimeInterface $birthdateTo = null;
    #[Assert\Choice(choices: ['first_name', 'last_name', 'gender', 'birthdate', 'id'])]
    private ?string $sort = null;
    #[Assert\Choice(choices: ['asc', 'desc'])]
    private ?string $sortDirection = null;

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

    public function getBirthdateFrom(): ?\DateTimeInterface
    {
        return $this->birthdateFrom;
    }

    public function setBirthdateFrom(?\DateTimeInterface $birthdateFrom): self
    {
        $this->birthdateFrom = $birthdateFrom;
        return $this;
    }

    public function getBirthdateTo(): ?\DateTimeInterface
    {
        return $this->birthdateTo;
    }

    public function setBirthdateTo(?\DateTimeInterface $birthdateTo): self
    {
        $this->birthdateTo = $birthdateTo;
        return $this;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(?string $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    public function getSortDirection(): ?string
    {
        return $this->sortDirection;
    }

    public function setSortDirection(?string $sortDirection): self
    {
        $this->sortDirection = $sortDirection;
        return $this;
    }

    public function toArray(): array
    {
        $array = [];

        if ($this->firstName !== null && $this->firstName !== '') {
            $array['firstName'] = $this->firstName;
        }

        if ($this->lastName !== null && $this->lastName !== '') {
            $array['lastName'] = $this->lastName;
        }

        if ($this->gender !== null && $this->gender !== '') {
            $array['gender'] = $this->gender;
        }

        if ($this->birthdateFrom !== null) {
            $array['birthdateFrom'] = $this->birthdateFrom->format('Y-m-d');
        }

        if ($this->birthdateTo !== null) {
            $array['birthdateTo'] = $this->birthdateTo->format('Y-m-d');
        }

        if ($this->sort !== null && $this->sort !== '') {
            $array['sort'] = $this->sort;
        }

        if ($this->sortDirection !== null && $this->sortDirection !== '') {
            $array['sortDirection'] = $this->sortDirection;
        }

        return $array;
    }
}