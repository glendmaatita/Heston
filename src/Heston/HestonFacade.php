<?php namespace Heston;

/**
 * Main API Facade
 */
class HestonFacade
{
	/**
	 * Main API for uploading
	 *
	 * @param string $url
	 * @param string $username
	 * @param string $password
	 * @param string $localDir
	 */
	public static function upload($uri, $localDir, $comment)
	{
		//build a factory first
		$factory = new HestonFactory($uri, $localDir, $comment);

		// extract from git status
		$uploader = $factory->create('uploader');
		$uploader->upload();
	}
}