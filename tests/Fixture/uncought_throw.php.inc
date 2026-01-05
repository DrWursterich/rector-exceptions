<?php

declare(strict_types=1);

namespace App;

class UncoughtThrow
{
    public function someMethod(): void
    {
        try {
            throw new \Exception();
        } catch (\RuntimeException $exception) {
            echo 'cought';
        }
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

class UncoughtThrow
{
    /**
     * @throws \Exception
     */
    public function someMethod(): void
    {
        try {
            throw new \Exception();
        } catch (\RuntimeException $exception) {
            echo 'cought';
        }
    }
}
