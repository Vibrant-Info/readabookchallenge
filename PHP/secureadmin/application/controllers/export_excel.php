<?php 
include_once("Excel.php");
error_reporting(1);
$ttt = "xls";

if ($ttt == "xls") {
 $xlshead=pack("s*", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
 $xlsfoot=pack("s*", 0x0A, 0x00);
 function xlsCell($row,$col,$val) {
  $len=strlen($val);
  return pack("s*",0x204,8+$len,$row,$col,0x0,$len).$val;
 }

$title = "JustDial";


ob_start();
$xls = new Excel($title);
$xls->top();
$xls->home();

$xls->label("Name");$xls->right();$xls->label("Address");$xls->right();$xls->label("Contact Number");$xls->right();$xls->label("Email Address");$xls->right();$xls->label("WebSite");$xls->right();$xls->label("Year Established");$xls->right();$xls->label("Categories");$xls->right();$xls->label("Services");$xls->right();

	$xls->home();
	$xls->down();


 foreach ($res as $cs)
{
	
	$xls->label($cs['name']);$xls->right();$xls->label($cs['address']);$xls->right();$xls->label($cs['Contact_number']);$xls->right();$xls->label($cs['email']);$xls->right();$xls->label($cs['website']);$xls->right();$xls->label($cs['year_established']);$xls->right();$xls->label($cs['categories']);$xls->right();$xls->label($cs['services']);$xls->right();

	$xls->home();
	$xls->down();
};

$data = ob_get_clean();
$xls->send();

}
?>