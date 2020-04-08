<?php 

class PageModel {

	public $baseUrl;

	public $pagename;

	public $pageVars;

	public $pageContent;

	public function set_baseUrl( string $baseUrl )
	{
		$this->baseUrl = $baseUrl;
	}

	public function set_pagename( string $pagename )
	{
		$this->pagename = $pagename;
	}

	public function set_pageVars( array $pageVars )
	{
		$this->pageVars = $pageVars;
	}

	public function set_pageContent( $pageContent )
	{
		if (is_string($pageContent)) {
			$this->pageContent = '<p>'.$pageContent.'</p>';
		} else if (is_array($pageContent)) {
			$this->pageContent = '<p>';
			foreach($pageContent as $value) $this->pageContent .= $value['content'];
			$this->pageContent .= '</p>';
		} else {
			$this->pageContent = $pageContent;
		}
	}
}