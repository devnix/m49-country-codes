<?php

declare(strict_types=1);

namespace Devnix\M49\Tests;

use Devnix\M49\Finder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Finder::class)]
final class FinderTest extends TestCase
{
    private Finder $finder;

    protected function setUp(): void
    {
        $this->finder = new Finder();
    }

    public function testM49ToIso31661alpha2WithValidM49Code(): void
    {
        // Test with known valid M49 codes from the data file
        $this->assertSame('DZ', $this->finder->m49ToIso31661alpha2(12)); // Algeria
        $this->assertSame('EG', $this->finder->m49ToIso31661alpha2(818)); // Egypt
        $this->assertSame('BR', $this->finder->m49ToIso31661alpha2(76)); // Brazil
        $this->assertSame('US', $this->finder->m49ToIso31661alpha2(840)); // United States
    }


    public function testConstructorLoadsData(): void
    {
        // Test that constructor properly initializes the object
        $finder = new Finder();
        
        // Test with a known code to ensure data is loaded
        $result = $finder->m49ToIso31661alpha2(12);
        $this->assertIsString($result);
        $this->assertSame(2, strlen($result)); // ISO alpha-2 codes are always 2 characters
        $this->assertSame('DZ', $result);
    }

    public function testReturnedCodesAreValidIsoFormat(): void
    {
        // Test that returned codes follow ISO 3166-1 alpha-2 format
        $testCodes = [12, 818, 76]; // Algeria, Egypt, Brazil
        
        foreach ($testCodes as $m49Code) {
            $result = $this->finder->m49ToIso31661alpha2($m49Code);
            $this->assertIsString($result);
            $this->assertSame(2, strlen($result));
            $this->assertMatchesRegularExpression('/^[A-Z]{2}$/', $result);
        }
    }

    public function testMultipleCallsReturnSameResult(): void
    {
        // Test consistency across multiple calls
        $m49Code = 12; // Algeria
        $firstCall = $this->finder->m49ToIso31661alpha2($m49Code);
        $secondCall = $this->finder->m49ToIso31661alpha2($m49Code);
        $thirdCall = $this->finder->m49ToIso31661alpha2($m49Code);
        
        $this->assertSame($firstCall, $secondCall);
        $this->assertSame($secondCall, $thirdCall);
        $this->assertSame('DZ', $firstCall);
    }

    public function testNullReturnForNonExistentCodes(): void
    {
        // Test various non-existent codes return null consistently
        $nonExistentCodes = [10000, 99999, 123456, 5];
        
        foreach ($nonExistentCodes as $code) {
            $this->assertNull($this->finder->m49ToIso31661alpha2($code));
        }
    }

    public function testObsoleteM49ToIso31661alpha2WithValidM49Code(): void
    {
        // Test with known valid obsolete M49 codes from the data file
        $this->assertSame('DE', $this->finder->obsoleteM49ToIso31661alpha2(280)); // Federal Republic of Germany (West Germany)
        $this->assertSame('DE', $this->finder->obsoleteM49ToIso31661alpha2(278)); // German Democratic Republic (East Germany)
        $this->assertSame('YE', $this->finder->obsoleteM49ToIso31661alpha2(720)); // Democratic Yemen (South Yemen)
        $this->assertSame('VN', $this->finder->obsoleteM49ToIso31661alpha2(704)); // Democratic Republic of Viet Nam (North)
        $this->assertSame('CD', $this->finder->obsoleteM49ToIso31661alpha2(180)); // Zaire
        $this->assertSame('RS', $this->finder->obsoleteM49ToIso31661alpha2(891)); // Serbia and Montenegro
    }

    public function testObsoleteM49ToIso31661alpha2WithNullValues(): void
    {
        // Test obsolete codes that map to null (countries that split into multiple)
        $this->assertNull($this->finder->obsoleteM49ToIso31661alpha2(810)); // USSR
        $this->assertNull($this->finder->obsoleteM49ToIso31661alpha2(890)); // Yugoslavia (SFRY)
    }

    public function testObsoleteM49ToIso31661alpha2WithNonExistentCodes(): void
    {
        // Test various non-existent codes return null consistently
        $nonExistentCodes = [10000, 99999, 123456, 5, 1, 999];
        
        foreach ($nonExistentCodes as $code) {
            $this->assertNull($this->finder->obsoleteM49ToIso31661alpha2($code));
        }
    }

    public function testObsoleteReturnedCodesAreValidIsoFormat(): void
    {
        // Test that returned codes follow ISO 3166-1 alpha-2 format (when not null)
        $testCodes = [280, 278, 720, 704, 180]; // Valid codes that return ISO codes
        
        foreach ($testCodes as $m49Code) {
            $result = $this->finder->obsoleteM49ToIso31661alpha2($m49Code);
            $this->assertIsString($result);
            $this->assertSame(2, strlen($result));
            $this->assertMatchesRegularExpression('/^[A-Z]{2}$/', $result);
        }
    }

    public function testObsoleteMultipleCallsReturnSameResult(): void
    {
        // Test consistency across multiple calls for obsolete method
        $m49Code = 280; // Federal Republic of Germany (West Germany)
        $firstCall = $this->finder->obsoleteM49ToIso31661alpha2($m49Code);
        $secondCall = $this->finder->obsoleteM49ToIso31661alpha2($m49Code);
        $thirdCall = $this->finder->obsoleteM49ToIso31661alpha2($m49Code);
        
        $this->assertSame($firstCall, $secondCall);
        $this->assertSame($secondCall, $thirdCall);
        $this->assertSame('DE', $firstCall);
    }
}