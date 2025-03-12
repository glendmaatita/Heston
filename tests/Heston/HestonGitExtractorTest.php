<?php namespace Heston\Tests;

use PHPUnit\Framework\TestCase;
use Heston\GitExtractor;

class HestonGitExtractor extends TestCase
{
	public function testExtract()
	{
		$extractor = new GitExtractor('/home/mine/', 'public_html');

		$gitStatus = "M  tes.txt \nD  test2.txt \nA  testme.txt";
		$extractor->buildFiles($gitStatus);

		$files = $extractor->getFiles();
		$this->assertTrue(is_array($files));
		$this->assertEquals(3, count($files));

		$this->assertEquals('M', $files[0]->getStatus() );
		$this->assertEquals('tes.txt', $files[0]->getFilename() );

		$this->assertEquals('D', $files[1]->getStatus() );
		$this->assertEquals('test2.txt', $files[1]->getFilename() );

		$this->assertEquals('A', $files[2]->getStatus() );
		$this->assertEquals('testme.txt', $files[2]->getFilename() );
	}
}