<?php

namespace App\Shared\Domain\Enum;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function values(): array
    {
        return [
            Gender::MALE->value,
            Gender::FEMALE->value,
        ];
    }
}
