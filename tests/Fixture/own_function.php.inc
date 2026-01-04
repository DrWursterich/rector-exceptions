<?php

declare(strict_types=1);

namespace App;

/**
 * @throws \RuntimeException
 */
function throwException(): void
{
    throw new \RuntimeException();
}

class OwnFunction
{
    public function someMethod(): void
    {
        throwException();
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

/**
 * @throws \RuntimeException
 */
function throwException(): void
{
    throw new \RuntimeException();
}

class OwnFunction
{
    /**
     * @throws \RuntimeException
     */
    public function someMethod(): void
    {
        throwException();
    }
}
