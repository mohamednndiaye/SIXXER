<?php

class ApplicationModel {

	public $urlArr;

	public $pageObj;

	public function set_urlArr( array $urlArr )
	{
		$this->urlArr = $urlArr;
	}

	public function set_pageObj( $pageObj )
	{
		$this->pageObj = $pageObj;
	}

}