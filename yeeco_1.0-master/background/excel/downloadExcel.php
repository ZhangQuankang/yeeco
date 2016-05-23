<?php	
error_reporting(E_ALL & ~E_NOTICE); 
include 'PHPExcel.php';
include 'PHPExcel/Writer/Excel2007.php';
//或者include 'PHPExcel/Writer/Excel5.php'; 用于输出.xls的
//创建一个excel
$objPHPExcel = new PHPExcel();
//保存excel—2007格式
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//或者$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 非2007格式
$objPHPExcel->setActiveSheetIndex(0); 
	$act_sheet_obj=$objPHPExcel->getActiveSheet(); 
	$act_sheet_obj->setTitle('data'); 
	$act_sheet_obj->getColumnDimension('A')->setWidth(15);
	$act_sheet_obj->getColumnDimension('B')->setWidth(15);
	$act_sheet_obj->setCellValue('A1','姓名');
	$act_sheet_obj->setCellValue('B1','电话'); 
$objWriter->save("易科社团成员添加模板.xlsx");
//直接输出到浏览器
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
header("Pragma: public");
header('Content-Type:application/x-msexecl;name="易科社团成员添加模板.xls"');
header('Content-Disposition:attachment;filename="易科社团成员添加模板.xls"');

$objWriter->save('php://output');

?>