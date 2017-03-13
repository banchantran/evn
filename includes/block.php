<?php
//	Chuc nang chinh  	: 	Cau hinh cac trang
global $block_center;
global $databases;

//Upload anh
$block_center['upload_image']['layout'] = 'admin/blank.php';
$block_center['upload_image']['module'] = array('0'=>'modules/upload/image/');

//Upload tai lieu
$block_center['upload_link']['layout'] = 'admin/blank.php';
$block_center['upload_link']['module'] = array('0'=>'modules/upload/document/');

//Upload media
$block_center['upload_flash']['layout'] = 'admin/blank.php';
$block_center['upload_flash']['module'] = array('0'=>'modules/upload/media/');

//Thoat
$block_center['sign_out']['layout'] = 'admin/blank.php';
$block_center['sign_out']['module'] = array('0'=>'modules/user/user_sign_out/');

//Trang quan tri nguoi dung
$block_center['user_admin']['layout'] = 'admin/admin.php';
$block_center['user_admin']['module'] = array('0'=>'modules/user/user_admin/');

//Trang phan quyen nguoi quan tri
$block_center['permission_admin']['layout'] = 'admin/admin.php';
$block_center['permission_admin']['module'] = array('0'=>'modules/user/permission/');

//Trang ca nhan
$block_center['profile']['layout'] = 'admin/admin.php';
$block_center['profile']['module'] = array('0'=>'modules/user/user_profile/');

//Trang detail
$block_center['detail_admin']['layout'] = 'admin/admin.php';
$block_center['detail_admin']['module'] = array('0'=>'modules/detail/admin/');

//Trang articles_list
$block_center['articles_category_admin']['layout'] = 'admin/admin.php';
$block_center['articles_category_admin']['module'] = array('0'=>'modules/articles/category_admin/');

// Trang quan tri Articles
$block_center['articles_admin']['layout'] = 'admin/admin.php';
$block_center['articles_admin']['module'] = array('0'=>'modules/articles/admin/');

//Trang News
$block_center['news_category_admin']['layout'] = 'admin/admin.php';
$block_center['news_category_admin']['module'] = array('0'=>'modules/news/category_admin/');

// Trang News 
$block_center['news_admin']['layout'] = 'admin/admin.php';
$block_center['news_admin']['module'] = array('0'=>'modules/news/admin/');

//Category
$block_center['category_admin']['layout'] = 'admin/admin.php';
$block_center['category_admin']['module'] = array('0'=>'modules/category/');

// Trang quan tri Articles
$block_center['products_services_admin']['layout'] = 'admin/admin.php';
$block_center['products_services_admin']['module'] = array('0'=>'modules/products_services/category_admin/');

// Trang quan tri Articles
$block_center['products_services_detail_admin']['layout'] = 'admin/admin.php';
$block_center['products_services_detail_admin']['module'] = array('0'=>'modules/products_services/admin/');

//Trang quan tri email
$block_center['email_admin']['layout'] = 'admin/admin.php';
$block_center['email_admin']['module'] = array('0'=>'modules/email/');

//Quan tri lien he
$block_center['contact_admin']['layout'] = 'admin/admin.php';
$block_center['contact_admin']['module'] = array('0'=>'modules/contact/contact/admin/');

//Quan tri thong tin lien he
$block_center['contact_info_admin']['layout'] = 'admin/admin1.php';
$block_center['contact_info_admin']['module'] = array('0'=>'modules/contact/contact_info/admin/');

//Quan tri link
$block_center['link_admin']['layout'] = 'admin/admin1.php';
$block_center['link_admin']['module'] = array('0'=>'modules/link/admin/');

//Quan tri noi dung footer
$block_center['footer_admin']['layout'] = 'admin/admin1.php';
$block_center['footer_admin']['module'] = array('0'=>'modules/footer/admin/');

//Quan tri noi dung footer
$block_center['block_admin']['layout'] = 'admin/admin1.php';
$block_center['block_admin']['module'] = array('0'=>'modules/block/');

//Quan tri banner mid
$block_center['banner_mid_admin']['layout'] = 'admin/admin1.php';
$block_center['banner_mid_admin']['module'] = array('0'=>'modules/banner/admin_banner_mid/');
//Quan tri banner mid
$block_center['adv_admin']['layout'] = 'admin/admin1.php';
$block_center['adv_admin']['module'] = array('0'=>'modules/adv/admin/');


//************************************************************************************
//Trang chu
$block_center['home']['layout'] = 'index.php';
$block_center['home']['module'] = array();

//trang chi tiet bai viet
$block_center['detail']['layout'] = 'category.php';
$block_center['detail']['module'] = array('0'=>'template/detail/');

//trang san pham va dich vu
$block_center['products_services_cat1']['layout'] = 'category.php';
$block_center['products_services_cat1']['module'] = array('0'=>'template/products_services/category1/');

//trang san pham va dich vu
$block_center['products_services_cat2']['layout'] = 'category.php';
$block_center['products_services_cat2']['module'] = array('0'=>'template/products_services/category2/');

//trang san pham va dich vu
$block_center['products_services_cat3']['layout'] = 'category.php';
$block_center['products_services_cat3']['module'] = array('0'=>'template/products_services/category3/');

//trang san pham va dich vu
$block_center['products_services_detail']['layout'] = 'category.php';
$block_center['products_services_detail']['module'] = array('0'=>'template/products_services/detail/');

//trang danh muc bai viet
$block_center['articles_category']['layout'] = 'category.php';
$block_center['articles_category']['module'] = array('0'=>'template/articles/category/');

//trang chi tiet cua danh muc bai viet
$block_center['articles_detail']['layout'] = 'category.php';
$block_center['articles_detail']['module'] = array('0'=>'template/articles/detail/');

//trang danh muc tin
$block_center['news_category']['layout'] = 'category.php';
$block_center['news_category']['module'] = array('0'=>'template/news/category/');

//trang danh muc tin
$block_center['news_sub_category']['layout'] = 'category.php';
$block_center['news_sub_category']['module'] = array('0'=>'template/news/sub_category/');

//trang chi tiet cua danh muc tin
$block_center['news_detail']['layout'] = 'category.php';
$block_center['news_detail']['module'] = array('0'=>'template/news/detail/');

//Trang dang nhap
$block_center['sign_in']['layout'] = 'category.php';
$block_center['sign_in']['module'] = array('0'=>'modules/user/user_sign_in/');

//Trang contact_us
$block_center['contact_us']['layout'] = 'category.php';
$block_center['contact_us']['module'] = array('0'=>'template/contact_us/');

//Trang sitemap
$block_center['sitemap']['layout'] = 'category.php';
$block_center['sitemap']['module'] = array('0'=>'template/sitemap/');

//Trang search
$block_center['search']['layout'] = 'category.php';
$block_center['search']['module'] = array('0'=>'template/search/process/');
?>