<?php

namespace app\dtos\utils;

use app\dtos\ComplexDto;

class ComplexDtos
{
    public static function from(float $a, float $b): ComplexDto
    {
        $complexDto = new ComplexDto();
        $complexDto->a = $a;
        $complexDto->b = $b;

        return $complexDto;
    }
}