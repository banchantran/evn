<?php
//	Chuc nang chinh  	: 	Cau hinh he thong
global $download_cat;
$download_cat = array(
	"1"=> _ALL,
	"2"=> _PERSONAL_CUSTOMERS,
	"3"=> _BUSINES_CUSTOMERS,
	"4"=> _ELECTRONIC_BANKING,
	"5"=> _PRODUCTS_SERVICES
);
global $permission;
$permission = array(
	"1"=>"User",
	"2"=>"Content management",
	"3"=>"Admin"
);

if(file_exists(ROOT_PATH."includes/database.php")){
	require_once(ROOT_PATH."includes/database.php");
}else{
	echo _ERROR_CONNECT_DATABASE;
	exit();
}

global $database;
$database = new database('localhost', 'root', '', 'evnfc_acsdb');
require_once(ROOT_PATH."includes/block.php");

if(file_exists(ROOT_PATH."includes/core.php")){	
	require_once(ROOT_PATH."includes/core.php");
}else{
	echo _CANNOT_FIND_CORE;
	exit();
}
get_layout_file();
$database->close();
?>