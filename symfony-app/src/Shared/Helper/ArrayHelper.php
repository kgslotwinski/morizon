<?php

namespace App\Shared\Helper;

final readonly class ArrayHelper
{
    public static function keysToSnakeCase(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $snakeKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));
            $result[$snakeKey] = $value;
        }
        return array_filter($result, fn ($v) => $v !== null && $v !== '');
    }
}