<?php

declare(strict_types=1);

use DrWursterich\RectorExceptions\DeclareThrowsRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([DeclareThrowsRector::class]);
