<?php namespace Heston;

use Heston\FtpCommand;
use Heston\GitExtractor;
use Heston\Uploader;

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
	 * @var string
	 */
	private $comment;

	/**
	 * Construct
	 *
	 * @param string $url
	 * @param string $localDir
	 * @param string $comment
	 */
	public function __construct($url, $localDir, $comment)
	{
		$this->url = $url;
		$this->localDir = $localDir;
		$this->comment = $comment;
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
		// $match[0] = ftp://username:password@ftp.domain.tld:port/path1/path2/ 
		// $match[1] = username
		// $match[2] = password 
		// $match[3] = ftp.domain.tld 
		// $match[4] = port
		// $match[5] = /public_html
		//preg_match("/ftp:\/\/(.*?):(.*?)@(.*?):(.*?)(\/.*)/i", $this->url, $match); 
		preg_match("/ftp:\/\/(.*?):(.*?)@(.*?):(.*?)(.*)/i", $this->url, $match); //still draft

		$this->host['hostname'] = $match[3];
		$this->host['port'] = $match[5];
		$this->host['username'] = $match[1];
		$this->host['password'] = $match[2];
		$this->host['remoteDir'] = $match[4];

		return $this->host;
	} 

	/**
	 * Create FtpConnect object instance
	 *
	 * @return Heston\FtpConnect
	 */
	public function connector(): FtpConnect
	{
		$connector = new FtpConnect($this->host['hostname'], $this->host['port']);
		return $connector;
	}

	/**
	 * Create GitExtractor object instance
	 *
	 * @return Heston\GitExtractor
	 */
	public function extract(): GitExtractor
	{
		return new GitExtractor($this->localDir, $this->host['remoteDir']);
	}

	/**
	 * Create FtpCommand object instance
	 *
	 * @return Heston\FtpCommand
	 */
	public function command(): FtpCommand
	{
		return new FtpCommand($this->connector()->connect(), $this->host['username'], $this->host['password']);
	}

	/**
	 * Create Uploader Object instance
	 *
	 * @return Heston\Uploader
	 */
	public function upload(): Uploader
	{
		return new Uploader($this->command(), $this->extract(), $this->comment);
	}
}