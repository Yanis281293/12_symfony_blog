<?php

namespace App\Trait;

trait TimeZoneTrait
{
    protected function changeTimeZone(mixed $timezoneId): void
    {
        \date_default_timezone_set($timezoneId);
    }
}
