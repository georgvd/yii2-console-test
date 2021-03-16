<?php

namespace app\services;

use app\dtos\ComplexDto;

/**
 * Class ComplexService
 * Математические операции над комплексными числами
 * @package app\services
 */
class ComplexService
{
    /**
     * Сложение комплексных чисел
     * @param ComplexDto $first
     * @param ComplexDto $second
     * @return ComplexDto
     */
    public function sum(ComplexDto $first, ComplexDto $second): ComplexDto
    {
        $result = new ComplexDto();
        $result->a = $first->a + $second->a;
        $result->b = $first->b + $second->b;

        return $result;
    }

    /**
     * Вычитание комплексных чисел
     * @param ComplexDto $first
     * @param ComplexDto $second
     * @return ComplexDto
     */
    public function sub(ComplexDto $first, ComplexDto $second): ComplexDto
    {
        $result = new ComplexDto();
        $result->a = $first->a - $second->a;
        $result->b = $first->b - $second->b;

        return $result;
    }

    /**
     * Умножение комплексных чисел
     * @param ComplexDto $first
     * @param ComplexDto $second
     * @return ComplexDto
     */
    public function mul(ComplexDto $first, ComplexDto $second): ComplexDto
    {
        $result = new ComplexDto();
        $result->a = $first->a * $second->a - $first->b * $second->b;
        $result->b = $first->a * $second->b + $second->a * $first->b;

        return $result;
    }

    /**
     * Деление комплексных чисел
     * @param ComplexDto $first
     * @param ComplexDto $second
     * @return ComplexDto
     */
    public function div(ComplexDto $first, ComplexDto $second): ComplexDto
    {
        $result = new ComplexDto();
        $result->a = ($first->a * $second->a + $first->b * $second->b) / ($second->a * $second->a + $second->b * $second->b);
        $result->b = ($second->a * $first->b + $first->a * $second->b) / ($second->a * $second->a + $second->b * $second->b);

        return $result;
    }
}