<?php

declare(strict_types=1);

namespace App;

class ThrowInAnonymousClass
{
    public function someMethod(): \object
    {
        return new class {
            /**
             * @throws \RuntimeException
             */
            public function throwSomething(): void
            {
                throw new \RuntimeException();
            }
        };
    }
}
