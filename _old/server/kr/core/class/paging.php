<?php

/**
 * GR Core Paging Class
 * 작성자: sirini ( http://sirini.net , sirini@gmail.com )
 * 작성일: 2009-02-02
 * 내   용: 페이징 처리 클래스. 그누보드4 참조함 (http://sir.co.kr)
 **/

class Paging {
	public $pageNum = 10, $currentPage = 1, $totalPage = 1, $move = './?page=', $division = 0, $originDiv = 0, $so = '', $st = '';


	function getPaging() {
		$this->str = '';
		if($this->so && $this->st) $asq = '&amp;so='.$this->so.'&amp;st='.urlencode($this->st); else $asq = '';
		if($this->originDiv > $this->division) $this->str .= '<a href="'.$this->move.'1&amp;originDiv='.$this->originDiv.'&amp;division='.($this->division + 1).$asq.'" title="앞쪽 범주를 계속 검색합니다">◀ Continue</a> &nbsp;'; 
		if($this->currentPage > 1) $this->str .= '<a href="'.$this->move.'1'.$asq.'" title="처음 페이지로 이동합니다">First</a>';
		$startPage = (((int)(($this->currentPage - 1 ) / $this->pageNum )) * $this->pageNum) + 1;
		$endPage = $startPage + $this->pageNum - 1;
		if($endPage >= $this->totalPage) $endPage = $this->totalPage;
		if($startPage > 1) $this->str .= ' &nbsp;<a href="'.$this->move.($startPage-1).'&amp;originDiv='.$this->originDiv.'&amp;division='.$this->division.$asq.'" title="이전 페이지로 이동합니다">prev</a>';
		if($this->totalPage > 1)
		{
			for($i=$startPage;$i<=$endPage;$i++)
			{
				if($this->currentPage != $i) $this->str .= ' &nbsp;<a href="'.$this->move.$i.'&amp;originDiv='.$this->originDiv.'&amp;division='.$this->division.$asq.'">'.$i.'</a>';
				else $this->str .= ' &nbsp;<strong>'.$i.'</strong> ';
			}
		}
		if($this->totalPage > $endPage) $this->str .= ' &nbsp;<a href="'.$this->move.($endPage+1).'&amp;originDiv='.$this->originDiv.'&amp;division='.$this->division.$asq.'" title="다음 페이지로 넘어갑니다">next</a>';
		if ($this->currentPage < $this->totalPage) $this->str .= ' &nbsp;<a href="'.$this->move.$this->totalPage.'&amp;originDiv='.$this->originDiv.'&amp;division='.$this->division.$asq.'" title="맨 끝 페이지로 이동합니다">Last</a>';		
		if($this->division) $this->str .= ' &nbsp;<a href="'.$this->move.'1&amp;originDiv='.$this->originDiv.'&amp;division='.($this->division - 1).$asq.'" title="뒤쪽 범주를 계속 검색합니다">Continue ▶</a>';
		$this->str .= '';
		return $this->str;
	}

}

?>
