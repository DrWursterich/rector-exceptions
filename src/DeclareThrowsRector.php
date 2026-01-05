<?php

namespace DrWursterich\RectorExceptions;

use PHPStan\Reflection\ReflectionProvider;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\PHPStan\ScopeFetcher;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class DeclareThrowsRector extends AbstractRector
{
    public function __construct(
        private readonly ThrowsCollectorFactory $throwsCollectorFactory,
        private readonly ReflectionProvider $reflectionProvider,
        private readonly ScopeFetcher $scopeFetcher,
        private readonly ThrowsDeclarationMerger $throwsDeclarationMerger,
    ) {
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param ClassMethod $node
     */
    public function refactor(Node $node): ?Node
    {
        $stmts = $node->getStmts();
        if ($stmts === null || $stmts === []) {
            return null;
        }
        $scope = $this->scopeFetcher->fetch($node);
        $visitor = $this->throwsCollectorFactory->forScope($scope);
        $traverser = new NodeTraverser($visitor);
        $traverser->traverse($stmts);
        $exceptions = $visitor->getExceptions();
        return $this->throwsDeclarationMerger->addAll($node, $exceptions);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add @throws declaration to methods capable of throwing Exceptions',
            [
                new CodeSample(
                    <<<'EOF'
    public function divide(int $x, int $y): float
    {
        if ($y === 0) {
            throw new \DivisionByZeroException();
        }
        return (float)$x / (float)$y;
    }
    EOF,
                    <<<'EOF'
    /**
     * @throws \DivisionByZeroException
     */
    public function divide(int $x, int $y): float
    {
        if ($y === 0) {
            throw new \DivisionByZeroException();
        }
        return (float)$x / (float)$y;
    }
    EOF,
                ),
            ]
        );
    }
}
