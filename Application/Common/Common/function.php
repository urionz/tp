<?php

//日期转为时间戳
function mk_time($time){
	if($time != null){
		$year=((int)substr($time,0,4));//取得年份
		$month=((int)substr($time,5,2));//取得月份
		$day=((int)substr($time,8,2));//取得几号
		return mktime(0,0,0,$month,$day,$year);
	}else
	return $time;
}

/*******权限验证***
 * $rule:权限名
*/
function auth_check($rule){
	C('UID',session('uid'));//当前登录用户的id
	$auth = new \Think\Auth();
	//贷款申请访问权限
	if(!$auth->check($rule,C(UID)) && C(UID) != 1){
		return false;
	}else
		return true;
}

/**
 * 备注截取
 */
function SubTitle($content)
{
	if(mb_strlen($content,'utf-8')>6)
		$content=mb_substr($content, 0,6,'utf-8').'....';
	return $content;
}




//excel导出下载
function download($rs,$cellTitle,$keyName,$xlsName)
{
	import("Org.Util.PHPExcel");
	import("Org.Util.PHPExcel.Writer.Excel5");
	import("Org.Util.PHPExcel.IOFactory.php");
	$objPHPExcel = new \PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");
	
	$i=2;

	$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
	$cellCount=count($cellTitle);
	for($j=0;$j<$cellCount;$j++)
	{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$j].'1', $cellTitle[$j]);
	}
	
	foreach($rs as $k=>$v)
	{
		for($m=0;$m<$cellCount;$m++)
		{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$m].$i, $v[$keyName[$m]]);
		}
		$i++;
	}
	$objPHPExcel->getActiveSheet()->setTitle('student');//设置sheet标签的名称
	$objPHPExcel->setActiveSheetIndex(0);
	ob_end_clean();  //清空缓存 
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header('Content-Disposition:attachment;filename='.$xlsName.'.xls');//设置文件的名称
	header("Content-Transfer-Encoding:binary");
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}

//二维数组排序
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){ 
	if(is_array($multi_array))
	{ 
		foreach ($multi_array as $row_array)
		{ 
			if(is_array($row_array))
			{ 
				$key_array[] = $row_array[$sort_key]; 
			}
			else
			{ 
				return false; 
			} 
		} 
	}
	else
	{ 
		return false; 
	} 
	array_multisort($key_array,$sort,$multi_array); 
	return $multi_array; 
} 

?>
