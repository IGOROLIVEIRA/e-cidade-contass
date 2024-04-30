<?php

namespace App\Tests\Unit\Support\String;

use App\Support\String\DateFormatter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DateFormatterTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testShouldConvertDateFormatBRToISO(): void
    {
        $originalDate = '20/09/2023';
        $formattedDate = DateFormatter::convertDateFormatBRToISO($originalDate);
        $this->assertStringContainsString('-', $formattedDate);
    }

    public function testShouldThrowExceptionConvertDateFromInvalidFormatoISO(): void
    {
        $originalDate = '2023-01-01';
        /**
         * Ideally, expectException() is called immediately before the code is called that is expected to throw the exception.
         */
        $this->expectException(InvalidArgumentException::class);
        DateFormatter::convertDateFormatBRToISO($originalDate);
    }
}
