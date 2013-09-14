<?php namespace Heston;

/**
 * Factory to get Class Instance
 */
class HestonFactory
{

	/**
	 * @var string URL of FTP server
	 */
	private $url;

	/**
	 * @var array
	 */
	private $host = array();

	/**
	 * @var string local directory
	 */
	private $localDir;

	/**
	 * @var string remote directory
	 */
	private $remoteDir;

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
	 * @param string $url
	 * @param string $localDir
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($url, $localDir, $username, $password)
	{
		$this->url = $url;
		$this->localDir = $localDir;
		$this->username = $username;
		$this->password = $password;
	}

	public function create($type)
	{
		$this->defineHost();
		switch ($type) 
		{
			case 'connector':
				return $this->connect();
				break;

			case 'extractor':
				return $this->extract();
				break;

			case 'commander':
				return $this->command($this->connect(), $this->username, $this->password);
				break;

			case 'uploader':
				return $this->upload($this->command($this->connect(), $this->username, $this->password), $this->extract());
				break;
			
			default:
				break;
		}	
	}

	public function defineHost()
	{
		$hostComponent = parse_url($this->url);
		$this->host['host'] = $hostComponent['host'];
		$this->host['port'] = $hostComponent['port'];
		$this->host['remoteDir'] = $hostComponent['path'];

		return $this->host;
	}

	public function connect()
	{
		return new FtpConnect($this->host['host'], $this->host['port']);
	}

	public function extract()
	{
		return new GitExtractor($this->localDir, $this->host['remoteDir']);
	}

	public function command($ftpConnect, $username, $password)
	{
		return new FtpCommand($ftpConnect, $username, $password);
	}

	public function upload($ftpCommand, $extractor)
	{
		return new Uploader($ftpCommand, $extractor);
	}
}