<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use DrWursterich\RectorExceptions\DeclareThrowsRector;

return RectorConfig::configure()
    ->withPaths(['snippets'])
    ->withRules([DeclareThrowsRector::class]);
