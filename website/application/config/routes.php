<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site/welcome";
$route['404_override'] = '';
$route['admin'] = "admin/welcome";
$route['site'] = "site/welcome";

$route['register'] = "site/register";
$route['register/(:any)'] = 'site/register/$1';

$route['login'] = "site/login";
$route['login/(:any)'] = 'site/login/$1';

$route['news'] = "site/news";
$route['news/(:any)'] = 'site/news/$1';

$route['notepad'] = "site/notepad";
$route['notepad/(:any)'] = 'site/notepad/$1';

$route['contact'] = "site/contact";
$route['contact/(:any)'] = 'site/contact';


$route['member'] = "site/order/history";
$route['member/(:any)'] = 'site/member/$1';

$route['market'] = "site/market/category";
$route['market/(:any)'] = 'site/market/$1';

$route['order'] = "site/order";
$route['order/(:any)'] = 'site/order/$1';

$route['news/promotion'] = "site/page/preview/promotion";
$route['news/promotion/(:any)']         = 'site/page/preview/promotion';
$route['admin/news/promotion']          = 'admin/page/preview/promotion';
$route['admin/news/promotion/(:any)']   = 'admin/page/preview/promotion';

$route['admin/notepad/(:any)'] = 'admin/page/preview/$1';
$route['notepad/farm_village'] = 'site/page/preview/farm_village';
$route['notepad/growing'] = 'site/page/preview/growing';
$route['notepad/process'] = 'site/page/preview/process';
$route['notepad/farmer'] = 'site/page/preview/farmer';
$route['notepad'] = 'site/page/preview/farm_village';
$route['notepad/vegetable'] = 'site/notepad/vegetable';
$route['notepad/vegetable/(:num)/(:num)'] = 'site/notepad/vegetable/$1/$2';

$route['seasonal'] = "site/page/preview/seasonal";
$route['seasonal/(:any)'] = "site/page/preview/seasonal";

$route['admin/seasonal'] = 'admin/page/preview/seasonal';
$route['admin/seasonal/(:any)'] = 'admin/page/preview/seasonal';

$route['brand'] = 'site/brand';
$route['brand/(:any)'] = 'site/brand/index/$1';


//$route['(:any)'] = "site/$1";
$route['logout'] = "site/logout";

/* End of file routes.php */
/* Location: ./application/config/routes.php */