<?php

declare(strict_types=1);

namespace App;

class Method
{
    public function method(): void
    {
        throw $this->exception();
    }

    private function exception(): \RuntimeException
    {
        return new \RuntimeException();
    }
}
