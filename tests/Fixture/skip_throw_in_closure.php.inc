<?php

declare(strict_types=1);

namespace App;

class ThrowInClosure
{
    public function someMethod(): callable
    {
        return function (string $a) {
            if ($a === '') {
                throw new \InvalidArgumentException();
            }
        };
    }
}
