<?php

declare(strict_types=1);

namespace App;

class SkipPresentBuiltinThrows
{
    /**
     * @throws \RuntimeException
     */
    public function someMethod(): void
    {
        throw new \RuntimeException();
    }
}
