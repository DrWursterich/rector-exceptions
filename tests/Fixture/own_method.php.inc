<?php

declare(strict_types=1);

namespace App;

class OwnMethod
{
    public function someMethod(): void
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
-----
<?php

declare(strict_types=1);

namespace App;

class OwnMethod
{
    /**
     * @throws \RuntimeException
     */
    public function someMethod(): void
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
