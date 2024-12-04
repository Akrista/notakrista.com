<?php

return Rector\Config\RectorConfig::configure()
    ->withSets([
        Rector\Set\ValueObject\SetList::DEAD_CODE,
        Rector\Set\ValueObject\SetList::EARLY_RETURN,
        Rector\Set\ValueObject\SetList::TYPE_DECLARATION,
        Rector\Set\ValueObject\SetList::CODE_QUALITY,
        Rector\Set\ValueObject\SetList::CODING_STYLE,
    ])
    ->withPaths([__DIR__.'/app', __DIR__.'/config', __DIR__.'/_pages'])
    ->withPhpVersion(Rector\ValueObject\PhpVersion::PHP_84)
    ->withRules([
        Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector::class,
    ]);
