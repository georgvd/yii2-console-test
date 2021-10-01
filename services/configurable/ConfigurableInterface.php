<?php

namespace app\services\configurable;

interface ConfigurableInterface
{
    public const STRING = 'STRING';
    public const BOOL = 'BOOL';
    public const ARRAY = 'ARRAY';

    /**
     * Возвращает список переменных доступных для хранения в настройках
     * @return array
     */
    public function getConfigurableValues(): array;

    /**
     * сохраняет переменную в конфиге
     * @param string $name
     * @param $value
     * @return mixed
     */
    public function setValue(string $name, $value);

    /**
     * Получает переенную по имени из конфига
     * @param string $name
     * @return mixed
     */
    public function getValue(string $name);
}