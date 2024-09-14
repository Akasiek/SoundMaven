<?php

namespace Helpers;

use App\Helpers\TimeToSeconds;
use Exception;
use PHPUnit\Framework\TestCase;

class TimeToSecondsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_can_convert_time_with_seconds_to_seconds()
    {
        $helper = new TimeToSeconds;

        $this->assertEquals(50, $helper('00:50'));
        $this->assertEquals(10, $helper('00:10'));
        $this->assertEquals(1, $helper('00:01'));
        $this->assertEquals(0, $helper('00:00'));
        $this->assertEquals(0, $helper('00'));
    }

    /**
     * @throws Exception
     */
    public function test_can_convert_time_with_minutes_to_seconds()
    {
        $helper = new TimeToSeconds;

        $this->assertEquals(300, $helper('05:00'));
        $this->assertEquals(273, $helper('04:33'));
        $this->assertEquals(983, $helper('16:23'));
        $this->assertEquals(1234, $helper('20:34'));
    }

    /**
     * @throws Exception
     */
    public function test_can_convert_time_with_hours_to_seconds()
    {
        $helper = new TimeToSeconds;

        $this->assertEquals(3600, $helper('01:00:00'));
        $this->assertEquals(3601, $helper('01:00:01'));
        $this->assertEquals(3661, $helper('01:01:01'));
        $this->assertEquals(1238382, $helper('343:59:42'));
    }

    /**
     * @throws Exception
     */
    public function test_throws_exception_for_invalid_time_format()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid time format');

        $helper = new TimeToSeconds;
        $helper('01:01:01:01');
    }
}
