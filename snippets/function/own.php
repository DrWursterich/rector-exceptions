<?php

declare(strict_types=1);

namespace App;

/**
 * @throws \RuntimeException
 */
function throwException(): void
{
    throw new \RuntimeException();
}

class Own
{
    public function own(): void
    {
        throwException();
    }
}
