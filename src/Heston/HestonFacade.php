<?php namespace Heston;

class HestonFacade
{
	public static function upload($url, $username, $password, $localDir)
	{
		//build a factory first
		$factory = new HestonFactory($url, $localDir, $username, $password);

		// extract from git status
		$uploader = $factory->create('uploader');
		$uploader->upload();
	}
}