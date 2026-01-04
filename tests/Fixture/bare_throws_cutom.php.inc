<?php

declare(strict_types=1);

namespace App;

use App\Exception\CalculationException;

class BareThrows
{
    public function someMethod(): void
    {
        throw new CalculationException();
    }
}
-----
<?php

declare(strict_types=1);

namespace App;

use App\Exception\CalculationException;

class BareThrows
{
    /**
     * @throws CalculationException
     */
    public function someMethod(): void
    {
        throw new CalculationException();
    }
}
