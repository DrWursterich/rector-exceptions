<?php

declare(strict_types=1);

namespace App;

class Assigned
{
    public function assigned(): void
    {
        $exception = new \RuntimeException();
        throw $exception;
    }
}
