<?php namespace Heston;

use FTP\Connection;

class FtpConnect
{
	/**
	 * @var string $host
	 */
	private $host;

	/**
	 * @var string $port
	 */
	private $port;

	/**
	 * @var string $timeout
	 */
	private $timeout;

	/**
	 * Construct
	 *
	 * @param string $host
	 * @param string $port
	 * @param string timeout
	 */
	public function __construct($host, $port = '21', $timeout = '90')
	{
		$this->host = $host;
		$this->port = $port;
		$this->timeout = $timeout;
	}

	/**
	 * Connect to server
	 *
	 * @return FTP\Connection
	 */
	public function connect(): Connection
	{
		return ftp_connect($this->host, $this->port, $this->timeout);
	}

	/**
	 * Get Host of server
	 *
	 * @return string
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * Get Port of server
	 *
	 * @return string
	 */
	public function getPort()
	{
		return $this->port;
	}

	/**
	 * Get Timeout
	 *
	 * @return string
	 */
	public function getTimeout()
	{
		return $this->timeout;
	}
}