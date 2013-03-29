<?php
//自己的分页
//$test=array('total'=>$num);
//echo $ajaxpage->show(1); //'mode:1<br>'
class page{
	/**
	 * config ,public
	 */
	private $total;//记录总条数
	private $page_name;//page标签，用来控制url页。比如说xxx.php?page=2中的page
	private $next_page='>';//下一页
	private $pre_page='<';//上一页
	private $first_page='First';//首页
	private $last_page='Last';//尾页
	private $pre_bar='<<';//上一分页条
	private $next_bar='>>';//下一分页条
	private $format_left='';
	private $format_right='';
	private $pagebarnum;
	private $totalpage=0;//总页数
	private $nowindex=1;//当前页
	private $url='';//url地址头
	public  $offset=0;//limt传递
	/**
	 * 初始化分页，调用必须；
	 * **/
	function __construct($total,$page_name='page',$pagebarnum='10'){
	$this->total=$total;
	$this->page_name=$page_name;
	$this->pagebarnum=$pagebarnum;
	if((!is_int($this->total))||($this->total<0))$this->error(__FUNCTION__,$this->total.' 不是一个数字!');
	if((!is_int($this->pagebarnum))||($this->pagebarnum<=0))$this->error(__FUNCTION__,$this->pagebarnum.' 不是一个数字!');
	$this->_set_nowindex($this->nowindex);//设置当前页
	$this->_set_url($this->url);//设置链接地址
	$this->totalpage=ceil($this->total/$this->pagebarnum);//总页数
	$this->offset=($this->nowindex-1)*$this->pagebarnum;//limt值
	}
	
	/**
	 * 获取显示"下一页"的代码
	 *
	 * @param string $style
	 * @return string
	 */
	function next_page($style='')
	{
		if($this->nowindex<$this->totalpage){
			return $this->_get_link($this->_get_url($this->nowindex+1),$this->next_page,$style);
		}
		return '<span class="'.$style.'">'.$this->next_page.'</span>';
	}
	
	/**
	 * 获取显示“上一页”的代码
	 *
	 * @param string $style
	 * @return string
	 */
	function pre_page($style='')
	{
		if($this->nowindex>1){
			return $this->_get_link($this->_get_url($this->nowindex-1),$this->pre_page,$style);
		}
		return '<span class="'.$style.'">'.$this->pre_page.'</span>';
	}
	
	/**
	 * 获取显示“首页”的代码
	 *
	 * @return string
	 */
	function first_page($style='')
	{
		if($this->nowindex==1){
			return '<span class="'.$style.'">'.$this->first_page.'</span>';
		}
		return $this->_get_link($this->_get_url(1),$this->first_page,$style);
	}
	
	/**
	 * 获取显示“尾页”的代码
	 *
	 * @return string
	 */
	function last_page($style='')
	{
		if($this->nowindex==$this->totalpage){
			return '<span class="'.$style.'">'.$this->last_page.'</span>';
		}
		return $this->_get_link($this->_get_url($this->totalpage),$this->last_page,$style);
	}
	
	function nowbar($style='',$nowindex_style='')
	{
		$plus=ceil($this->pagebarnum/2);
		if($this->pagebarnum-$plus+$this->nowindex>$this->totalpage)$plus=($this->pagebarnum-$this->totalpage+$this->nowindex);
		$begin=$this->nowindex-$plus+1;
		$begin=($begin>=1)?$begin:1;
		$return='';
		for($i=$begin;$i<$begin+$this->pagebarnum;$i++)
		{
		if($i<=$this->totalpage){
		if($i!=$this->nowindex){
		$return.=$this->_get_text($this->_get_link($this->_get_url($i),$i,$style));
		}else{
		$return.=$this->_get_text('<span class="'.$nowindex_style.'">'.$i.'</span>');
			}
		}else{
		break;
		}
			$return.="\n";
	}
	unset($begin);
		return $return;
	}
	
	/**
	* 获取显示跳转按钮的代码
	*
	* @return string
	 */
	 function select()
	 {
	 	
	 $return='<select name="PB_Page_Select">';
		for($i=1;$i<=$this->totalpage;$i++)
			{
			if($i==$this->nowindex){
			$return.='<option value="'.$i.'" selected>'.$i.'</option>';
			}else{
		$return.='<option value="'.$i.'">'.$i.'</option>';
   }
			}
	   		unset($i);
	   		$return.='</select>';
	   		return $return;
	}
	
		/**
		* 获取mysql 语句中limit需要的值
	   		*
	   		* @return string
	   		*/
	   		function offset()
	   		{
	   			return $this->offset;
	   			}
	
