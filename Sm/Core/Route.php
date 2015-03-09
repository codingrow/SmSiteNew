<?php
/**
 * ::req::Sm\Core\Util:
 * User: Samuel
 * Date: 1/22/2015
 * Time: 11:18 PM
 */

namespace Sm\Core;
use Sm\Core\Abstraction\IoC;

/**
 * Class Route
 * @package Sm\Core
 */
class Route {
    /**
     * @var array Array of the available routes added
     */
    static $routes      = [];
    /**
     * @var array Named routes, unimplemented now
     */
    static $nickname    = [];
    /** @var  callable $callback The function left for us to run*/
    static $callback;
    /**
     * @var array Arguments to be passed to the callback
     */
    static $args        = [];
    static $requested_uri = '';

    /**
     * @return array
     */
    public static function getRoutes() {
        return self::$routes;
    }

    /** Give a nickname to a route.
     * Unimplemented because it would only lead to static pages with the way I have it now,
     * and it isn't worth the thought yet
     * @param $route
     * @param $name
     */
    static function name_route($name, $route){
        static::$nickname[$name] = $route;
    }

    /** Return a route by nickname
     * @param string $nickname The name of the route to be used
     * @param $args
     * @todo implement named routes
     */
    static function get_route($nickname) {
        $route = static::$nickname[$nickname];
        return $route;
    }

    /**Add a route to the existing route array
     * @param array|string $uri_string
     * @param callable|string $callback either a callback or a reference to a controller
     * @param array $where
     */
    static function add_route($uri_string, $callback, $where = []){
        $uri_arr = is_array($uri_string) ? $uri_string : explode('/', ltrim($uri_string, '/'));
        if(empty($uri_arr) || $uri_arr[0] == ''){
            $uri_arr = ['home'];
        }
        #if the callback is not a callable, it is a reference to a controller.
        #Explode at the @ sign, use the first index as the controller and the second index as a method

        $holder_arr = [];
        #Pass is a & to holder_arr, which stores the final nested route result
        $pass =& $holder_arr;
        foreach($uri_arr as $route) {
            if(strpos($route, '{') === 0){
                if($route == '{_method}'){
                    //$method = $route;
                }
                if(isset($where[$route])){
                    $tmp_chk = $where[$route];
                }else{
                    $tmp_chk = '[A-z]*';
                }
                $route = '_'.$route. '|'.$tmp_chk;
            }
            #Add the route as an inner array of $pass
            IoC::$util->add_inner_array($pass, $route);
            #after each loop, $pass becomes a reference to the next lowest array
                #so Util::add_inner_array can do work on that
            $pass =& $pass[$route];
        }
        #the last element in the holder array becomes the value of the callback
        $pass = $callback;
        reset($holder_arr);
        $arr = static::$routes;
        #based on the first letter of the first value of the holder_array, set the array for the holder to be added to
        #this will correspond to the alphabet starting at 'a' == 0
        $index =  ord(key($holder_arr)[0]) - 97;
        #if the index is not at least 'a', the index will be that of the Wildcard standing [unimplemented]
        $index = $index>=0 ? $index : 25;
        #create the index if nonexistant
        if(!isset($arr[$index])){
            $arr[$index] = [];
        }
        #add the Created route array to the pre-existing route array at the specified index
        $tmp = array_merge_recursive($holder_arr, $arr[$index]);
        $arr[$index] = $tmp;
        #Sort he array to alleviate any possible confusion
        IoC::$util->recursive_ksort($arr);
        static::$routes = $arr;
    }

