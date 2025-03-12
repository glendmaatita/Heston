<?php namespace Heston\Tests;

use PHPUnit\Framework\TestCase;
use Heston\FtpConnect;

class HestonFtpConnectTest extends TestCase
{
	public function testConnect()
	{
		$connector = new FtpConnect('192.168.1.12', '21', '90');
		$this->assertTrue( is_resource($connector->connect()) );
	}
}