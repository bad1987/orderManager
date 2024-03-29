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

$route['init'] = 'loadarticles/articles';
$route['commandeClient'] = 'ajaxqueries/envoiCommande';
$route['statCommandes'] = 'ajaxqueries/chargerCommande';
$route['statCommandes/(:num)'] = 'ajaxqueries/chargerCommande/$1';
$route['detailcommande/(:num)'] = 'ajaxqueries/chargerLigneCommande/$1';
$route['filterCommandes/(:any)/(:any)'] = 'ajaxqueries/filtrer/$1/$2';
$route['articles/(:num)'] = 'pagination/commandeClient/$1';
$route['articles'] = 'pagination/commandeClient';
$route['commandeclient'] = 'ajaxqueries/commandesClient';

$route['createClient'] = 'ajaxqueries/createClients';
$route['clients'] = 'ajaxqueries/indexClient';
$route['initClients'] = 'admin/initClientSelectTag';

$route['admindashboard'] = 'admin';
$route['admindlogin'] = 'admin/adminLogin';
$route['admindlogout'] = 'admin/adminLogout';
$route['checkadminlogin'] = 'admin/checkLogin';
$route['alteruser'] = 'admin/alter';
$route['searchuser'] = 'admin/search';
$route['saveModifiedRecord'] = 'admin/modifiedRecord';
$route['update'] = 'admin/showUpdatePage';
$route['updateArticles'] = 'admin/updateArticles';
$route['history/(:num)'] = 'admin/index/$1';
$route['history'] = 'admin/index';
$route['articleimage'] = 'admin/setArticleImage';
$route['setartimage'] = 'admin/setArticleImage';
$route['promotions']  = 'promo';
$route['toutespromo'] = 'Promo/toutePromo';
$route['detailpromo/(:any)'] = 'Promo/detailPromo/$1';
$route['newpromo'] = 'Promo/newPromo';
$route['editpromo'] = 'Promo/editPromo';
$route['fetchPromo/(:any)'] = 'Promo/fetchPromo/$1';
$route['saveEditedPromo'] = 'Promo/saveEditedPromo';
$route['pagination/(:any)/(:any)'] = 'listing_articles/listingPaginated/$1/$2';
$route['pagination/(:any)'] = 'listing_articles/listingPaginated/$1';
$route['interrupt'] = 'rupture';
$route['validateinterrupt'] = 'rupture/miseajour';

$route['createclient'] = 'espaceclient/registration';
$route['validateRegister'] = 'espaceclient/Validategistration';
$route['login'] = 'espaceclient/userlogin';
$route['validatelogin'] = 'espaceclient/validatelogin';
$route['dashboard'] = 'listing_articles/listing';
$route['logout'] = 'espaceclient/userlogout';
$route['home'] = 'listing_articles/listing';
$route['filter/(:any)'] = 'listing_articles/listing/$1';
$route['default_controller'] = 'listing_articles/listing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
