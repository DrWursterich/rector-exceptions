<?php

declare(strict_types=1);

namespace App;

class CoughtThrow
{
    public function someMethod(): void
    {
        try {
            throw new \RuntimeException();
        } catch (\RuntimeException $exception) {
            echo 'cought';
        }
    }
}
