<?php namespace Heston;

class HestonFactoryTest extends \PHPUnit_Framework_TestCase
{
	public function testConnect()
	{
		$factory = new HestonFactory('ftp://root:secret@ftp.entung.com:21', '/home/malfunction/Project/Heston', 'root', 'secret' );

		$host = $factory->defineHost();


		$this->assertEquals('ftp.entung.com', $host['hostname']);
		$this->assertEquals('21', $host['port']);
		//$this->assertEquals('/public_html', $host['remoteDir']);

		$connector = $factory->create('connector');
		
		$this->assertInstanceOf('Heston\FtpConnect', $connector);

		$extractor = $factory->create('extractor');
		$this->assertInstanceOf('Heston\GitExtractor', $extractor);

		$commander = $factory->create('commander');
		$this->assertInstanceOf('Heston\FtpCommand', $commander);

		$uploader = $factory->create('uploader');
		$this->assertInstanceOf('Heston\Uploader', $uploader);

	}
}