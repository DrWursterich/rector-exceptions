<?php

declare(strict_types=1);

namespace App;

class RethrownThrow
{
    public function someMethod(): void
    {
        try {
            throw new \RuntimeException();
        } catch (\RuntimeException $exception) {
            throw $exception;
        }
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

class RethrownThrow
{
    /**
     * @throws \RuntimeException
     */
    public function someMethod(): void
    {
        try {
            throw new \RuntimeException();
        } catch (\RuntimeException $exception) {
            throw $exception;
        }
    }
}