	   			/**
	   			 * 控制分页显示风格（你可以增加相应的风格）
	   			 *
	   			 * @param int $mode
	   			 * @return string
	   			 */
	   			function show($mode=1)
	   			{
	   				switch ($mode)
	   				{
	   					case '1':
	   						
	   						$this->next_page='下一页';
	   						$this->pre_page='上一页';
	   						return $this->pre_page().$this->nowbar().$this->next_page().'第'.$this->select().'页';
	   						break;
	   					case '2':
	   						$this->next_page='下一页';
	   						$this->pre_page='上一页';
	   						$this->first_page='首页';
	   						$this->last_page='尾页';
	   						return $this->first_page().$this->pre_page().'[第'.$this->nowindex.'页]'.$this->next_page().$this->last_page().'第'.$this->select().'页';
	   						break;
	   					case '3':
	   						$this->next_page='下一页';
	   						$this->pre_page='上一页';
	   						$this->first_page='首页';
	   						$this->last_page='尾页';
	   						return $this->first_page().$this->pre_page().$this->next_page().$this->last_page();
	   						break;
	   					case '4':
	   						$this->next_page='下一页';
	   						$this->pre_page='上一页';
	   						$this->first_page='首页';
	   						$this->last_page='尾页';
	   						return $this->first_page()."  ".$this->pre_page().$this->nowbar().$this->next_page()."  ".$this->last_page();
	   						break;
	   					case '5':
	   						return $this->pre_bar().$this->pre_page().$this->nowbar().$this->next_page().$this->next_bar();
	   						break;
	   				}
	
	   			}
	
	   			/*----------------private function (私有方法)-----------------------------------------------------------*/
	   			/**
	   			 * 设置url头地址
	   			 * @param: String $url
	   			 * @return boolean
	   			 */
	   			function _set_url($url="")
	   			{
	   				if(!empty($url)){
	   					//手动设置
	   					$this->url=$url.((stristr($url,'?'))?'&':'?').$this->page_name."=";
	   				}else{
	   					//自动获取
	   					if(empty($_SERVER['QUERY_STRING'])){
	   						//不存在QUERY_STRING时
	   						$this->url=$_SERVER['REQUEST_URI']."?".$this->page_name."=";
	   					}else{
	   						//
	   						if(stristr($_SERVER['QUERY_STRING'],$this->page_name.'=')){
	   							//地址存在页面参数
	   							$this->url=str_replace($this->page_name.'='.$this->nowindex,'',$_SERVER['REQUEST_URI']);
	   							$last=$this->url[strlen($this->url)-1];
	   							if($last=='?'||$last=='&'){
	   								$this->url.=$this->page_name."=";
	   							}else{
	   								$this->url.='&'.$this->page_name."=";
	   							}
	   						}else{
	   							//
	   							$this->url=$_SERVER['REQUEST_URI'].'&'.$this->page_name.'=';
	   						}//end if
	   					}//end if
	   				}//end if
	   			}
	
	   			/**
	   			 * 设置当前页面
	   			 *
	   			 */
	   			function _set_nowindex($nowindex){
	   				//if(!empty($nowindex)){
	   					//系统获取
	   					if(isset($_GET[$this->page_name])){
	   						$this->nowindex=intval($_GET[$this->page_name]);
	   					}else{
	   						//手动设置
	   						$this->nowindex=intval($nowindex);
	   				//	}
	   			}
	   		}
	   		/**
	   		 * 为指定的页面返回地址值
	   		 *
	   		 * @param int $pageno
	   		 * @return string $url
	   		 */
	   		function _get_url($pageno=1)
	   		{
	   			return $this->url.$pageno;
	   		}
	
	   		/**
	   		 * 获取分页显示文字，比如说默认情况下_get_text('<a href="">1</a>')将返回[<a href="">1</a>]
	   		 *
	   		 * @param String $str
	   		 * @return string $url
	   		 */
	   		function _get_text($str){
	   			return $this->format_left.$str.$this->format_right;
	   		}
	
	   		/**
	   		 * 获取链接地址
	   		 */
	   		function _get_link($url,$text,$style=''){
	   			$style=(empty($style))?'':'class="'.$style.'"';
	   			return '<a '.$style.' href="'.$url.'">'.$text.'</a>';
	   		}
	   		/**
	   		 * 出错处理方式
	   		 */
	   		function error($function,$errormsg)
	   		{
	   			die('Error in file <b>'.__FILE__.'</b> ,Function <b>'.$function.'()</b> :'.$errormsg);
	   		}
}
?>