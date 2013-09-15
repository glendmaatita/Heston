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
	private $host = array('hostname' => '', 'port' => '21', 'remoteDir' => '');

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

	/**
	 * Create object instance
	 */
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
				return $this->command();
				break;

			case 'uploader':
				return $this->upload();
				break;
			
			default:
				break;
		}	
	}

	/**
	 * Define host, port, path from given URL
	 *
	 * @return array
	 */
	public function defineHost()
	{
		$hostComponent = parse_url($this->url);
		$this->host['hostname'] = $hostComponent['host'];
		$this->host['port'] = isset($hostComponent['port']) ? $hostComponent['port'] : '21' ;
		//$this->host['remoteDir'] = $hostComponent['path'];

		return $this->host;
	}

	/**
	 * Create FtpConnect object instance
	 *
	 * @return Heston\FtpConnect
	 */
	public function connect()
	{
		$connector = new FtpConnect($this->host['hostname'], $this->host['port']);
		return $connector->connect();
	}

	/**
	 * Create GitExtractor object instance
	 *
	 * @return Heston\GitExtractor
	 */
	public function extract()
	{
		return new GitExtractor($this->localDir, $this->host['remoteDir']);
	}

	/**
	 * Create FtpCommand object instance
	 *
	 * @return Heston\FtpCommand
	 */
	public function command()
	{
		return new FtpCommand($this->connect(), $this->username, $this->password);
	}

	/**
	 * Create Uploader Object instance
	 *
	 * @return Heston\Uploader
	 */
	public function upload()
	{
		return new Uploader($this->command($this->connect(), $this->username, $this->password), $this->extract());
	}
}