<?php

namespace functional;

use app\services\configurable\clients\FirstServiceClient;
use app\services\configurable\ConfigService;
use app\services\configurable\ConfigurableInterface;
use FunctionalTester;

class ConfigServiceCest
{
    private const INVALID_NAME = 'INVALID_NAME';
    private const TEST_VALUE = 'TEST_VALUE';

    public function testGetConfigs(FunctionalTester $I, ConfigService $service, FirstServiceClient $client): void
    {
        $result = $service->getConfig($client);
        $I->assertEquals([
                             FirstServiceClient::FIELD_1 => ConfigurableInterface::STRING,
                             FirstServiceClient::FIELD_2 => ConfigurableInterface::BOOL,
                             FirstServiceClient::FIELD_3 => ConfigurableInterface::STRING,
                         ], $result);
    }

    public function testSetAndGetValue(FunctionalTester $I, ConfigService $service, FirstServiceClient $client): void
    {
        $service->setValue($client, FirstServiceClient::FIELD_1, self::TEST_VALUE);

        $value = $service->getValue($client, FirstServiceClient::FIELD_1);
        $I->assertEquals(self::TEST_VALUE, $value);
    }
}
