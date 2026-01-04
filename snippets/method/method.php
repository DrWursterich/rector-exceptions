<?php

declare(strict_types=1);

namespace App;

class Method
{
    public function method(): void
    {
        $this->throwException();
    }

    /**
     * @throws \RuntimeException
     */
    private function throwException(): void
    {
        throw new \RuntimeException();
    }
}
