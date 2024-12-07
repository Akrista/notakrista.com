<?php

declare(strict_types=1);

namespace App\Extend;

use Hyde\Facades\Filesystem;
use Hyde\Markdown\Models\FrontMatter;
use Hyde\Markdown\Models\MarkdownDocument;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @experimental Typed data collections class extension.
 */
class DataCollections extends \Hyde\Support\DataCollections
{
    public static function yaml(string $name): static
    {
        if (static::hasType($name)) {
            return static::getTypedYaml($name);
        }

        return parent::yaml($name);
    }

    public static function markdown(string $name): static
    {
        if (static::hasType($name)) {
            return static::getTypedMarkdown($name);
        }

        return parent::markdown($name);
    }

    protected static function hasType(string $name): bool
    {
        if (Filesystem::exists(self::getTypePath($name))) {
            return true;
        }

        return class_exists(self::getTypeClassname($name));
    }

    /** @return static<\App\Extend\Concerns\DataCollectionType> */
    protected static function getTypedYaml(string $name): static
    {
        $className = self::getCallableTypeClassName($name);

        return parent::yaml($name)->map(fn (FrontMatter $data): object => new $className($data->toArray()));
    }

    /** @return static<\App\Extend\Concerns\DataCollectionType> */
    protected static function getTypedMarkdown(string $name): static
    {
        $className = self::getCallableTypeClassName($name);

        return parent::markdown($name)->map(fn (MarkdownDocument $document): object => new $className(array_merge(
            $document->matter()->toArray(),
            ['markdown' => $document->markdown()->body()]
        )));
    }

    protected static function getTypePath(string $name): string
    {
        return sprintf('%s/%s/type.php', static::$sourceDirectory, $name);
    }

    protected static function getTypeClassname(string $name): string
    {
        return 'App\\DataCollections\\Types\\'.Str::studly($name);
    }

    /** @return class-string<\App\Extend\Concerns\DataCollectionType> */
    protected static function getCallableTypeClassName(string $name): string
    {
        $className = self::getTypeClassname($name);

        if (! class_exists($className)) {
            $type = include self::getTypePath($name);

            $newClassName = get_class($type);
            class_alias($newClassName, $className);
        }

        return $className;
    }

    protected static function findFiles(string $name, array|string $extensions): Collection
    {
        return parent::findFiles($name, $extensions);
    }
}
