<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\CalculationException;

class OwnStaticMethod
{
    public function someMethod(): void
    {
        self::throwException();
    }

    /**
     * @throws CalculationException
     */
    public static function throwException(): void
    {
        throw new CalculationException();
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\CalculationException;

class OwnStaticMethod
{
    /**
     * @throws CalculationException
     */
    public function someMethod(): void
    {
        self::throwException();
    }

    /**
     * @throws CalculationException
     */
    public static function throwException(): void
    {
        throw new CalculationException();
    }
}
