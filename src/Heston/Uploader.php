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

	/**
	 * Upload all files
	 *
	 * @return void
	 */
	public function upload()
	{
		$this->extractor->extract();
		$this->ftpCommand->login();

		foreach ($this->extractor->getFiles() as $file) 
		{
			switch ($file->getStatus()) {
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
		$this->extractor->commit("Succesfully Uploaded");
	}

	/**
	 * Adding file. if Directory not exist, create first
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
	 * Modify file
	 *
	 * @param Heston\Model\File
	 * @return void
	 */	
	public function put($file)
	{
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