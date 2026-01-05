<?php

declare(strict_types=1);

namespace App;

class CoughtSupertype
{
    public function someMethod(): void
    {
        try {
            throw new \Exception();
        } catch (\Throwable $exception) {
            echo 'cought';
        }
    }
}
