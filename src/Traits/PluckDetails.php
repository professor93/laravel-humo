<?php

namespace Uzbek\LaravelHumo\Traits;

trait PluckDetails
{
    protected function pluckDetails($resp)
    {
        $details = $resp['details']['item'] ?? null;
        if (is_array($resp) && $details !== null) $resp['details'] = collect($details)->pluck('value', 'name')->toArray();
        return $resp;
    }
}
