<?php namespace Sam\Services\ExternalContentGrabber;

interface ExternalContentGrabberInterface {

	public function grab($pageId);

	public function grabInfo();

	public function grabAlbums();

	public function grabPhotos($albumId);

	public function albums();

	public function info();
}