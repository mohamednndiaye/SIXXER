<?php 

class PageController extends PageModel {
	/*
	 * public constructor method
	 * @param array $urlArr
	 * @return void
	 * 
	 * Standard constructor method. Called when PageController is instantiated.
	 */
	public function __construct( $urlArr )
	{
		if ( $urlArr['baseUrl'] ) $this->set_baseUrl($urlArr['baseUrl']);
		if ( $urlArr['pagename'] ) $this->set_pagename($urlArr['pagename']);
		if ( $urlArr['pageVars'] ) $this->set_pageVars($urlArr['pageVars']);

		$this->set_pageObj();

		$this->get_pageContent();

		$this->get_part('header');

		$this->get_template();

		$this->get_part('footer');
	}

	private function set_pageObj()
	{
		$pagename = (isset($this->pagename) ? $this->pagename : 'home');
		$objName = ucfirst($pagename) . 'Page';
		if (file_exists('class' . DS . 'pages' . DS . $objName . '.php')) {
			$this->pageObj = new $objName($this->pageVars);
		}
	}

	private function get_pageContent()
	{
		$content = false;

		if (isset($this->pagename)) {
			$db = new DatabaseController();
						
			$db->query('SELECT content FROM pages WHERE pagename = :pagename ORDER BY page_id ASC');
			$db->bind(':pagename', $this->pagename);
			/*$db->bind(':id', 1);
			$db->print_query();*/

			if ($db->execute() && isset($db->resultset()[0])) {
				foreach ($db->resultset() as $row) {
					$content .= '<p>'.$row['content'].'</p>';
				}
			}
		}

		$this->set_pageContent($content);
	}

	private function get_part( $file )
	{	
		$filename = 'views' . DS . 'parts' . DS . $file . '.phtml';
		if ( file_exists($filename) ) {
			include $filename;
		} else {
			throw new \Exception('No such file: '.$filename);
		}
	}

	private function get_template()
	{
		$pagename = (isset($this->pagename) ? $this->pagename : 'home');
		$filename = 'views' . DS . 'templates' . DS . $pagename . '.phtml';

		if ( file_exists($filename) ) {
			include $filename;
		} else if (!$this->pageContent) {
			include 'views' . DS . 'templates' . DS . '404.phtml';
		} else {
			include 'views' . DS . 'templates' . DS . 'default.phtml';
		}
	}
}