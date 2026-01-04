<?php

declare(strict_types=1);

namespace App;

class ThrowsMethoda
{
    public function someMethod(): void
    {
        throw $this->exception();
    }

    private function exception(): \RuntimeException
    {
        return new \RuntimeException();
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

class ThrowsMethoda
{
    /**
     * @throws \RuntimeException
     */
    public function someMethod(): void
    {
        throw $this->exception();
    }

    private function exception(): \RuntimeException
    {
        return new \RuntimeException();
    }
}
