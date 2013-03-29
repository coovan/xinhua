<?php
//�Լ��ķ�ҳ
//$test=array('total'=>$num);
//echo $ajaxpage->show(1); //'mode:1<br>'
class page{
	/**
	 * config ,public
	 */
	private $total;//��¼������
	private $page_name;//page��ǩ����������urlҳ������˵xxx.php?page=2�е�page
	private $next_page='>';//��һҳ
	private $pre_page='<';//��һҳ
	private $first_page='First';//��ҳ
	private $last_page='Last';//βҳ
	private $pre_bar='<<';//��һ��ҳ��
	private $next_bar='>>';//��һ��ҳ��
	private $format_left='';
	private $format_right='';
	private $pagebarnum;
	private $totalpage=0;//��ҳ��
	private $nowindex=1;//��ǰҳ
	private $url='';//url��ַͷ
	public  $offset=0;//limt����
	/**
	 * ��ʼ����ҳ�����ñ��룻
	 * **/
	function __construct($total,$page_name='page',$pagebarnum='10'){
	$this->total=$total;
	$this->page_name=$page_name;
	$this->pagebarnum=$pagebarnum;
	if((!is_int($this->total))||($this->total<0))$this->error(__FUNCTION__,$this->total.' ����һ������!');
	if((!is_int($this->pagebarnum))||($this->pagebarnum<=0))$this->error(__FUNCTION__,$this->pagebarnum.' ����һ������!');
	$this->_set_nowindex($this->nowindex);//���õ�ǰҳ
	$this->_set_url($this->url);//�������ӵ�ַ
	$this->totalpage=ceil($this->total/$this->pagebarnum);//��ҳ��
	$this->offset=($this->nowindex-1)*$this->pagebarnum;//limtֵ
	}
	
	/**
	 * ��ȡ��ʾ"��һҳ"�Ĵ���
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
	 * ��ȡ��ʾ����һҳ���Ĵ���
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
	 * ��ȡ��ʾ����ҳ���Ĵ���
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
	 * ��ȡ��ʾ��βҳ���Ĵ���
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
	* ��ȡ��ʾ��ת��ť�Ĵ���
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
		* ��ȡmysql �����limit��Ҫ��ֵ
	   		*
	   		* @return string
	   		*/
	   		function offset()
	   		{
	   			return $this->offset;
	   			}
	
	   			/**
	   			 * ���Ʒ�ҳ��ʾ��������������Ӧ�ķ��
	   			 *
	   			 * @param int $mode
	   			 * @return string
	   			 */
	   			function show($mode=1)
	   			{
	   				switch ($mode)
	   				{
	   					case '1':
	   						
	   						$this->next_page='��һҳ';
	   						$this->pre_page='��һҳ';
	   						return $this->pre_page().$this->nowbar().$this->next_page().'��'.$this->select().'ҳ';
	   						break;
	   					case '2':
	   						$this->next_page='��һҳ';
	   						$this->pre_page='��һҳ';
	   						$this->first_page='��ҳ';
	   						$this->last_page='βҳ';
	   						return $this->first_page().$this->pre_page().'[��'.$this->nowindex.'ҳ]'.$this->next_page().$this->last_page().'��'.$this->select().'ҳ';
	   						break;
	   					case '3':
	   						$this->next_page='��һҳ';
	   						$this->pre_page='��һҳ';
	   						$this->first_page='��ҳ';
	   						$this->last_page='βҳ';
	   						return $this->first_page().$this->pre_page().$this->next_page().$this->last_page();
	   						break;
	   					case '4':
	   						$this->next_page='��һҳ';
	   						$this->pre_page='��һҳ';
	   						$this->first_page='��ҳ';
	   						$this->last_page='βҳ';
	   						return $this->first_page()."  ".$this->pre_page().$this->nowbar().$this->next_page()."  ".$this->last_page();
	   						break;
	   					case '5':
	   						return $this->pre_bar().$this->pre_page().$this->nowbar().$this->next_page().$this->next_bar();
	   						break;
	   				}
	
	   			}
	
	   			/*----------------private function (˽�з���)-----------------------------------------------------------*/
	   			/**
	   			 * ����urlͷ��ַ
	   			 * @param: String $url
	   			 * @return boolean
	   			 */
	   			function _set_url($url="")
	   			{
	   				if(!empty($url)){
	   					//�ֶ�����
	   					$this->url=$url.((stristr($url,'?'))?'&':'?').$this->page_name."=";
	   				}else{
	   					//�Զ���ȡ
	   					if(empty($_SERVER['QUERY_STRING'])){
	   						//������QUERY_STRINGʱ
	   						$this->url=$_SERVER['REQUEST_URI']."?".$this->page_name."=";
	   					}else{
	   						//
	   						if(stristr($_SERVER['QUERY_STRING'],$this->page_name.'=')){
	   							//��ַ����ҳ�����
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
	   			 * ���õ�ǰҳ��
	   			 *
	   			 */
	   			function _set_nowindex($nowindex){
	   				//if(!empty($nowindex)){
	   					//ϵͳ��ȡ
	   					if(isset($_GET[$this->page_name])){
	   						$this->nowindex=intval($_GET[$this->page_name]);
	   					}else{
	   						//�ֶ�����
	   						$this->nowindex=intval($nowindex);
	   				//	}
	   			}
	   		}
	   		/**
	   		 * Ϊָ����ҳ�淵�ص�ֵַ
	   		 *
	   		 * @param int $pageno
	   		 * @return string $url
	   		 */
	   		function _get_url($pageno=1)
	   		{
	   			return $this->url.$pageno;
	   		}
	
	   		/**
	   		 * ��ȡ��ҳ��ʾ���֣�����˵Ĭ�������_get_text('<a href="">1</a>')������[<a href="">1</a>]
	   		 *
	   		 * @param String $str
	   		 * @return string $url
	   		 */
	   		function _get_text($str){
	   			return $this->format_left.$str.$this->format_right;
	   		}
	
	   		/**
	   		 * ��ȡ���ӵ�ַ
	   		 */
	   		function _get_link($url,$text,$style=''){
	   			$style=(empty($style))?'':'class="'.$style.'"';
	   			return '<a '.$style.' href="'.$url.'">'.$text.'</a>';
	   		}
	   		/**
	   		 * ������ʽ
	   		 */
	   		function error($function,$errormsg)
	   		{
	   			die('Error in file <b>'.__FILE__.'</b> ,Function <b>'.$function.'()</b> :'.$errormsg);
	   		}
}
?>