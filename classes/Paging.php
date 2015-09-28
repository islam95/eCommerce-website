<?php

class Paging {

	private static $paging = 'paging';

	private $numPages;
	private $numRecords;
	private $currentPage;
	private $maximum;
	private $url; 
	private $records;
	private $offset = 0;
	
	public function __construct($rows, $max = 9){
		$this->records = $rows;
		$this->numRecords = count($this->records);
		$this->maximum = $max;
		$this->url = URL::getURL(self::$paging);
		$current = URL::getParameter(self::$paging);
		$this->currentPage = !empty($current) ? $current : 1;
		$this->numOfPages();
		$this->getOffset();
	}	


	public function getRecords(){
		$arr = array();
		if($this->numPages > 1){
			$last = ($this->offset + $this->maximum);

			for($i = $this->offset; $i < $last; $i++){
				if($i < $this->numRecords){
					$arr[] = $this->records[$i];
				}
			}
		} else {
			$arr = $this->records;
		}
		return $arr;
	}


	private function numOfPages(){
		$this->numPages = ceil($this->numRecords / $this->maximum);

	}


	private function getOffSet(){
		$this->offset = ($this->currentPage - 1) * $this->maximum;
	}


	private function pagingLinks(){
		if($this->numPages > 1){
			$arr = array();

			// first page
			if($this->currentPage > 1){
				$arr[] = "<a href=\"".$this->url."\">First</a>";
			} else {
				$arr[] = "<span>First</span>";
			}

			// previous link
			if($this->currentPage > 1){
				
				//previous page number
				$id = ($this->currentPage - 1);

				$currentURL = $id > 1 ?
					$this->url."&amp;".self::$paging."=".$id :
					$this->url;
				$arr[] = "<a href=\"{$currentURL}\">Previous</a>";

			} else{
				$arr[] = "<span>Previous</span>";
			}

			// next page
			if($this->currentPage != $this->numPages){
				$id = ($this->currentPage + 1);

				$currentURL = $this->url."&amp;".self::$paging."=".$id;
				$arr[] = "<a href=\"{$currentURL}\">Next</a>";
			} else{
				$arr[] = "<span>Next</span>";
			}

			// last page
			if($this->currentPage != $this->numPages){
				$currentURL = $this->url."&amp;".self::$paging."=".$this->numPages;
				$arr[] = "<a href=\"{$currentURL}\">Last</a>";
			} else {
				$arr[] = "<span>Last</span>";
			}


			return "<li>".implode("</li><li>", $arr)."</li>";
		}
	}



	public function getPaging(){
		$pages = $this->pagingLinks();
		if(!empty($pages)){
			$print = "<ul class=\"paging\">";
			$print .= $pages;
			$print .= "</ul>";
			return $print;
		}
	}



}