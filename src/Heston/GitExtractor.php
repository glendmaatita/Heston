<?php namespace Heston;

use Heston\Model\File;
use Heston\Model\FtpConstant;

/**
 * Get list of files - extracted from Git, that will uploaded
 */

class GitExtractor
{
	/**
	 * @var array(Model\File) $files
	 */
	private $files = array();

	/**
	 * @var string Directory of Git
	 */
	private $directory;

	/**
	 * @var string
	 */
	private $remoteDir;

	/**
	 * Construct
	 *
	 * @param string $directory
	 * @param string $remoteDir
	 */
	public function __construct($directory, $remoteDir)
	{
		$this->directory = $directory;
		$this->remoteDir = $remoteDir;
	}

	/**
	 * Get file handled by Git
	 *
	 * @return void
	 */
	public function extract()
	{
		shell_exec( 'git add ' . $this->directory . ' && git add -u ' . $this->directory );
		$this->buildFiles(shell_exec( 'git status -s ' . $this->directory ));
	}

	/**
	 * Extract git status and create file object instance
	 *
	 * @return void
	 */
	public function buildFiles($gitStatus)
	{
		$statuses = explode("\n", $gitStatus);
		foreach ($statuses as $status) 
		{
			if($status == '')
				continue;
			$files = explode(" ", trim(preg_replace('/\s\s+/', ' ',$status)));

			// still draft			
			$rdir = str_replace($this->directory, "", '/' . $files[1]);

			//$this->files[] = new File($files[1], $this->remoteDir . '/' . $files[1], $files[0], FtpConstant::ASCII);
			$this->files[] = new File($files[1], $rdir, $files[0], FtpConstant::ASCII);
		}
	}

	public function commit($comment)
	{
		shell_exec( 'git commit -m "' . $comment . '"' . $this->directory );
	}

	/**
	 * Get files
	 *
	 * @return array(Model\File)
	 */
	public function getFiles()
	{
		return $this->files;
	}
}