<?php

namespace Uzbek\LaravelHumo\Dtos\Middle;

use Illuminate\Contracts\Support\Arrayable;

abstract class Dto implements Arrayable
{
    public static function from(array $data): static
    {
//        $props = (new \ReflectionClass(static::class))->getProperties();
//        return new static(...$data);
    }

    public function toArray()
    {
        $args = func_get_args();
        $data = count($args) > 0 ? $args[0] : $this;
        if ($this->canBeArray($data)) {
            $result = [];
            foreach ($data as $key => $value)
                $result[$key] = $value instanceof Arrayable ? $value->toArray() : ($this->canBeArray($value) ? $this->toArray($value) : $value);
            return array_filter($result);
        }
        return $data;
    }

    private function canBeArray($data): bool
    {
        return is_array($data) || is_object($data);
    }
}
