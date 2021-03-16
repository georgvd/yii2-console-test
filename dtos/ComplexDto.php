<?php

namespace app\dtos;

class ComplexDto
{
    /**
     * Действительная часть числа
     * @var float
     */
    public float $a;

    /**
     * Мнимая часть числа
     * @var float
     */
    public float $b;
}