<?php namespace Heston;

class HestonFtpConnectTest extends \PHPUnit_Framework_TestCase
{
	public function testConnect()
	{
		$connector = new FtpConnect('192.168.1.12', '21', '90');
		$this->assertTrue( is_resource($connector->connect()) );

	}
}