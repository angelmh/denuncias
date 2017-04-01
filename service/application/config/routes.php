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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['reportes']['get'] = "reportes/index";
$route['reportes/(:num)']['get'] = "reportes/find/$1";
$route['reportes/(:num)']['get'] = "reportes/estado/$1";
$route['reportes/(:num)']['get'] = "reportes/reportescategoria/$1";
$route['reportes/(:num)']['get'] = "reportes/categorias";
$route['reportes/(:num)']['get'] = "reportes/categoria_sub/$1";
$route['reportes/(:num)']['get'] = "reportes/sub_categorias/$1";
$route['reportes/(:num)']['get'] = "reportes/subcategorias";
$route['reportes/(:num)']['get'] = "reportes/colonias";
$route['reportes/(:num)']['get'] = "reportes/calles";
$route['reportes/(:num)']['get'] = "reportes/direccion/$1/$1";
$route['reportes']['post'] = "reportes/votar";
$route['reportes']['post'] = "reportes/imagen";
$route['reportes']['post'] = "reportes/reporte";
$route['reportes/(:num)']['put'] = "reportes/cancelarvoto";
$route['reportes/(:num)']['delete'] = "reportes/index/$1";

$route['usuarios']['get'] = "usuarios/index";
$route['usuarios/(:num)']['get'] = "usuarios/find/$1";
$route['usuarios']['post'] = "usuarios/index";
$route['usuarios/(:num)']['put'] = "usuarios/index/$1";
$route['usuarios/(:num)']['delete'] = "usuarios/index/$1";

$route['ciudadano']['get'] = "ciudadano/index";
$route['ciudadano/(:num)']['get'] = "ciudadano/find/$1";
$route['ciudadano/(:num)']['delete'] = "ciudadano/index/$1";

$route['trabajador']['get'] = "trabajador/index";
$route['trabajador/(:num)']['get'] = "trabajador/find/$1";
$route['trabajador/(:num)']['delete'] = "trabajador/index/$1";

$route['Auth']['post'] = "auth/index";
$route['Auth']['post'] = "auth/usertrabajador";
$route['Auth/(:num)']['get'] = "auth/find/$1";



$route['votos']['get'] = "votos/index";
$route['votos/(:num)']['get'] = "votos/reporte/$1/$1";
$route['votos/(:num)']['get'] = "votos/cantidad/$1";
$route['votos/(:num)']['get'] = "votos/votoscategoria/$1";
$route['votos/(:num)']['put'] = "reportes/actualizarvoto";