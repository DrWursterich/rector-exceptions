<?php

declare (strict_types=1);

namespace DrWursterich\RectorExceptions;

use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PhpParser\Node;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagRemover;
use Rector\Comments\NodeDocBlock\DocBlockUpdater;

final class ThrowsDeclarationMerger
{
    public function __construct(
        private readonly PhpDocTagRemover $phpDocTagRemover,
        private readonly DocBlockUpdater $docBlockUpdater,
        private readonly PhpDocInfoFactory $phpDocInfoFactory,
    ) {
    }

    /**
     * @param list<IdentifierTypeNode> $exceptions
     */
    public function addAll(Node $node, array $exceptions): ?Node
    {
        if ($exceptions === []) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNode($node);
        $phpDocInfo ??= $this->phpDocInfoFactory->createEmpty($node);
        $phpDocInfo->makeMultiLined();

        $hasChanged = false;
        foreach ($exceptions as $exception) {
            foreach ($phpDocInfo->getPhpDocNode()->children as $throws) {
                if (!($throws instanceof PhpDocTagNode)) {
                    continue;
                }
                if (!($throws->value instanceof ThrowsTagValueNode)) {
                    continue;
                }
                if (!($throws->value->type instanceof IdentifierTypeNode)) {
                    continue;
                }
                if ($throws->value->type->__toString() === $exception->__toString()) {
                    continue 2;
                }
            }
            $phpDocInfo->getPhpDocNode()->children[] = new PhpDocTagNode(
                name: '@throws',
                value: new ThrowsTagValueNode($exception, ''),
            );
            $hasChanged = true;
        }

        if (!$hasChanged) {
            return null;
        }

        sort($phpDocInfo->getPhpDocNode()->children);
        $this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($node);
        return $node;
    }
}
