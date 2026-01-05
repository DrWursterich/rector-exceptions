<?php

declare(strict_types=1);

namespace App;

class UnknownFunction
{
    /**
     * @param callable(string): int
     */
    public function someMethod(callable $callable): int
    {
        return $callable('asdf');
    }
}
