<?php

declare(strict_types=1);

namespace App;

class Bare
{
    public function bare(): void
    {
        throw new \RuntimeException();
    }
}
