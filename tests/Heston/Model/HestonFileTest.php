<?php namespace Heston\Tests\Model;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Heston\Model\File;

class HestonFileTest extends TestCase
{

	public function testFileAttributes()
	{
		// test if class has the attributes
		$class = new ReflectionClass(File::class);

        $this->assertTrue($class->hasProperty('filename'), "Class File should have attribute 'filename'");
        $this->assertTrue($class->hasProperty('path'), "Class File should have attribute 'path'");
        $this->assertTrue($class->hasProperty('status'), "Class File should have attribute 'status'");

	}
}