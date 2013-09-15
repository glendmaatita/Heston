<?php namespace Heston;

use Heston\Model\File;

class FtpCommand
{

	/**
	 * @var stream
	 */
	private $connector;

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
	 * @param stream $connect
	 */
	public function __construct($connect, $username, $password)
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
		if( !ftp_chdir($this->connect, $dir) ) 
			return ftp_mkdir($this->connect, $dir);
		else
			return true;
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
}