<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = 'Page_404';
$route['translate_uri_dashes'] = FALSE;

$route['Page-Unauthorized']									= 'Page_403';
$route['Setup-Data/Bank']									= 'Bank';
$route['Setup-Data/Biaya-Sales']							= 'Sales_cost';
$route['Setup-Data/Divisi']									= 'Division';
$route['Setup-Data/Hadiah']									= 'Gift';
$route['Setup-Data/Kendaraan']								= 'Vehicle';
$route['Setup-Data/Merk']									= 'Brand';
$route['Setup-Data/Oprasional']								= 'Oprational';
$route['Setup-Data/Wilayah']								= 'City';
$route['Master-Data/Karyawan']								= 'Employee';
$route['Master-Data/Partner']								= 'Partner';
$route['Master-Data/Sales']									= 'Sales';
$route['Master-Data/Barang']								= 'Item';
$route['Master-Data/Gudang']								= 'Warehouse';
$route['Master-Data/Promo']									= 'Promotion';
$route['Master-Data/Customer']								= 'Customer';
$route['Master-Data/Coa']									= 'Coa';	
$route['Setting/Type-User']									= 'User_type';
$route['Setting/User']										= 'User';
$route['Transaksi/Nota']									= 'Nota';
$route['Transaksi/Delivery-Order']							= 'Delivery';
$route['Transaksi/Mandor-Gudang']							= 'Foreman';

$route['Transaksi/Pembelian']								= 'Purchase';
$route['Transaksi/Penerimaan-Barang']						= 'Reception';
$route['Transaksi/Return']									= 'Retur';
$route['Transaksi/Kas']										= 'Cash';
$route['Transaksi/Cost-Sales']								= 'Transales';
$route['Transaksi/Pengeluaran-Operasional']					= 'Spending';
$route['Transaksi/Retur-Customer']							= 'Retur_cus';
$route['Transaksi/Stok-Opname']								= 'Stokopname';