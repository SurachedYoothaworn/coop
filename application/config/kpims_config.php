<?php
// set path zone
$config['template_path'] = 'assets/';	
$config['uploads_dir'] = 'uploads/';
// end set path zone

// set data for start system  zone
$config['title_system'] = 'KPIMS';
$config['title_system_full'] = 'Key Performance Indicator Management System';
$config['title_sub_system'] = '';
$config['title_system_th'] = 'ระบบบันทึกข้อมูลตัวชี้วัด';
$config['title_web'] = 'KPIMS | ระบบบันทึกข้อมูลตัวชี้วัด';
$config['org_name'] = '';
$config['title_header'] = 'KPIMS';
// end set data for start system  zone

$config["kpims_dbname"] = "kpims"; // ชื่อฐานข้อมูล kpims
$config["kpims_prefix"]	= "kpi_";

//ปุ่ม
$config["btn_primary"]	= "btn btn-primary";
$config["btn_warning"]	= "btn btn-warning";
$config["btn_danger"]	= "btn btn-danger";
$config["btn_success"]	= "btn btn-success";

//สิทธิ์การเข้าถึง
$config["ref_ug_admin"]	= 1; //ผู้พัฒนาระบบ
$config["ref_ug_staff"]	= 2; // เจ้าหน้าที่ดูแลระบบ
$config["ref_ug_main_side"]	= 3; //หัวหน้าฝ่ายงาน
$config["ref_ug_lab"]	= 4; //เจ้าหน้าที่ระดับปฏิบัติการ


?>