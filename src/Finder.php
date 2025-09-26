<?php

declare(strict_types=1);

namespace Devnix\M49;

use function PHPStan\dumpType;

/**
 * @readonly
 */
final class Finder
{
    /**
     * @var array<positive-int, non-empty-string>
     */
    private array $currentCountryList;

    /**
     * @var array<positive-int, non-empty-string>
     */
    private array $obsoleteCountryList;

    public function __construct()
    {
        // @phpstan-ignore assign.propertyType
        $this->currentCountryList = require dirname(__DIR__).'/data/current-country-list.php';

        // @phpstan-ignore assign.propertyType
        $this->obsoleteCountryList = require dirname(__DIR__).'/data/obsolete-country-list.php';
    }

    /**
     * @param positive-int $m49Code
     *
     * @return non-empty-string|null
     */
    public function m49ToIso31661alpha2(int $m49Code): string|null
    {
        if (!array_key_exists($m49Code, $this->currentCountryList)) {
            return null;
        }

        return $this->currentCountryList[$m49Code];
    }

    /**
     * @param positive-int $m49Code
     *
     * @return non-empty-string|null
     */
    public function obsoleteM49ToIso31661alpha2(int $m49Code): string|null
    {
        if (!array_key_exists($m49Code, $this->obsoleteCountryList)) {
            return null;
        }

        return $this->obsoleteCountryList[$m49Code];
    }
}