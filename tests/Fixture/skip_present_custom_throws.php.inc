<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\CalculationException;

class SkipPresentCustomThrows
{
    /**
     * @throws CalculationException
     */
    public function someMethod(): void
    {
        throw new CalculationException();
    }
}
