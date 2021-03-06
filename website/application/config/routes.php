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
$route['welcome'] = "site/welcome";
$route['welcome/(:any)'] = 'site/welcome/$1';
$route['home'] = "site/home";
$route['home/(:any)'] = 'site/home/$1';
$route['login'] = "site/login";
$route['login/(:any)'] = 'site/login/$1';

$route['logout'] = "site/logout";

$route['register'] = "site/register";
$route['register/(:any)'] = 'site/register/$1';

$route['account'] = "site/account";
$route['account/(:any)'] = 'site/account/$1';

$route['message'] = "site/message";
$route['message/(:any)'] = 'site/message/$1';

$route['mywish'] = "site/mywish";
$route['mywish/(:any)'] = 'site/mywish/$1';

$route['chat'] = "site/chat";
$route['chat/(:any)'] = 'site/chat/$1';

$route['fortune'] = "site/fortune";
$route['fortune/(:any)'] = 'site/fortune/$1';

$route['wish'] = "site/wish";
$route['wish/(:any)'] = 'site/wish/$1';

$route['action'] = "site/action";
$route['action/(:any)'] = 'site/action/$1';

$route['subscribe'] = "site/subscribe";
$route['subscribe/(:any)'] = 'site/subscribe/$1';



$route['photo'] = "site/photo/show/public";
$route['photo/public'] = "site/photo/show/public";
$route['photo/private'] = "site/photo/show/private";

$route['photo/(:any)'] = 'site/photo/$1';

$route['view/(:any)'] = 'site/view/index/$1';

$route['admin/member/(:any)'] = 'admin/member/$1';
$route['admin/account/(:any)'] = 'admin/account/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */