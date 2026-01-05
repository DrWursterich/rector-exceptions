<?php

declare(strict_types=1);

namespace App;

class FinallyThrows
{
    public function someMethod(): void
    {
        try {
            echo 'thrown?';
        } catch (\RuntimeException $exception) {
            echo 'cought?';
        } finally {
            throw new \InvalidArgumentException();
        }
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

class FinallyThrows
{
    /**
     * @throws \InvalidArgumentException
     */
    public function someMethod(): void
    {
        try {
            echo 'thrown?';
        } catch (\RuntimeException $exception) {
            echo 'cought?';
        } finally {
            throw new \InvalidArgumentException();
        }
    }
}
