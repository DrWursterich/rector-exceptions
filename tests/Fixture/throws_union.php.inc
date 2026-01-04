<?php

declare(strict_types=1);

namespace App;

use Some\OtherException;

class ThrowsUnion
{
    public function someMethod(): void
    {
        $exception = match (rand(0, 2)) {
            0 => new \RuntimeException(),
            1 => new OtherException(),
            2 => new \Yet\AnotherException(),
        };
        throw $exception;
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

use Some\OtherException;

class ThrowsUnion
{
    /**
     * @throws AnotherException
     * @throws OtherException
     * @throws \RuntimeException
     */
    public function someMethod(): void
    {
        $exception = match (rand(0, 2)) {
            0 => new \RuntimeException(),
            1 => new OtherException(),
            2 => new \Yet\AnotherException(),
        };
        throw $exception;
    }
}
