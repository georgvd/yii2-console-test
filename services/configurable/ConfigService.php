<?php

namespace app\services\configurable;

/**
 * Class ConfigService
 * Сервис для работы с настройками
 * @package app\services
 */
class ConfigService
{

    /*
    1. получить клиента для сервиса
    2. получить поля для этого клиента
    3. записать поле
    4. прочитать поле


     */


    /**
     * Получение настройки выбранного сервиса
     * @return array
     */
    public function getConfig(ConfigurableInterface $service): array
    {
        $values = $service->getConfigurableValues();

        return $values;
    }

    public function setValue(ConfigurableInterface $service, string $key, $value):void
    {
        $service->setValue($key, $value);
    }

    public function getValue(ConfigurableInterface $service, string $key)
    {
        $value = $service->getValue($key);

        return $value;
    }
}