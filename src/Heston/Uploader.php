<?php namespace Heston;

use Heston\FtpCommand;
use Heston\GitExtractor;

/**
 * Upload files to FTP Server
 */
class Uploader
{

	/**
	 * @var Heston\FtpCommand
	 */
	private FtpCommand $ftpCommand;

	/**
	 * @var GitExtractor
	 */
	private GitExtractor $gitExtractor;

	/**
	 * @var string
	 */
	private $comment;

	/**
	 * Construct
	 *
	 * @param FtpCommand $ftpCommand
	 * @param array(GitExtractor) $extractor
	 */
	public function __construct(FtpCommand $ftpCommand, GitExtractor $gitExtractor, $comment)
	{
		$this->ftpCommand = $ftpCommand;
		$this->gitExtractor = $gitExtractor;
		$this->comment = $comment;
	}

	/**
	 * Upload all files
	 *
	 * @return void
	 */
	public function upload()
	{
		$this->gitExtractor->extract();
		$this->ftpCommand->login();

		foreach ($this->gitExtractor->getFiles() as $file) 
		{
			switch ($file->getStatus()) {
				case 'A':
					$this->add($file);
					break;
				case 'M':
					$this->add($file);
					break;
				case 'D':
					$this->delete($file);
					break;				
				default:
					break;
			}
		}
		//$this->extractor->commit($this->comment);
	}

	/**
	 * Add/Modify file. if Directory not exist, create first
	 *
	 * @param Heston\Model\File
	 * @return void
	 */	
	public function add($file)
	{
		if($this->ftpCommand->mkdir( dirname($file->getPath()) ))
			$this->ftpCommand->put($file);			
	}

	/**
	 * Deleting file
	 *
	 * @param Heson\Model\File
	 * @return void
	 */
	public function delete($file)
	{
		$this->ftpCommand->delete($file);
	}
}