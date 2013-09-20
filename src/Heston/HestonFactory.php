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
				return $this->connector();
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
		// Split FTP URI into: 
    // $match[0] = ftp://username:password@ftp.domain.tld/path1/path2/ 
    // $match[1] = username
    // $match[2] = password 
    // $match[3] = ftp.domain.tld 
    // $match[4] = port
    // $match[5] = /public_html
		preg_match("/ftp:\/\/(.*?):(.*?)@(.*?):(.*?)(\/.*)/i", $this->url, $match); 

		//var_dump($match); die();

		$this->host['hostname'] = $match[3];
		$this->host['port'] = $match[4];
		$this->host['username'] = $match[1];
		$this->host['password'] = $match[2];
		$this->host['remoteDir'] = $match[5];

		return $this->host;
	} 

	/**
	 * Create FtpConnect object instance
	 *
	 * @return Heston\FtpConnect
	 */
	public function connector()
	{
		$connector = new FtpConnect($this->host['hostname'], $this->host['port']);
		return $connector;
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
		return new FtpCommand($this->connector()->connect(), $this->username, $this->password);
	}

	/**
	 * Create Uploader Object instance
	 *
	 * @return Heston\Uploader
	 */
	public function upload()
	{
		return new Uploader($this->command($this->connector()->connect(), $this->username, $this->password), $this->extract());
	}
}