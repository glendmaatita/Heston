<?php namespace Heston\Model;

class HestonFileTest extends \PHPUnit_Framework_TestCase
{

	public function testFileAttributes()
	{
		$author = new File($filename = '_sites/about.html', $path = 'http://abc.com/', $status = 'A');

		$this->assertClassHasAttribute('filename', 'Heston\Model\File');
		$this->assertClassHasAttribute('path', 'Heston\Model\File');
		$this->assertClassHasAttribute('status', 'Heston\Model\File');

	}
}