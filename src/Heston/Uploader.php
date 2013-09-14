<?php namespace Heston;

/**
 * Upload files to FTP Server
 */
class Uploader
{

	/**
	 * @var Heston\FtpCommand
	 */
	private $ftpCommand;

	/**
	 * @var GitExtractor
	 */
	private $gitExtractor;

	/**
	 * Construct
	 *
	 * @param FtpCommand $ftpCommand
	 * @param array(GitExtractor) $extractor
	 */
	public function __construct($ftpCommand, $extractor)
	{
		$this->ftpCommand = $ftpCommand;
		$this->extractor = $extractor;
	}

	public function upload()
	{
		$this->extractor->extract();
		$this->ftpCommand->login($this->username, $password);
		foreach ($this->extractor->getFiles() as $file) 
		{
			switch ($file['status']) {
				case 'A':
					$this->add($file);
					break;
				case 'M':
					$this->put($file);
					break;
				case 'D':
					$this->delete($file);
					break;				
				default:
					break;
			}
		}
	}

	public function add($file)
	{
		if(basename($file->getPath()))
		{
			if($this->ftpCommand->mkdir( $file->getPath() ))
				$this->ftpCommand->put();
		}
	}

	public function put($file)
	{
		$this->ftpCommand->put();
	}

	public function delete($file)
	{
		$this->ftpCommand->delete($file->getPath());
	}
}