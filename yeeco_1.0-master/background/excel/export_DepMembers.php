<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
include 'PHPExcel.php';
include 'PHPExcel/Writer/Excel2007.php';
$sId=$_POST['sId'];
$depName=$_POST['dep'];
//查询社团名字
$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$sId'"));
$sName=$sName['sName'];
//或者include 'PHPExcel/Writer/Excel5.php'; 用于输出.xls的
//创建一个excel
$objPHPExcel = new PHPExcel();
//保存excel—2007格式
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//或者$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 非2007格式
$objPHPExcel->setActiveSheetIndex(0); 
	$act_sheet_obj=$objPHPExcel->getActiveSheet(); 
	$act_sheet_obj->setTitle('data'); 
	$act_sheet_obj->mergeCells('A1:F1');
	$act_sheet_obj->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$act_sheet_obj->getColumnDimension('A')->setWidth(15);
	$act_sheet_obj->getColumnDimension('C')->setWidth(15);
	$act_sheet_obj->getColumnDimension('D')->setWidth(15);
	$act_sheet_obj->getColumnDimension('E')->setWidth(15);
	$act_sheet_obj->getColumnDimension('F')->setWidth(15);
	$act_sheet_obj->setCellValue('A1',$sName.'成员列表');
	$act_sheet_obj->setCellValue('A2','姓名');
	$act_sheet_obj->setCellValue('B2','性别'); 
	$act_sheet_obj->setCellValue('C2','电话'); 
	$act_sheet_obj->setCellValue('D2','专业班级'); 
	$act_sheet_obj->setCellValue('E2','所属部门'); 
	$act_sheet_obj->setCellValue('F2','职位');
	$k=3;
	for($i=0;$i<=sizeof($depName)-1;$i++){
		if($depName[$i]=='未分配'){
			$depName[$i]=0;	
		}
		//根据部门名称和社团ID找到用户ID
		$query=mysql_query("select userId,position from user_society_relation where societyId='$sId' and depBelong='$depName[$i]'");
		if($query && mysql_num_rows($query)){
			while($row = mysql_fetch_assoc($query)){
				$uIds[]=$row;
			}			
		}
		if($uIds){
			foreach($uIds as $value){
				$userInfo=mysql_fetch_assoc(mysql_query("select userName,userTel,userSex,userClass from userextrainfo where uId=$value[userId]"));
				$act_sheet_obj->setCellValue('A'.$k,$userInfo['userName']);
				$act_sheet_obj->setCellValue('B'.$k,$userInfo['userSex']);
				$act_sheet_obj->setCellValue('C'.$k,$userInfo['userTel']);
				$act_sheet_obj->setCellValue('D'.$k,$userInfo['userClass']); 
				$act_sheet_obj->setCellValue('E'.$k,$depName[$i]===0?'未分配':$depName[$i]); 
				$act_sheet_obj->setCellValue('F'.$k,$value['position']);
				$k++;
			}
		}
		$uIds=NULL;
	}
$objWriter->save("社团成员列表.xlsx");
//直接输出到浏览器
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
header("Pragma: public");
header('Content-Type:application/x-msexecl;name="社团成员列表.xls"');
header('Content-Disposition:attachment;filename="社团成员列表.xls"');
$objWriter->save('php://output');
?>