<?php 
class test{
	
	function aaa(){
		
		echo"���ԣ�";
	}
	
}

$test=new test();


class test1{
	function zzz($test){
		$test->aaa();
		
	}
	
}

$test1=new test1();
echo $test1->zzz($test);
?>