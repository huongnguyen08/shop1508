<?php 
/**
* Phân trang by Huong Huong
*/
class Pager{

	private $_totalItem;// tổng số item
	public $_nItemOnPage; // số lượng item trong 1 page
	private $_nPageShow ; // số lượng link page hiển thị
	private $_totalPage; // tổng số page
	private $_currentPage; // page hiện tại


	public function __construct($totalItem,$currentPage = 1,$nItemOnPage = 5,$nPageShow = 5){
		$this->_totalItem 	= $totalItem;
		$this->_nItemOnPage	= $nItemOnPage;

		if ($nPageShow%2==0) {
			$nPageShow 		= $nPageShow + 1;
		}

		$this->_nPageShow 	= $nPageShow;
		$this->_currentPage = abs($currentPage);
		$this->_totalPage  	= ceil($totalItem/$nItemOnPage);
	}

	public function get_nItemOnPage(){
		return $this->_nItemOnPage;
	}
	public function getCurrentPage(){
		return $this->_currentPage;
	}
	public function showPagination(){
		
		$paginationHTML 	= '';
		if($this->_totalPage > 1){
			$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			$actual_link = explode('?page=', $actual_link)[0];
			//$actual_link = $arr[0];

			$start 	= '';
			$prev 	= '';
			if($this->_currentPage > 1){
				$start 	= "<li><a href='$actual_link?page=1'>Start</a></li>";
				$prev 	= "<li><a href='$actual_link?page=".($this->_currentPage-1)."'>«</a></li>";
			}
			$next 	= '';
			$end 	= '';
			if($this->_currentPage < $this->_totalPage){
				$next 	= "<li><a href='$actual_link?page=".($this->_currentPage+1)."'>»</a></li>";
				$end 	= "<li><a href='$actual_link?page=".$this->_totalPage."'>End</a></li>";
			}

			if($this->_nPageShow < $this->_totalPage){
				if($this->_currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->_nPageShow;
				}else if($this->_currentPage == $this->_totalPage){
					$startPage		= $this->_totalPage - $this->_nPageShow + 1;
					//  cái số trang bắt đầu để hiển thị
					$endPage		= $this->_totalPage;
				}else{
					$startPage		= $this->_currentPage - ($this->_nPageShow-1)/2;
								 //      6							3 = 3
					$endPage		= $this->_currentPage + ($this->_nPageShow-1)/2;
									//   6					3  = 9
					if($startPage < 1){
						$endPage	= $endPage + 1;  // 9
						$startPage 	= 1; //1
					}
					//9 > 11
					if($endPage > $this->_totalPage){
						$endPage	= $this->_totalPage; //7
						$startPage 	= $endPage - $this->_nPageShow + 1; //7-10+1=-2
					}
				}

			}else{
				$startPage		= 1;
				$endPage		= $this->_totalPage;
			}
			/**************/
			$listPages = '';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->_currentPage) {
					$listPages .= "<li class='active'><a href='#'>".$i.'</a>';
				}else{
					$listPages .= "<li><a href='$actual_link?page=".$i."'>".$i.'</a>';
				}
			}
			$paginationHTML = '<ul class="pagination">'.$start.$prev.$listPages.$next.$end.'</ul>';
		}
		return $paginationHTML;
	}
}


 ?>