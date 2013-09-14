<?php namespace Heston;

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
	 */
	public function connect()
	{
		return ftp_connect($this->host, $this->port, $this->timeout);
	}
}