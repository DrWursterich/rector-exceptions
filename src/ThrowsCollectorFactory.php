<?php

declare(strict_types=1);

namespace DrWursterich\RectorExceptions;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;

class ThrowsCollectorFactory
{
    public function __construct(
        private readonly NodeTypeResolver $nodeTypeResolver,
        private readonly NodeNameResolver $nodeNameResolver,
        private readonly ReflectionProvider $reflectionProvider,
    ) {
    }

    public function forScope(Scope $scope): ThrowsCollector
    {
        return new ThrowsCollector(
            $this->nodeTypeResolver,
            $this->nodeNameResolver,
            $this->reflectionProvider,
            $scope,
        );
    }
}
