<?php

declare(strict_types=1);

namespace App;

use App\Calculation\Exception as CalculationException;

class Own
{
    public function own(): void
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
