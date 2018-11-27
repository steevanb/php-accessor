<?php

declare(strict_types=1);

namespace steevanb\PhpAccessor\Property;

use phpDocumentor\{Reflection\DocBlock\Tags\Var_,
    Reflection\DocBlockFactory,
    Reflection\Type,
    Reflection\TypeResolver,
    Reflection\Types\Array_,
    Reflection\Types\Boolean,
    Reflection\Types\Callable_,
    Reflection\Types\Compound,
    Reflection\Types\Float_,
    Reflection\Types\Integer,
    Reflection\Types\Iterable_,
    Reflection\Types\Null_,
    Reflection\Types\Nullable,
    Reflection\Types\Scalar,
    Reflection\Types\String_,
    Reflection\Types\Void_};
use phpDocumentor\Reflection\Types\This;

class PropertyType
{
    static public function getPhpAndPhpDocTypes(?string $type, \ReflectionProperty $property): array
    {
        $phpTypeHint = null;
        $phpDocType = null;

        if (is_string($type)) {
            $phpTypeHint = static::getPhpTypeHint(
                (new TypeResolver())->resolve(static::parsePropertyType($type))
            );
            $phpDocType = static::parsePropertyType($type);
        }

        $phpDoc = $property->getDocComment();
        if (($phpTypeHint === null || $phpDocType === null) && $phpDoc !== null) {
            try {
                /** @var $varTag ?Var_ */
                $varTag = DocBlockFactory::createInstance()->create($phpDoc)->getTagsByName('var')[0] ?? null;
            } catch (\Exception $e) {}

            if ($varTag instanceof Var_) {
                if ($phpTypeHint === null) {
                    $phpTypeHint = static::getPhpTypeHint($varTag->getType());
                }
                if ($phpDocType === null) {
                    $phpDocType = (string) $varTag;
                }
            }
        }

        if (is_string($phpTypeHint) && substr($phpTypeHint, -2) === '[]') {
            $phpTypeHint = (substr($phpTypeHint, 0, 1) === '?' ? '?' : null) . 'array';
        }

        return [$phpTypeHint, $phpDocType];
    }

    /** Return singular part if $type is an array. Ex: string for string[], string|int for string[]|int[] */
    static public function getSingularPhpAndPhpDocTypes(?string $type, \ReflectionProperty $property): array
    {
        [$phpTypeHint, $phpDocType] = static::getPhpAndPhpDocTypes($type, $property);

        if ($phpTypeHint === 'array' && substr($phpDocType, -2) === '[]') {
            $phpTypeHint = $phpDocType = substr($phpDocType, 0, -2);
        }

        return [$phpTypeHint, $phpDocType];
    }

    static public function getPhpTypeHint(Type $type): ?string
    {
        $return = null;

        /**
         * Bug: when (string) $type = '?type1|type2', first level should be Compound, but is Nullable
         * @link https://github.com/phpDocumentor/ReflectionDocBlock/issues/162
         */
        $finalType = null;
        if ($type instanceof Nullable) {
            $finalType = ($type->getActualType() instanceof Compound) ? null : $type->getActualType();
            $return = '?';
        } elseif ($type instanceof Compound === false) {
            $finalType = $type;
        }

        if ($finalType instanceof Type) {
            switch (get_class($finalType)) {
                case Array_::class:
                case Boolean::class:
                case Callable_::class:
                case Float_::class:
                case Integer::class:
                case Iterable_::class:
                case String_::class:
                case This::class:
                case Void_::class:
                    $return .= (string) $finalType;
                    break;
            }
        } else {
            $return = null;
        }

        return $return;
    }

    static public function parsePropertyType(?string $type): ?string
    {
        if ($type === null) {
            return null;
        }

        $nullable = false;
        $subTypes = explode('|', $type);

        // remove "null" and duplicates
        // ex: string|null will be resolved as ?string
        // ex: ?string|string|null|int will be resolved as string|int|null
        foreach ($subTypes as $subTypeKey => $subType) {
            if ($subType === '') {
                unset($subTypes[$subTypeKey]);
            } elseif (substr($subType, 0, 1) === '?') {
                $nullable = true;
            } elseif ($subType === 'null') {
                $nullable = true;
                unset($subTypes[$subTypeKey]);
            }
        }
        $refinedSubTypes = array_flip($subTypes);

        if (count($refinedSubTypes) === 0) {
            $return = null;
        } elseif (count($refinedSubTypes) === 1) {
            $return = array_keys($refinedSubTypes)[0];
            if ($nullable && substr($return, 0, 1) !== '?') {
                $return = '?' . $return;
            }
        } else {
            $refinedSubTypesValues = array_keys($refinedSubTypes);
            foreach ($refinedSubTypesValues as &$refinedSubType) {
                if (substr($refinedSubType, 0, 1) === '?') {
                    $refinedSubType = substr($refinedSubType, 1);
                }
            }

            $finalTypes = array_unique($refinedSubTypesValues);
            if (count($finalTypes) === 1) {
                $return = $nullable ? '?' . $finalTypes[0] : $finalTypes[0];
            } else {
                if ($nullable) {
                    $finalTypes[] = 'null';
                }
                $return = implode('|', array_unique($finalTypes));
            }
        }

        // TypeResolver don't understand "[]" as "array"
        if ($return === '[]') {
            $return = ($nullable ? '?' : null) . 'array';
        }

        return $return;
    }

    /** Ex: array => null, iterable => null, string[] => string, string[]|int[] => null, string[]|null => ?string */
    static public function getSingularPhpTypeFromIterable(?string $type, bool $allowNull): ?string
    {
        if (is_string($type)) {
            $type = static::parsePropertyType($type);
            $singularType = (is_string($type) && substr($type, -2) === '[]') ? substr($type, 0, -2) : $type;
            if (substr($singularType, 0, 1) === '?') {
                $singularType = substr($singularType, 1);
            }

            $resolvedType = null;
            try {
                $resolvedType = (new TypeResolver())->resolve($singularType);
            } catch (\Exception $e) {}

            if ($resolvedType instanceof Type) {
                switch (get_class($resolvedType)) {
                    case Boolean::class:
                    case Float_::class:
                    case Integer::class:
                    case Scalar::class:
                    case String_::class:
                        $return = ($allowNull ? '?' : null) . $singularType;
                    break;
                    default:
                        $return = null;
                }
            }
        } else {
            $return = null;
        }

        return $return;
    }

    static public function isNullable(?string $type): bool
    {
        if ($type === null) {
            $return = true;
        } else {
            $resolvedType = null;
            try {
                $resolvedType = (new TypeResolver())->resolve($type);
            } catch (\Exception $e) {}

            if ($resolvedType === null) {
                $return = true;
            } else {
                $return = false;
                if ($resolvedType instanceof Nullable) {
                    $return = true;
                } elseif ($resolvedType instanceof Compound) {
                    foreach ($resolvedType->getIterator() as $subResolvedType) {
                        if ($subResolvedType instanceof Null_) {
                            $return = true;
                            break;
                        }
                    }
                }
            }
        }

        return $return;
    }
}