    /** Find a callable in the route best matching the one provided
     * @param array    $needle_array The array containing the value we are to next search for
     * @param array    $haystack_array The array containing potential matches
     * @param callable $best_matching_callback The callback that matches the URI in question the best(so far in the loop)
     * @param array    $args The arguments to later be passed on to the callback
     */
    static function find_callback(&$needle_array, $haystack_array, &$best_matching_callback = null, &$args = [], &$other = []){
        foreach ($haystack_array as $index => $value) {
            if (!isset($needle_array[0]))
                break;
            if (is_numeric($index)) {
                if (is_callable($value) || (is_string($value) && strpos($value, '@') != -1)) {
                    $best_matching_callback = $value;
                }
            } else {
                #if the key is of the type {key}, then it is to be used as a variable in the order in which it was found.
                #Add its routed value to the array of arguments if the routed value matches the RegExp in the next part of the data
                if(strpos($index, '_{') === 0 ){
                    $exp = explode('|', $index);
                    if(preg_match('#^' . $exp[1] . '$#', $needle_array[0])){
                        if($exp[0] == '_{_method}'){
                            $other['method'] = $needle_array[0];
                        }else{$args[] = $needle_array[0];}
                    }else{continue;}
                #If there is no match, continue searching for a better matching route
                }elseif (!preg_match('#^' . $index . '$#', $needle_array[0])) {
                    continue;
                }
                if (is_callable($haystack_array[$index]) || (is_string($haystack_array[$index]) && strpos($haystack_array[$index], '@') != -1)) {
                    $best_matching_callback = $haystack_array[$index];
                    #@TODO solve the problem that when there is another rule that comes after a method route, the method gets overwritten or a method from a previous rule is used
                    if(strpos($haystack_array[$index], '@@') === -1){
                        $other['method'] = null;
                    }
                } elseif (is_array($haystack_array[$index])) {
                    array_shift($needle_array);
                    static::find_callback($needle_array, $haystack_array[$index], $best_matching_callback, $args, $other);
                }

            }
        }
    }

    /** Get Callback and Args
     * #INTERFACE FUNCTION
     * @return array The callback along with the arguments to be used
     */
    static function get_callback(){
        return [static::$callback, static::$args];
    }

    /** Matches a URI to a route
     * @param string|array $uri The URI in question
     * @return callable
     */
    static function uri_match($uri){
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, "?"));
        }
        static::$requested_uri = $uri;
        $uri_array = is_array($uri) ? $uri : explode('/', rtrim($uri, '/'));
        if(empty($uri_array) || $uri_array[0] == ''){
            $uri_array = ['home'];
        }
        #Just in case anything happened, sort the routes
        //Util::recursive_ksort(static::$routes);
##DEFAULT ROUTE DONE HERE; CONSIDER MOVING LOCATION
        $callback = function(){
            IoC::$response->redirect(IoC::$uri->url('msg/404/' . static::$requested_uri));
            return static::$requested_uri;
        };
        $arr_search = [];
        #if there is 1<= routes that begin with the same letter as the uri in question, search through that route
##IF TO IMPLEMENT WILDCARD ROUTE, DO IT HERE
        if (isset(static::$routes[ord($uri_array[0][0])-97])){
            $arr_search = static::$routes[ord($uri_array[0][0])-97];
        }
        $args = [];
        $other = [];
        static::find_callback($uri_array, $arr_search, $callback, $args, $other);

        if(is_string($callback)){
            static::$callback  = function() use($callback, $other){
                $exp = explode('@',$callback);
                $method = (isset($other['method'])) ? $other['method'] : $exp[1];
                $exp[0] = 'Controller\\'.$exp[0];
                $exp[0] .= 'Controller';
                $class = $exp[0];
                if (method_exists($class, $method) && is_callable(array($class, $method))){
                    $result = call_user_func_array([new $class, $method], func_get_args());
                }else {
                    $result = call_user_func_array([new $class, $exp[1]], func_get_args());
                }
                return $result;
            };
        }else{
            static::$callback = $callback;
        }

        #anything after the route-specified uri will be passed as an argument to the controller after the $args already found
        if(!empty($uri_array)){
            array_shift($uri_array);
        }
        static::$args = array_merge($args, $uri_array);
        return static::$callback;
    }
}