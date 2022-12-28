<?php

namespace Uzbek\LaravelHumo\Traits;

use Illuminate\Support\Collection;

trait PluckDetails
{
    protected function pluckDetails($resp)
    {
        $details = $resp['details']['item'] ?? null;
        if (is_array($resp) && $details !== null) $resp['details'] = (new Collection($details))->pluck('value', 'name')->toArray();
        return $resp;
    }
}
