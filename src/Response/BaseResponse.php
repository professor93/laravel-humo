<?php
/**
 * Date: 8/23/2022
 * Time: 1:12 PM
 */

namespace Uzbek\LaravelHumo\Response;

class BaseResponse
{
    private array $_attributes;

    public function __construct(array $attributes)
    {
        $this->_attributes = $attributes;
    }

    public function __get($name)
    {
        $getter = 'get'.$name;
        if (method_exists($this, $getter)) {
            // read property, e.g. getName()
            return $this->$getter();
        }

        return $this->_attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        if (isset($this->_attributes[$name])) {
            $this->_attributes[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return isset($this->_attributes[$name]);
    }

    public function getAttributes(): array
    {
        return $this->_attributes;
    }

    public function getAttribute(string $name, $default = null)
    {
        return $this->_attributes[$name] ?? $default;
    }

    protected function getFormattedItems(array $items): array
    {
        $formatted_items = [];
        foreach ($items as $item) {
            $value = $item['value'];

            if (is_array($value) && empty($value)) {
                $value = null;
            }

            $formatted_items[$item['name']] = $value;
        }

        return $formatted_items;
    }
}
