<?php namespace Heston;

use Heston\FtpConnect;
use FTP\Connection as FTPConnection;

class FtpCommand
{

	/**
	 * @var FTPConnection
	 */
	private FTPConnection $connect;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * Construct
	 *
	 * @param FTPConnection $connect
	 */
	public function __construct(FTPConnection $connect, $username, $password)
	{
		$this->connect = $connect;
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * Login to FTP Server
	 *
	 * @param string $username
	 * @param string password
	 * @return boolean
	 */
	public function login()
	{
		return ftp_login($this->connect, $this->username, $this->password);
	}

	/**
	 * Delete file on FTP server
	 *
	 * @param Model\File $file
	 * @return boolean
	 */
	public function delete($file)
	{
		return ftp_delete($this->connect, $file->getPath());
	}

	/**
	 * Put file on the remote server
	 *
	 * @param Model\File $file
	 * @return boolean
	 */
	public function put($file)
	{
		return ftp_put($this->connect, $file->getPath(), $file->getFilename(), FTP_ASCII);
	}

	/**
	 * Close FTP Connection
	 *
	 * @return boolean
	 */
	public function close()
	{
		return ftp_close($this->connect);
	}

	/**
	 * Create a directory on the server
	 *
	 * @param string $dir
	 * @return string/false
	 */
	public function mkdir($dir)
	{
		return $this->make_directory($dir);
	}

	/**
	 * Delete a directory on the server
	 *
	 * @param string $dir
	 * @return boolean
	 */
	public function rmdir($dir)
	{
		return ftp_rmdir($this->connect, $dir);
	}

	/**
	 * recursive make directory function for ftp 
	 * tribute to http://sameerparwani.com/posts/recursive-ftp-make-directory-mkdir
	 */
	public function make_directory($dir)
	{
		// if directory already exists or can be immediately created return true
		if ($this->ftp_is_dir($dir) || @ftp_mkdir($this->connect, $dir)) 
			return true;
		// otherwise recursively try to make the directory
		if (!$this->make_directory(dirname($dir))) 
			return false;
		// final step to create the directory
		return ftp_mkdir($this->connect, $dir);
	}

	public function ftp_is_dir($dir)
	{
		// get current directory
		$original_directory = ftp_pwd($this->connect);
		// test if you can change directory to $dir
		// suppress errors in case $dir is not a file or not a directory
		if ( @ftp_chdir( $this->connect, $dir ) ) 
		{
			// If it is a directory, then change the directory back to the original directory
			ftp_chdir( $this->connect, $original_directory );
			return true;
		} 
		else {
			return false;
		}
	}
}