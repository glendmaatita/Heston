<?php namespace Heston\Model;

/**
 * File to upload
 */
class File
{

	/**
	 * @var string Path file in local machine
	 */
	private $filename;

	/**
	 * @var string path on FTP server
	 */
	private $path;

	/**
	 * @var string Status that FTP will handle
	 */
	private $status;

	/**
	 * Construct
	 *
	 * @param string $filename
	 * @param string $path
	 * @param string $status
	 * @param Model\FTPConstant $const
	 */
	public function __construct($filename, $path = '', $status = '', $const = null)
	{
		$this->filename = $filename;
		$this->path = $path;
		$this->status = $status;
	}

	/**
	 * Set file name
	 *
	 * @param string $filename
	 */
	public function setFilename($filename)
	{
		$this->filename = $filename;
	}

	/**
	 * Get file name
	 *
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * Set path to upload
	 *
	 * @param string $path
	 * @todo set path
	 */
	public function setPath($path)
	{
		$this->path = $path; 
	}

	/**
	 * Get path
	 *
	 * @return string
	 */
	public function getPath()
	{
		// draft
		return '/'; //$this->path;
	}

	/**
	 * Set status of file : Add, Modified, or Delete
	 *
	 * @param string $status
	 */
	public function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	 * Get status of file
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}
}