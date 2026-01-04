<?php

declare(strict_types=1);

namespace App;

use Some\OtherException;

class Union
{
    public function union(): void
    {
        $exception = match (rand(0, 2)) {
            0 => new \RuntimeException(),
            1 => new OtherException(),
            2 => new \Yet\AnotherException(),
        };
        throw $exception;
    }
}
