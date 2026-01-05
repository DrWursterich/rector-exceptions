<?php

declare(strict_types=1);

namespace App;

use Exceptions\AException;
use Exceptions\ZException;

class SortThrows
{
    /**
     * @throws \InvalidArgumentException
     */
    public function someMethod(): void
    {
        throw match (rand(0, 3)) {
            0 => new \RuntimeException(),
            1 => new ZException(),
            2 => new AException(),
            3 => new \InvalidArgumentException(),
        };
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

use Exceptions\AException;
use Exceptions\ZException;

class SortThrows
{
    /**
     * @throws AException
     * @throws ZException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function someMethod(): void
    {
        throw match (rand(0, 3)) {
            0 => new \RuntimeException(),
            1 => new ZException(),
            2 => new AException(),
            3 => new \InvalidArgumentException(),
        };
    }
}
