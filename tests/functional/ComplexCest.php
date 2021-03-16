<?php

namespace functional;

use app\dtos\utils\ComplexDtos;
use app\services\ComplexService;
use FunctionalTester;

class ComplexCest
{
    public function testSum(FunctionalTester $I, ComplexService $service)
    {
        $first = ComplexDtos::from(1, 2);
        $second = ComplexDtos::from(3, 4);

        $result = $service->sum($first, $second);
        $I->assertEquals(4, $result->a);
        $I->assertEquals(6, $result->b);
    }

    public function testSub(FunctionalTester $I, ComplexService $service)
    {
        $first = ComplexDtos::from(1, 2);
        $second = ComplexDtos::from(3, 4);

        $result = $service->sub($first, $second);
        $I->assertEquals(-2, $result->a);
        $I->assertEquals(-2, $result->b);
    }

    public function testMul(FunctionalTester $I, ComplexService $service)
    {
        $first = ComplexDtos::from(1, 2);
        $second = ComplexDtos::from(3, 4);

        $result = $service->mul($first, $second);
        $I->assertEquals(-5, $result->a);
        $I->assertEquals(10, $result->b);
    }

    public function testDiv(FunctionalTester $I, ComplexService $service)
    {
        $first = ComplexDtos::from(1, 2);
        $second = ComplexDtos::from(3, 4);

        $result = $service->div($first, $second);
        $I->assertEquals((3 + 8) / (9 + 16), $result->a);
        $I->assertEquals((6 + 4) / (9 + 16), $result->b);
    }
}