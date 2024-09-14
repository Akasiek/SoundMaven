<?php

namespace Tests\Unit\Helpers;

use App\Helpers\FileExtensionFromString;
use PHPUnit\Framework\TestCase;

class FileExtensionFromStringTest extends TestCase
{
    public function test_can_get_file_extension_from_string(): void
    {
        $helper = new FileExtensionFromString;

        $this->assertEquals('jpg', $helper('image.jpg'));
        $this->assertEquals('png', $helper('image.png'));
        $this->assertEquals('gif', $helper('image.gif'));
        $this->assertEquals('gif', $helper('image-harder.to.get.gif'));
        $this->assertEquals('jpeg', $helper('image.JPEG'));
        $this->assertEquals(null, $helper('image'));
    }

}
