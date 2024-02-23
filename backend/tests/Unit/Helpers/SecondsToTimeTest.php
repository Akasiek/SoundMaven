<?php

namespace Helpers;

use App\Helpers\SecondsToTime;
use PHPUnit\Framework\TestCase;

class SecondsToTimeTest extends TestCase
{
    public function test_can_convert_seconds_to_time_with_seconds()
    {
        $helper = new SecondsToTime;

        $this->assertEquals('00:50', $helper(50));
        $this->assertEquals('00:10', $helper(10));
        $this->assertEquals('00:01', $helper(1));
        $this->assertEquals('00:00', $helper(0));
    }

    public function test_can_convert_seconds_to_time_with_minutes()
    {
        $helper = new SecondsToTime;

        $this->assertEquals('05:00', $helper(300));
        $this->assertEquals('04:33', $helper(273));
        $this->assertEquals('16:23', $helper(983));
        $this->assertEquals('20:34', $helper(1234));
    }

    public function test_can_convert_seconds_to_time_with_hours()
    {
        $helper = new SecondsToTime;

        $this->assertEquals('01:00:00', $helper(3600));
        $this->assertEquals('01:00:01', $helper(3601));
        $this->assertEquals('01:01:01', $helper(3661));
        $this->assertEquals('343:59:42', $helper(1238382));
    }
}
