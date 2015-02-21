<?php
/**
 * User: Samuel
 * Date: 1/22/2015
 * Time: 2:28 PM
 */


use Sm\Core\App;
use Sm\Core\File\File;
use Sm\Database\SqlModel;
use Sm\Storage\Session;
use Sm\Core\Autoload;           use Sm\Core\Backend;    use Sm\Development\Benchmark;
use Sm\Core\Response;           use Sm\Core\Route;      use Sm\Core\URI;
use Sm\Core\Util;               use Sm\Core\View;       use Sm\Security\Clean;

require __DIR__.'/Sm/Core/Abstraction/AutoloadInterface.php';
require __DIR__.'/Sm/Core/Autoload.php';
require __DIR__.'/Sm/Core/Abstraction/IoC.php';

define('BASE_PATH', __DIR__.'/');
define('SCRIPT_PATH', BASE_PATH . 'app/scripts/');
define('USER_PATH', dirname(__DIR__).'/SmSiteNewUser/');
define('VIEW_PATH', __DIR__.'/app/view/');
define('MAIN_URL',  'http://localhost/SmSiteNew/');
define('PACKAGE_URL', MAIN_URL.'packages/');

define('RESOURCE_URL',  MAIN_URL.'p/');
define('RESOURCE_PATH', BASE_PATH.'p/');

define('SM_IMAGE_PROFILE', 1);
define('SM_IMAGE_SIZE_REGULAR', 1);


Sm\Core\Abstraction\IoC::$autoload  = Autoload::instance()->register();
Sm\Core\Abstraction\IoC::$view      = new View();
Sm\Core\Abstraction\IoC::$backend   = new Backend();
Sm\Core\Abstraction\IoC::$response  = new Response();
Sm\Core\Abstraction\IoC::$util      = new Util();
Sm\Core\Abstraction\IoC::$session   = new Session();
Sm\Core\Abstraction\IoC::$route     = new Route();
Sm\Core\Abstraction\IoC::$benchmark = new Benchmark();
Sm\Core\Abstraction\IoC::$filter    = new Clean();
Sm\Core\Abstraction\IoC::$uri       = new URI();
Sm\Core\Abstraction\IoC::$sql_model = new SqlModel();
Sm\Core\Abstraction\IoC::$file = new File();

Sm\Core\Abstraction\IoC::$benchmark->mark('start');

App::boot();


App::add_hook('pre_controller', function(){});
$routing =
[
    ['/p/{_method}/{file}', 'public@@css',  ['{file}'=>'[a-zA-Z0-9_.-]+']],
    ['/user/{_method}',     'user@index',   []], ['/base/{_method}', 'Base@index', []], ['/logout', 'user@logout', []], ['/user/view/{view}', 'user@view', ['{view}' => '[A-z]+']], ['/me', 'user@me', []], ['/msg/{message}/{code}', 'response@controller', ['{message}' => '[\d]+']], ['/', 'Base@index', []], ['/test/{_method}', 'test@index', []]
];
foreach ($routing as $route) {
    Sm\Core\Abstraction\IoC::$route->add_route($route[0],$route[1],$route[2]);
}
Sm\Core\Abstraction\IoC::$view->create('home');
Sm\Core\Abstraction\IoC::$route->uri_match(URI::get_uri_string());

session_cache_limiter('none');
header('Cache-control: max-age='.(60*60*24*365));
header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*365));
App::run();
