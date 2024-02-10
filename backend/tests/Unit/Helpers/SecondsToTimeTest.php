<?php

namespace Helpers;

use App\Helpers\SecondsToTime;
use PHPUnit\Framework\TestCase;

class SecondsToTimeTest extends TestCase
{
    public function test_can_convert_seconds_to_time_with_seconds()
    {
        $time = new SecondsToTime;
        
        $this->assertEquals('00:50', $time(50));
        $this->assertEquals('00:10', $time(10));
        $this->assertEquals('00:01', $time(1));
        $this->assertEquals('00:00', $time(0));
    }

    public function test_can_convert_seconds_to_time_with_minutes()
    {
        $time = new SecondsToTime;

        $this->assertEquals('05:00', $time(300));
        $this->assertEquals('04:33', $time(273));
        $this->assertEquals('16:23', $time(983));
        $this->assertEquals('20:34', $time(1234));
    }

    public function test_can_convert_seconds_to_time_with_hours()
    {
        $time = new SecondsToTime;

        $this->assertEquals('01:00:00', $time(3600));
        $this->assertEquals('01:00:01', $time(3601));
        $this->assertEquals('01:01:01', $time(3661));
        $this->assertEquals('343:59:42', $time(1238382));
    }
}
