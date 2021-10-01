<?php

namespace app\services\configurable\clients;

use app\services\configurable\ConfigurableInterface;
use app\services\configurable\exceptions\NoSuchValueInConfigException;

class FirstServiceClient
    implements ConfigurableInterface
{
    public const FIELD_1 = 'field1';
    public const FIELD_2 = 'field2';
    public const FIELD_3 = 'field3';
    private const CONFIGURABLE_VALUES = [
        self::FIELD_1 => ConfigurableInterface::STRING,
        self::FIELD_2 => ConfigurableInterface::BOOL,
        self::FIELD_3 => ConfigurableInterface::STRING,
    ];
    private $config = [];

    final public function getConfigurableValues(): array
    {
        return static::CONFIGURABLE_VALUES;
    }

    final public function getValue(string $name)
    {
        // тут какая-то реализация работы с конкрретным хранилищем (API, файл, поток)

        if (!isset(self::CONFIGURABLE_VALUES[$name])) {
            throw new NoSuchValueInConfigException();
        }

        return $this->config[$name];
    }

    /**
     * Сохраняем значение в поле сервиса
     * @param string $name
     * @param $value
     * @throws NoSuchValueInConfigException
     */
    final public function setValue(string $name, $value): void
    {
        // тут какая-то реализация работы с конкрретным хранилищем (API, файл, поток)
        if (!isset(self::CONFIGURABLE_VALUES[$name])) {
            throw new NoSuchValueInConfigException();
        }

        $this->config[$name] = $value;
    }
}