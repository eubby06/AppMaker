<?php namespace Sam\Services\ExternalContentGrabber;

use Sam\Services\ExternalContentGrabber\ExternalContentGrabberInterface;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\GraphLocation;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookPermissionException;

class FacebookContentGrabber implements ExternalContentGrabberInterface{

	public $pageId;

	public $albums 	= array();

	public $info	= array();

	public $session;
	
	public function __construct()
	{
		FacebookSession::setDefaultApplication('403558916467083', 'ebe40e4b88e38c0a15dafd38d7f758e0');
		$this->session = FacebookSession::newAppSession();
	}

	public function grab($pageId)
	{
	
		$this->pageId = $pageId;

		$this->grabInfo();
		$this->grabAlbums();
	}

	public function grabInfo()
	{
		$request = new FacebookRequest(
		 				$this->session,
		  				'GET',
		  				'/' . $this->pageId
					);

		$response = $request->execute();
		$graphObject = $response->getGraphObject();
		$this->info = $graphObject;
	}

	public function grabAlbums()
	{
		$request = new FacebookRequest(
 				$this->session,
  				'GET',
  				'/' . $this->pageId . '/albums'
			);

		$response = $request->execute();
		$graphObject = $response->getGraphObject();

		$data = $graphObject->getProperty('data');

		foreach($data->asArray() as $album)
		{
			$this->albums[$album->id]['album'] = $album;
			$this->albums[$album->id]['photos'] = $this->grabPhotos($album->id);
		}
	}

	public function grabPhotos($albumId)
	{		
		$request = new FacebookRequest(
 				$this->session,
  				'GET',
  				'/' . $albumId . '/photos'
			);

		$response = $request->execute();
		$graphObject = $response->getGraphObject();
		
		$data = $graphObject->getProperty('data');

		return $data;
	}

	public function albums()
	{
		return $this->albums;
	}

	public function info()
	{
		return $this->info;
	}
}