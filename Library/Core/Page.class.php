<?php

class Page {
	private $pageno = 1;
	private $totalList;
	private $pageSize;

	public function show( $_totalList , $_pageSize , $left = 2 , $right = 2){
		$this->totalList = $_totalList;
		$this->pageSize = $_pageSize;
		$param_str = $_SERVER['QUERY_STRING'];//获取参数，为字符串
		$param_arr = explode("&", $param_str);
		$_param = array();
		foreach( $param_arr as $str ){
			if( !strstr( $str ,"pageno") ){//strstr(原字符，要匹配的字符): 	匹配是否含有pageno字符，若无则返回false
				$_param[] = $str;
			}
		}
		$param = implode("&", $_param);//将参数用&重新拼接
		
		if( !isset($_GET['pageno']) ){
			$this->pageno = 1;
		}else{
			$this->pageno = $_GET['pageno'];
		}
		
		$pageMax =	 ceil(  $this->totalList / $this->pageSize );//最大页码
		$html = '<div class="page_box"><a class="page_unable">总记录：'.$this->totalList.'</a><a class="page_unable">'.$this->pageno.'/'.$pageMax.'</a>';
		if( $this->pageno > 1 ){
			$html .= '<a href="?pageno=1&'.$param.'" class="page_able">首页</a><a href="?pageno='.($this->pageno-1).'&'.$param.'"class="page_able"><<上一页</a>';
		}else{
			$html .= '<a class="page_unable">首页</a><a class="page_unable"><<上一页</a>';
		}
		$start = $this->pageno - $left;
		if( $start < 1 ) $start = 1 ;
		for( $i = $start; $i<$this->pageno; $i++ ){
			$html .= '<a href="?pageno='.$i.'&'.$param.'" class="page_able">'.$i.'</a>';
		}
		$html .= '<a class="page_unable">'.$this->pageno.'</a>';
		$end = $this->pageno + $right;
		if( $end > $pageMax ) $end = $pageMax ;
		for( $i = ($this->pageno + 1); $i<=$end ; $i++ ){
			$html .= '<a href="?pageno='.$i.'&'.$param.'" class="page_able">'.$i.'</a>';
		}
		if( $this->pageno < $pageMax ){
			$html .='<a href="?pageno='.($this->pageno+1).'&'.$param.'" class="page_able">下一页>></a><a href="?pageno='.$pageMax.'&'.$param.'" class="page_able">尾页</a>';
		}else{
			$html .='<a class="page_unable">下一页>></a><a class="page_unable">尾页</a></div>';
		}
		
		return $html;
	}

	//获取偏移量
	public function getOffset(){
		$offset = ($this->pageno - 1) * $this->pageSize;
		if ( $offset < 0 ) $offset = 0;
		return $offset;
	}
}//类结束



