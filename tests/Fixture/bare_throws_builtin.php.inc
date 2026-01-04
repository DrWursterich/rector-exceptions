<?php

declare(strict_types=1);

namespace App;

class BareThrows
{
    public function someMethod(): void
    {
        throw new \RuntimeException();
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

class BareThrows
{
    /**
     * @throws \RuntimeException
     */
    public function someMethod(): void
    {
        throw new \RuntimeException();
    }
}
