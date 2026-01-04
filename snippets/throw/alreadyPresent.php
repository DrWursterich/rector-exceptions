<?php

declare(strict_types=1);

namespace App;

class AlreadyPresent
{
    /**
     * @throws \RuntimeException
     */
    public function alreadyPresent(): void
    {
        throw new \RuntimeException();
    }
}
