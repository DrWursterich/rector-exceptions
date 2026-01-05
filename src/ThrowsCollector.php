<?php

declare(strict_types=1);

namespace DrWursterich\RectorExceptions;

use PHPStan\Analyser\Scope;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Type;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Throw_;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\TryCatch;
use Rector\BetterPhpDocParser\ValueObject\Type\FullyQualifiedIdentifierTypeNode;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;

class ThrowsCollector extends NodeVisitorAbstract
{
    /** @var list<IdentifierTypeNode> $exceptions */
    private array $exceptions = [];

    public function __construct(
        private readonly NodeTypeResolver $nodeTypeResolver,
        private readonly NodeNameResolver $nodeNameResolver,
        private readonly ReflectionProvider $reflectionProvider,
        private readonly Scope $scope,
    ) {
    }

    #[\Override]
    public function enterNode(Node $node): ?int
    {
        return $this->collect($node);
    }

    #[\Override]
    public function leaveNode(Node $node): Node
    {
        return $node;
    }

    public function collect(Node $node): ?int
    {
        $throws = null;
        if ($node instanceof TryCatch) {
            $exceptions = $this->collectFrom($node->stmts);
            foreach ($exceptions as $exception) {
                foreach ($node->catches as $catch) {
                    foreach ($catch->types as $type) {
                        if ($this->isCoughtBy($exception, $type)) {
                            continue 3;
                        }
                        $this->exceptions[] = $exception;
                    }
                }
            }
            $this->exceptions += $this->collectFrom($node->catches);
            if ($node->finally !== null) {
                $this->exceptions += $this->collectFrom($node->finally->stmts);
            }
            return NodeVisitor::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof Throw_) {
            $throws = $this->nodeTypeResolver->getType($node->expr);
        } elseif ($node instanceof FuncCall) {
            $name = $this->nodeNameResolver->getName($node->name);
            if ($name === null) {
                return null;
            }
            $name = new Name($name);
            $func = $this->reflectionProvider->getFunction($name, $this->scope);
            $throws = $func->getThrowType();
        } elseif ($node instanceof MethodCall) {
            $name = $this->nodeNameResolver->getName($node->name);
            if ($name === null) {
                return null;
            }
            $class = $this->nodeTypeResolver->getType($node->var);
            $method = $class->getMethod($name, $this->scope);
            $throws = $method->getThrowType();
        } elseif ($node instanceof StaticCall) {
            $name = $this->nodeNameResolver->getName($node->name);
            if ($name === null) {
                return null;
            }
            $class = $this->nodeTypeResolver->getType($node->class);
            $method = $class->getMethod($name, $this->scope);
            $throws = $method->getThrowType();
        }
        if ($throws !== null) {
            $this->addTypes($throws);
        }
        return null;
    }

    /**
     * @return list<IdentifierTypeNode>
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    /**
     * @param Node[] $stmts
     * @return list<IdentifierTypeNode>
     */
    private function collectFrom(array $stmts): array
    {
        $visitor = new ThrowsCollector(
            $this->nodeTypeResolver,
            $this->nodeNameResolver,
            $this->reflectionProvider,
            $this->scope,
        );
        $traverser = new NodeTraverser($visitor);
        $traverser->traverse($stmts);
        return $visitor->getExceptions();
    }

    private function isCoughtBy(IdentifierTypeNode $exception, Name $type): bool
    {
        $cought = $this->classNameToIdentifier($type->__toString());
        return is_a($exception->__toString(), $cought->__toString(), true);
    }

    private function addTypes(Type $type): void
    {
        foreach ($type->getObjectClassNames() as $name) {
            $this->exceptions[] = $this->classNameToIdentifier($name);
        }
    }

    private function classNameToIdentifier(
        string $className,
    ): IdentifierTypeNode {
        if (strpos($className, '\\') !== false) {
            $short = substr($className, strrpos($className, '\\') + 1);
            return new IdentifierTypeNode($short);
        } else {
            return new FullyQualifiedIdentifierTypeNode($className);
        }
    }
}
